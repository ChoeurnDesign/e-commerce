<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    // Show all sellers
    public function index()
    {
        $sellers = User::where('role', 'seller')->withCount('products')->paginate(16);
        return view('store.index', compact('sellers'));
    }

    // Show a single seller's store page
    public function show(User $seller)
    {
        $products = $seller->products()->latest()->paginate(12);
        return view('store.show', compact('seller', 'products'));
    }
}
