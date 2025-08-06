<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a paginated list of products with filters and sorting.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category'])
            ->withCount(['approvedReviews as reviews_count'])
            ->withAvg('approvedReviews as average_rating', 'rating')
            ->active();

        // Filtering
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhere('short_description', 'like', "%{$searchTerm}%");
            });
        }
        // UPDATED: make sure only filter if category exists
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $categoryExists = Category::where('slug', $categorySlug)->exists();
            if ($categoryExists) {
                $query->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            }
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        if ($request->filled('min_rating')) {
            $query->whereHas('approvedReviews', function ($q) use ($request) {
                $q->selectRaw('AVG(rating) as avg_rating')
                    ->groupBy('product_id')
                    ->havingRaw('AVG(rating) >= ?', [$request->min_rating]);
            });
        }
        // On Sale filter
        if ($request->has('on_sale') && $request->on_sale) {
            $query->where('on_sale', 1)
                ->whereNotNull('sale_price')
                ->whereColumn('sale_price', '<', 'compare_price');
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'featured':
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->orderBy('average_rating', 'desc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(9)->withQueryString();
        $categories = Category::active()->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Display products that are currently on sale.
     */
    public function shopsOnSale()
    {
        $saleProducts = Product::with(['category'])
            ->withCount(['approvedReviews as reviews_count'])
            ->withAvg('approvedReviews as average_rating', 'rating')
            ->active()
            ->where('on_sale', 1)
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'compare_price')
            ->orderBy('sale_price', 'asc')
            ->paginate(9);

        $categories = Category::active()->get();

        return view('products.shops-on-sale', compact('saleProducts', 'categories'));
    }

    /**
     * AJAX: Return quick search suggestions for products.
     */
    public function searchSuggestions(Request $request)
    {
        $term = $request->get('q', '');
        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $products = Product::active()
            ->where('name', 'like', "%{$term}%")
            ->select('id', 'name', 'slug', 'price', 'image')
            ->limit(5)
            ->get();

        return response()->json($products);
    }

    /**
     * Show details for a single product, with reviews and related products.
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'approvedReviews.user'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Increment page views (without updating timestamps)
        $product->increment('page_views', 1, ['updated_at' => $product->updated_at]);

        $relatedProducts = Product::with(['category'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->take(4)
            ->get();

        $userReview = null;
        if (Auth::check()) {
            $userReview = $product->approvedReviews()
                ->where('user_id', Auth::id())
                ->first();
        }

        return view('products.show', compact('product', 'relatedProducts', 'userReview'));
    }

    /**
     * Show products by a specific category (deprecated, but supported for deep links).
     */
    public function byCategory($slug)
    {
        $category = Category::where('slug', $slug)->active()->firstOrFail();

        $products = Product::with(['category'])
            ->withCount(['approvedReviews as reviews_count'])
            ->withAvg('approvedReviews as average_rating', 'rating')
            ->where('category_id', $category->id)
            ->active()
            ->latest()
            ->paginate(9);

        return view('products.category', compact('products', 'category'));
    }
}
