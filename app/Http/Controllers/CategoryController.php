<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all parent categories with their active children.
     */
    public function index()
    {
        // Fetch parent categories with active children
        $parentCategories = Category::whereNull('parent_id') // Fetch only parent categories
            ->active() // Scope for active categories
            ->with(['children' => function ($query) {
                $query->active()->orderBy('sort_order')->orderBy('name');
            }])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('parentCategories'));
    }

    /**
     * Display a category detail page with filters & pagination.
     */
    public function show(Request $request, $slug)
    {
        // Fetch category by slug and ensure it's active
        $category = Category::where('slug', $slug)->active()->firstOrFail();

        // Build product query for this category and its subcategories
        $query = Product::query()
            ->where('category_id', $category->id) // Products directly in this category
            ->orWhereIn('category_id', $category->children()->pluck('id')) // Products in subcategories
            ->with('category') // Eager load category relationship
            ->active(); // Scope for active products

        // --- Filtering ---
        // Search in category
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%")
                    ->orWhere('short_description', 'like', "%{$searchTerm}%");
            });
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Subcategory filter
        if ($request->filled('subcategory')) {
            $subcategory = Category::where('slug', $request->subcategory)->active()->first();
            if ($subcategory) {
                $query->where('category_id', $subcategory->id);
            }
        } elseif ($request->filled('category')) {
            $dropdownCategory = Category::where('slug', $request->category)->active()->first();
            if ($dropdownCategory) {
                $query->where('category_id', $dropdownCategory->id);
            }
        }

        // --- Sorting ---
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
            default:
                $query->latest();
        }

        // Paginate products
        $products = $query->paginate(12)->withQueryString();

        // Subcategories
        $subcategories = $category->children()->active()->orderBy('sort_order')->get();

        // Breadcrumbs
        $breadcrumb = [];
        $currentCategory = $category;
        while ($currentCategory) {
            $breadcrumb[] = $currentCategory;
            $currentCategory = $currentCategory->parent;
        }
        $breadcrumb = array_reverse($breadcrumb);

        // Global category dropdown in top bar
        $allCategories = Category::active()->orderBy('sort_order')->orderBy('name')->get();

        // Check if no products are found
        $noProducts = $products->isEmpty();

        return view('categories.show', compact(
            'category',
            'products',
            'subcategories',
            'breadcrumb',
            'allCategories',
            'noProducts'
        ));
    }
}