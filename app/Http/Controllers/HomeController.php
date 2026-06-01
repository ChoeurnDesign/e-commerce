<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Seller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $settings        = Setting::pluck('value', 'key')->toArray();
        $storefrontTitle = trim($settings['storefront_title'] ?? '');
        $welcomeMessage  = trim($settings['welcome_message']  ?? '');
        $banners         = \App\Models\HomepageBanner::where('enabled', 1)->orderBy('order')->get();

        // ── Featured products (up to 18 = 3 rows × 6 columns) ────────────
        $featuredTarget = 18;
        $featuredProducts = Product::with('category')
            ->active()
            ->featured()
            ->take($featuredTarget)
            ->get();

        if ($featuredProducts->count() < $featuredTarget) {
            $featuredProducts = $featuredProducts->merge(
                Product::with('category')
                    ->active()
                    ->whereNotIn('id', $featuredProducts->pluck('id'))
                    ->latest()
                    ->take($featuredTarget - $featuredProducts->count())
                    ->get()
            );
        }

        // ── New arrivals (8 most recent, distinct from featured) ──────────
        $newArrivals = Product::with('category')
            ->active()
            ->whereNotIn('id', $featuredProducts->pluck('id'))
            ->latest()
            ->take(8)
            ->get();

        // ── Sale products ─────────────────────────────────────────────────
        $saleProducts = Product::with('category')
            ->where('on_sale', 1)
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price')
            ->orderByRaw('(price - sale_price) / price DESC')
            ->take(8)
            ->get();

        // ── Top stores (approved, by follower count) ──────────────────────
        $topStores = Seller::approved()
            ->withCount('products')
            ->has('products')
            ->orderByDesc('followers_count')
            ->take(8)
            ->get();

        // ── Categories ────────────────────────────────────────────────────
        $categories = Category::active()
            ->has('products')
            ->withCount('products')
            ->orderBy('name')
            ->take(10)
            ->get();
        Category::attachDisplayImages($categories);

        $parentCategories = Category::whereNull('parent_id')
            ->with(['children' => fn($q) => $q->active()->withCount('products')])
            ->withCount('products')
            ->take(3)
            ->get();
        Category::attachDisplayImages($parentCategories);

        // ── Platform stats (for homepage display) ─────────────────────────
        $statsProducts   = Product::active()->count();
        $statsSellers    = Seller::approved()->has('products')->count();
        $statsCategories = Category::active()->count();

        // ── Cart & Wishlist counts for navbar ─────────────────────────────
        $cartCount     = Auth::check() ? Auth::user()->cart_count     : 0;
        $wishlistCount = Auth::check() ? Auth::user()->wishlist_count  : 0;

        return view('home', compact(
            'featuredProducts',
            'newArrivals',
            'categories',
            'parentCategories',
            'cartCount',
            'wishlistCount',
            'saleProducts',
            'topStores',
            'storefrontTitle',
            'welcomeMessage',
            'banners',
            'statsProducts',
            'statsSellers',
            'statsCategories',
        ));
    }
}
