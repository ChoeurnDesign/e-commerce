<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class OnsaleController extends Controller
{
    public function index()
    {
        $products = Product::where('on_sale', 1)->latest()->paginate(10);
        return view('admin.onsale.index', compact('products'));
    }

    public function edit(Product $product)
    {
        // Only allow editing if product is ACTUALLY on sale
        if (!$product->on_sale) {
            abort(404, 'Product is not on sale.');
        }
        return view('admin.onsale.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'on_sale' => 'boolean',
            'sale_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($product) {
                    if ($value !== null && $value >= $product->price) {
                        $fail('The sale price field must be less than price.');
                    }
                }
            ],
            'compare_price' => 'nullable|numeric|min:0', // option for compare_price if needed
        ]);

        $product->on_sale = $request->has('on_sale') ? 1 : 0;
        $product->sale_price = $validated['sale_price'] ?? null;
        $product->compare_price = $validated['compare_price'] ?? $product->compare_price;
        $product->save();

        return redirect()->route('admin.onsale.index')
            ->with('success', 'Product sale status updated successfully!');
    }

    public function removeFromSale(Product $product)
    {
        $product->on_sale = 0;
        $product->sale_price = null;
        $product->save();

        return redirect()->route('admin.onsale.index')
            ->with('success', 'Product removed from sale successfully!');
    }
}
