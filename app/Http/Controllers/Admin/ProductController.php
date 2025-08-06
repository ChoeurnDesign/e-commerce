<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Notifications\NewProductNotification;
use App\Notifications\DiscountNotification;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'on_sale' => 'boolean',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'required|string|unique:products,sku',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        // Default for checkboxes
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['on_sale'] = $request->has('on_sale') ? 1 : 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = Storage::url($imagePath);
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['name']);

        $product = Product::create($validated);

        // Notify all regular users about the new product
        foreach (User::where('role', 'user')->get() as $user) {
            $user->notify(new NewProductNotification($product));
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'on_sale' => 'boolean',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        // Default for checkboxes
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;
        $validated['on_sale'] = $request->has('on_sale') ? 1 : 0;

        // Save current sale price to check for discount changes
        $oldSalePrice = $product->sale_price;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = Storage::url($imagePath);
        }

        // Update slug if name changed
        if ($product->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product->update($validated);

        // If sale_price is set and changed, notify users about the discount
        if (!empty($validated['sale_price']) && $validated['sale_price'] != $oldSalePrice) {
            foreach (User::where('role', 'user')->get() as $user) {
                $user->notify(new DiscountNotification($product));
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete image
        if ($product->image && Storage::disk('public')->exists(str_replace('/storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function showImportForm()
    {
        // Show the import form view
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'products_file' => 'required|mimes:csv,txt'
        ]);
        try {
            $file = $request->file('products_file');
            Excel::import(new ProductsImport, $file);
            return back()->with('success', 'Products imported successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
