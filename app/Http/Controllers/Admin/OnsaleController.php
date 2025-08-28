<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Onsale;

class OnsaleController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->q);

        $products = Onsale::query()
            ->when($q !== '', fn($qry) => $qry->search($q))
            ->when(
                $request->filled('discount_min'),
                fn($qry) =>
                $qry->withMinDiscount((int) $request->discount_min)
            )
            ->when(
                $request->filled('price_min') || $request->filled('price_max'),
                fn($qry) => $qry->salePriceBetween($request->price_min, $request->price_max)
            )
            ->orderByDesc('updated_at')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.onsale.index', compact('products'));
    }

    public function edit(Product $product)
    {
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
                        $fail('The sale price must be less than the original price.');
                    }
                }
            ],
            'compare_price' => 'nullable|numeric|min:0',
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
