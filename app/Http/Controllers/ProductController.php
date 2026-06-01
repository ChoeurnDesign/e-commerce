<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    private int $defaultPerPage = 12;
    private int $maxPerPage = 60;

    public function index(Request $request)
    {
        $validated = $request->validate([
            'search'     => 'nullable|string|max:120',
            'category'   => 'nullable|string|max:100',
            'min_price'  => 'nullable|numeric|min:0',
            'max_price'  => 'nullable|numeric|min:0',
            'min_rating' => 'nullable|numeric|min:1|max:5',
            'on_sale'    => 'nullable|in:1',
            'sort'       => 'nullable|in:latest,price_low,price_high,name,rating,featured',
            'per_page'   => 'nullable|integer|min:1|max:' . $this->maxPerPage,
        ]);

        $filters = [
            'search'     => $validated['search']     ?? '',
            'category'   => $validated['category']   ?? '',
            'min_price'  => $validated['min_price']  ?? '',
            'max_price'  => $validated['max_price']  ?? '',
            'min_rating' => $validated['min_rating'] ?? '',
            'on_sale'    => $validated['on_sale']    ?? '',
            'sort'       => $validated['sort']       ?? 'latest',
            'per_page'   => $validated['per_page']   ?? $this->defaultPerPage,
        ];

        $perPage = (int) $filters['per_page'];
        if ($perPage > $this->maxPerPage) $perPage = $this->maxPerPage;

        if ($filters['min_price'] !== '' && $filters['max_price'] !== ''
            && (float)$filters['max_price'] < (float)$filters['min_price']) {
            [$filters['min_price'], $filters['max_price']] = [$filters['max_price'], $filters['min_price']];
        }

        if ($filters['category'] !== '' &&
            ! Category::where('slug', $filters['category'])->active()->exists()) {
            $filters['category'] = '';
        }

        $query = Product::query()
            // DO NOT limit columns on seller; just eager load as you do:
            ->with(['category', 'seller'])
            ->withCount(['approvedReviews as reviews_count'])
            ->withAvg('approvedReviews as average_rating', 'rating')
            ->active();

        if ($filters['search'] !== '' && mb_strlen(trim($filters['search'])) >= 2) {
            $tokens = preg_split('/\s+/', trim($filters['search']));
            $query->where(function ($outer) use ($tokens) {
                foreach ($tokens as $term) {
                    $outer->where(function ($q) use ($term) {
                        $like = '%' . $term . '%';
                        if (ctype_digit($term)) {
                            $q->orWhere('id', (int)$term);
                        }
                        $q->orWhere('name', 'like', $like)
                          ->orWhere('sku', 'like', $like)
                          ->orWhere('short_description', 'like', $like);
                    });
                }
            });
        }

        $query->when($filters['category'] !== '', function ($q) use ($filters) {
            $q->whereHas('category', fn($c) => $c->where('slug', $filters['category'])->active());
        });

        if ($filters['min_price'] !== '') {
            $query->where('price', '>=', (float)$filters['min_price']);
        }
        if ($filters['max_price'] !== '') {
            $query->where('price', '<=', (float)$filters['max_price']);
        }

        if ($filters['min_rating'] !== '') {
            $query->having('average_rating', '>=', (float)$filters['min_rating']);
        }

        if ($filters['on_sale'] === '1') {
            $query->where('on_sale', 1)
                  ->whereNotNull('sale_price')
                  ->whereColumn('sale_price', '<', 'price');
        }

        /* Sort options.  Each sort also alternates by seller_id so multi-seller
           listings of the same product don't visually cluster — instead they
           spread across the page like a real marketplace. */
        switch ($filters['sort']) {
            case 'price_low':
                $query->orderBy('price', 'asc')->orderBy('seller_id', 'asc')->orderBy('id', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc')->orderBy('seller_id', 'asc')->orderBy('id', 'asc');
                break;
            case 'name':
                $query->orderBy('name', 'asc')->orderBy('seller_id', 'asc');
                break;
            case 'rating':
                $query->orderByDesc('average_rating')
                      ->orderByDesc('reviews_count')
                      ->orderBy('seller_id', 'asc');
                break;
            case 'featured':
                $query->orderBy('is_featured', 'desc')
                      ->orderByDesc('created_at')
                      ->orderBy('seller_id', 'asc');
                break;
            case 'latest':
            default:
                /* Use seller_id as tiebreaker so same-name multi-seller items
                   don't cluster when their created_at timestamps are nearly
                   identical (common after seeding). */
                $query->orderByDesc('created_at')
                      ->orderBy('seller_id', 'asc')
                      ->orderBy('id', 'asc');
        }

        $products = $query->paginate($perPage)->appends($request->query());

        $categories = Category::active()
            ->select('id','name','slug')
            ->orderBy('name')
            ->get();

        return view('products.index', compact('products', 'categories', 'filters'));
    }

    public function shopsOnSale(Request $request)
    {
        $validated = $request->validate([
            'sort'     => 'nullable|in:price_low,price_high,rating,latest,discount',
            'per_page' => 'nullable|integer|min:1|max:' . $this->maxPerPage,
        ]);

        $sort    = $validated['sort'] ?? 'discount';
        $perPage = (int)($validated['per_page'] ?? $this->defaultPerPage);
        if ($perPage > $this->maxPerPage) $perPage = $this->maxPerPage;

        $query = Product::query()
            ->with(['category', 'seller'])
            ->withCount(['approvedReviews as reviews_count'])
            ->withAvg('approvedReviews as average_rating', 'rating')
            ->active()
            ->where('on_sale', 1)
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price');

        switch ($sort) {
            case 'price_high':
                $query->orderBy('sale_price', 'desc');
                break;
            case 'rating':
                $query->orderByDesc('average_rating')->orderByDesc('reviews_count');
                break;
            case 'latest':
                $query->orderByDesc('created_at');
                break;
            case 'price_low':
                $query->orderBy('sale_price', 'asc');
                break;
            case 'discount':
            default:
                $query->orderByRaw('(price - sale_price) / price DESC');
        }

        $saleProducts = $query->paginate($perPage)->appends($request->query());

        $categories = Category::active()->orderBy('name')->get();

        return view('products.shops-on-sale', compact('saleProducts', 'categories'));
    }

    public function searchSuggestions(Request $request)
    {
        $term = (string) $request->get('q', '');
        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $products = Product::active()
            ->with('seller')
            ->select('id','name','slug','price','image')
            ->where('name','like','%'.$term.'%')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return response()->json($products);
    }

    public function quickView(int $id): JsonResponse
    {
        $product = Product::with(['category', 'seller'])
            ->withCount('approvedReviews')
            ->withAvg('approvedReviews as average_rating', 'rating')
            ->active()
            ->findOrFail($id);

        $inWishlist = Auth::check() && Auth::user()->hasInWishlist($product->id);

        return response()->json([
            'id'              => $product->id,
            'name'            => $product->name,
            'slug'            => $product->slug,
            'url'             => route('products.show', $product->slug),
            'image_url'       => $product->image_url,
            'category'        => $product->category?->name,
            'seller_name'     => $product->seller?->store_name,
            'seller_url'      => $product->seller ? route('stores.show', $product->seller->slug) : null,
            'price'           => $product->price,
            'sale_price'      => $product->sale_price,
            'current_price'   => $product->current_price,
            'on_sale'         => (bool) ($product->on_sale && $product->sale_price),
            'stock_quantity'  => $product->stock_quantity,
            'in_stock'        => $product->stock_quantity > 0,
            'short_description' => $product->short_description
                ? Str::limit(strip_tags($product->short_description), 180)
                : Str::limit(strip_tags($product->description ?? ''), 180),
            'average_rating'  => round((float) ($product->average_rating ?? 0), 1),
            'reviews_count'   => $product->approved_reviews_count ?? 0,
            'is_featured'     => (bool) $product->is_featured,
            'in_wishlist'     => $inWishlist,
        ]);
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'approvedReviews.user', 'seller'])
            ->where('slug',$slug)
            ->active()
            ->firstOrFail();

        $product->increment('page_views', 1, ['updated_at' => $product->updated_at]);

        $relatedProducts = Product::with(['category', 'seller'])
            ->where('category_id', $product->category_id)
            ->where('id','!=',$product->id)
            ->active()
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        $userReview = Auth::check()
            ? $product->approvedReviews()->where('user_id', Auth::id())->first()
            : null;

        return view('products.show', compact('product','relatedProducts','userReview'));
    }

    public function byCategory(string $slug)
    {
        $category = Category::where('slug',$slug)->active()->firstOrFail();

        $products = Product::with(['category', 'seller'])
            ->withCount(['approvedReviews as reviews_count'])
            ->withAvg('approvedReviews as average_rating','rating')
            ->where('category_id',$category->id)
            ->active()
            ->orderByDesc('created_at')
            ->paginate($this->defaultPerPage)
            ->appends(['category' => $slug]);

        return view('products.category', compact('products','category'));
    }
}