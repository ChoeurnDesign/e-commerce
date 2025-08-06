<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display user's wishlist
     */
    public function index()
    {
        $wishlistItems = Auth::user()->wishlistProducts()->with('category')->paginate(12);

        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add product to wishlist
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if already in wishlist
        if (Auth::user()->hasInWishlist($product->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist'
            ]);
        }

        Auth::user()->addToWishlist($product->id);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'wishlist_count' => Auth::user()->wishlist_count
        ]);
    }

    /**
     * Remove product from wishlist
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        Auth::user()->removeFromWishlist($request->product_id);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'wishlist_count' => Auth::user()->wishlist_count
        ]);
    }

    /**
     * Toggle wishlist status
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->product_id;
        $user = Auth::user();

        if ($user->hasInWishlist($productId)) {
            $user->removeFromWishlist($productId);
            $action = 'removed';
        } else {
            $user->addToWishlist($productId);
            $action = 'added';
        }

        return response()->json([
            'success' => true,
            'action' => $action,
            'message' => "Product {$action} " . ($action === 'added' ? 'to' : 'from') . ' wishlist',
            'wishlist_count' => $user->wishlist_count,
            'in_wishlist' => $action === 'added'
        ]);
    }
}
