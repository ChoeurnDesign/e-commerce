<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Featured products (limit 8)
        $featuredProducts = Product::with('category')
            ->active()
            ->featured()
            ->take(8)
            ->get();

        if ($featuredProducts->count() < 8) {
            $additionalProducts = Product::with('category')
                ->active()
                ->whereNotIn('id', $featuredProducts->pluck('id'))
                ->latest()
                ->take(8 - $featuredProducts->count())
                ->get();

            $featuredProducts = $featuredProducts->merge($additionalProducts);
        }

        // Categories for grid display (for other uses, limit 6 for ex.)
        $categories = Category::active()
            ->has('products')
            ->withCount('products')
            ->orderBy('name')
            ->take(6)
            ->get();

        // Query products that are on sale
        $saleProducts = Product::where('on_sale', 1)
            ->whereNotNull('sale_price')
            ->orderBy('sale_price', 'asc') // ascending order (lowest first)
            ->take(8)
            ->get();

        // Parent categories with children for "Shop by Category" section (limit 2)
        $parentCategories = Category::whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->active()->withCount('products');
            }])
            ->withCount('products')
            ->take(2)
            ->get();

        // Cart & Wishlist Counts for Navbar
        $cartCount = Auth::check() ? Auth::user()->cart_count : 0;
        $wishlistCount = Auth::check() ? Auth::user()->wishlist_count : 0;

        return view('home', compact(
            'featuredProducts',
            'categories',
            'parentCategories',
            'cartCount',
            'wishlistCount',
            'saleProducts'
        ));
    }
}
