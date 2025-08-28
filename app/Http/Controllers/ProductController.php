<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private int $defaultPerPage = 12;
    private int $maxPerPage = 60;

    /**
     * Frontend product listing with filters & sorting.
     */
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

        // Collect filters for view repopulation
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

        // Normalize per_page
        $perPage = (int) $filters['per_page'];
        if ($perPage > $this->maxPerPage) {
            $perPage = $this->maxPerPage;
        }

        // Swap min/max if inverted
        if ($filters['min_price'] !== '' && $filters['max_price'] !== '' &&
            (float)$filters['max_price'] < (float)$filters['min_price']) {
            [$filters['min_price'], $filters['max_price']] = [$filters['max_price'], $filters['min_price']];
        }

        // Optional: ensure category slug exists; if not, blank it (prevents wasted whereHas)
        if ($filters['category'] !== '' &&
            ! Category::where('slug', $filters['category'])->active()->exists()) {
            $filters['category'] = '';
        }

        $query = Product::query()
            ->with(['category'])
            ->withCount(['approvedReviews as reviews_count'])
            ->withAvg('approvedReviews as average_rating', 'rating')
            ->active();

        // Search tokens (AND across tokens); ignore if < 2 chars
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

        // Category filter
        $query->when($filters['category'] !== '', function ($q) use ($filters) {
            $q->whereHas('category', fn($c) => $c->where('slug', $filters['category'])->active());
        });

        // Price filters
        $query->when($filters['min_price'] !== '', fn($q) => $q->where('price', '>=', (float)$q->getModel()->getAttributeFromArray('min_price') ?? (float)request('min_price')));
        // Simpler & explicit instead of above dynamic attempt:
        if ($filters['min_price'] !== '') {
            $query->where('price', '>=', (float)$filters['min_price']);
        }
        if ($filters['max_price'] !== '') {
            $query->where('price', '<=', (float)$filters['max_price']);
        }

        // Rating filter (HAVING on alias)
        if ($filters['min_rating'] !== '') {
            $query->having('average_rating', '>=', (float)$filters['min_rating']);
        }

        // On sale
        if ($filters['on_sale'] === '1') {
            $query->where('on_sale', 1)
                  ->whereNotNull('sale_price')
                  ->whereColumn('sale_price', '<', 'price'); // adjust if compare_price is your original
        }

        // Sorting
        switch ($filters['sort']) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'rating':
                $query->orderByDesc('average_rating')
                      ->orderByDesc('reviews_count');
                break;
            case 'featured':
                $query->orderBy('is_featured', 'desc')
                      ->orderByDesc('created_at');
                break;
            case 'latest':
            default:
                $query->orderByDesc('created_at');
        }

        $products = $query->paginate($perPage)->appends($request->query());

        // Categories (cache optional)
        $categories = Category::active()
            ->select('id','name','slug')
            ->orderBy('name')
            ->get();
        // $categories = cache()->remember('categories.active.list', 1800, fn() =>
        //     Category::active()->select('id','name','slug')->orderBy('name')->get()
        // );

        return view('products.index', compact('products', 'categories', 'filters'));
    }

    /**
     * On-sale products listing.
     */
    public function shopsOnSale(Request $request)
    {
        $validated = $request->validate([
            'sort'     => 'nullable|in:price_low,price_high,rating,latest',
            'per_page' => 'nullable|integer|min:1|max:' . $this->maxPerPage,
        ]);

        $sort    = $validated['sort'] ?? 'price_low';
        $perPage = (int)($validated['per_page'] ?? $this->defaultPerPage);
        if ($perPage > $this->maxPerPage) $perPage = $this->maxPerPage;

        $query = Product::query()
            ->with(['category'])
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
            default:
                $query->orderBy('sale_price', 'asc');
        }

        $saleProducts = $query->paginate($perPage)->appends($request->query());

        $categories = Category::active()->orderBy('name')->get();

        return view('products.shops-on-sale', compact('saleProducts', 'categories'));
    }

    /**
     * Quick async suggestions.
     */
    public function searchSuggestions(Request $request)
    {
        $term = (string) $request->get('q', '');
        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $products = Product::active()
            ->select('id','name','slug','price','image')
            ->where('name','like','%'.$term.'%')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return response()->json($products);
    }

    /**
     * Show product detail.
     */
    public function show(string $slug)
    {
        $product = Product::with(['category','approvedReviews.user'])
            ->where('slug',$slug)
            ->active()
            ->firstOrFail();

        $product->increment('page_views', 1, ['updated_at' => $product->updated_at]);

        $relatedProducts = Product::with('category')
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

    /**
     * Category-specific listing (legacy route).
     */
    public function byCategory(string $slug)
    {
        $category = Category::where('slug',$slug)->active()->firstOrFail();

        $products = Product::with(['category'])
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