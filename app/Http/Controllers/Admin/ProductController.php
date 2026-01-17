<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // middleware can be applied here
    }

    public function index(Request $request)
    {
        $request->validate([
            'q'            => 'nullable|string|max:120',
            'category_id'  => 'nullable|integer|exists:categories,id',
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

        $query = Product::with(['category', 'creator']);

        if ($search = $request->q) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($cid = $request->category_id) {
            $query->where('category_id', $cid);
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
        if ($request->filled('created_from')) $query->whereDate('created_at', '>=', $request->created_from);
        if ($request->filled('created_to')) $query->whereDate('created_at', '<=', $request->created_to);

        $allowedSorts = ['id', 'price', 'created_at', 'stock_quantity'];
        $sort = in_array($request->sort, $allowedSorts, true) ? $request->sort : 'id';
        $dir = in_array(strtolower((string)$request->dir), ['asc', 'desc'], true) ? strtolower($request->dir) : 'desc';
        $query->orderBy($sort, $dir);

        $products = $query->paginate(15)->appends($request->query());
        $categories = Category::orderBy('name')->get(['id', 'name']);

        $filterFields = [
            ['name' => 'q', 'type' => 'text', 'label' => 'Search', 'placeholder' => 'Search products...'],
            [
                'name' => 'category_id',
                'type' => 'select',
                'label' => 'Category',
                'placeholder' => 'All',
                'options' => $categories->pluck('name', 'id')->toArray()
            ],
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
            'q', 'category_id', 'is_active', 'on_sale', 'is_featured',
            'price_min', 'price_max', 'stock_min', 'stock_max', 'created_from', 'created_to'
        ]);

        $filterAction = route('admin.products.index');

        return view('admin.products.index', compact('products', 'filterFields', 'categories', 'filters', 'filterAction'));
    }

    public function show(Product $product)
    {
        $product->loadMissing('category', 'creator');
        return view('admin.products.show', compact('product'));
    }
}