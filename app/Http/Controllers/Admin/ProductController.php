<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Seller;
use Illuminate\Http\Request;
use Carbon\Carbon; // Ensure this is imported

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q'            => 'nullable|string|max:120',
            'category_id'  => 'nullable|integer|exists:categories,id',
            'seller_id'    => 'nullable|integer|exists:sellers,id',
            'is_admin'     => 'nullable|in:0,1',
            'is_active'    => 'nullable|in:0,1',
            'on_sale'      => 'nullable|in:0,1',
            'is_featured'  => 'nullable|in:0,1',
            'price_min'    => 'nullable|numeric|min:0',
            'price_max'    => 'nullable|numeric|gte:price_min',
            'stock_min'    => 'nullable|integer|min:0',
            'stock_max'    => 'nullable|integer|gte:stock_min',
            'created_from' => 'nullable|date',
            'created_to'   => 'nullable|date|after_or_equal:created_from',
            'sort'         => 'nullable|string',
            'dir'          => 'nullable|string',
        ]);

        $query = Product::query()->with(['category', 'creator', 'seller']);

        // 1. SEARCH SCOPE
        if ($request->filled('q')) {
            $query->search($request->q);
        }

        // 2. FILTERS
        if ($cid = $request->category_id) {
            $query->where('category_id', $cid);
        }

        // Logic for Admin vs Seller Products
        if ($request->has('is_admin') && $request->is_admin == 1) {
            $query->whereNull('seller_id');
        } elseif ($request->filled('seller_id')) {
            $query->where('seller_id', $request->seller_id);
        }

        foreach (['is_active', 'on_sale', 'is_featured'] as $flag) {
            if ($request->has($flag) && $request->$flag !== '') {
                $query->where($flag, (int)$request->$flag);
            }
        }

        if ($request->filled('price_min')) $query->where('price', '>=', $request->price_min);
        if ($request->filled('price_max')) $query->where('price', '<=', $request->price_max);
        if ($request->filled('stock_min')) $query->where('stock_quantity', '>=', $request->stock_min);
        if ($request->filled('stock_max')) $query->where('stock_quantity', '<=', $request->stock_max);
        
        // --- FIXED DATE FILTERS ---
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', Carbon::parse($request->created_from)->format('Y-m-d'));
        }
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', Carbon::parse($request->created_to)->format('Y-m-d'));
        }

        // Sorting
        $allowedSorts = ['id', 'price', 'created_at', 'stock_quantity'];
        $sort = in_array($request->sort, $allowedSorts, true) ? $request->sort : 'id';
        $dir = in_array(strtolower((string)$request->dir), ['asc', 'desc'], true) ? strtolower($request->dir) : 'desc';
        $query->orderBy($sort, $dir);

        $products = $query->paginate(15)->appends($request->query());
        
        $categories = Category::query()->orderBy('name', 'asc')->get(['id', 'name']);
        $sellers = Seller::query()->orderBy('store_name', 'asc')->get(['id', 'store_name']);

        $filterFields = [
            ['name' => 'q', 'type' => 'text', 'label' => 'Search', 'placeholder' => 'Search products...'],
            ['name' => 'category_id', 'type' => 'select', 'label' => 'Category', 'placeholder' => 'All', 'options' => $categories->pluck('name', 'id')->toArray()],
            ['name' => 'seller_id', 'type' => 'select', 'label' => 'Seller', 'placeholder' => 'All', 'options' => $sellers->pluck('store_name', 'id')->toArray()],
            ['name' => 'is_admin', 'type' => 'boolean', 'label' => 'Admin Only', 'placeholder' => 'Any', 'true_label' => 'Yes', 'false_label' => 'No'],
            ['name' => 'is_active', 'type' => 'boolean', 'label' => 'Status', 'placeholder' => 'Any', 'true_label' => 'Active', 'false_label' => 'Inactive'],
            ['name' => 'on_sale', 'type' => 'boolean', 'label' => 'On Sale', 'placeholder' => 'Any', 'true_label' => 'On Sale', 'false_label' => 'Not On Sale'],
            ['name' => 'is_featured', 'type' => 'boolean', 'label' => 'Featured', 'placeholder' => 'Any', 'true_label' => 'Featured', 'false_label' => 'Not Featured'],
            ['name' => 'price_min', 'type' => 'number', 'label' => 'Min Price', 'placeholder' => 'Min', 'step' => '0.01'],
            ['name' => 'price_max', 'type' => 'number', 'label' => 'Max Price', 'placeholder' => 'Max', 'step' => '0.01'],
            ['name' => 'stock_min', 'type' => 'number', 'label' => 'Min Stock', 'placeholder' => 'Min', 'step' => '1'],
            ['name' => 'stock_max', 'type' => 'number', 'label' => 'Max Stock', 'placeholder' => 'Max', 'step' => '1'],
            ['name' => 'created_from', 'type' => 'date', 'label' => 'From', 'placeholder' => 'From'],
            ['name' => 'created_to', 'type' => 'date', 'label' => 'To', 'placeholder' => 'To'],
        ];

        $filters = $request->only([
            'q', 'category_id', 'seller_id', 'is_admin', 'is_active', 'on_sale', 'is_featured',
            'price_min', 'price_max', 'stock_min', 'stock_max', 'created_from', 'created_to'
        ]);

        $filterAction = route('admin.products.index');

        return view('admin.products.index', compact('products', 'filterFields', 'categories', 'filters', 'filterAction'));
    }

    public function show(Product $product)
    {
        $product->loadMissing('category', 'creator', 'seller');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::query()->orderBy('name', 'asc')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Optional: Delete the image file if it exists
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully.');
    }
}