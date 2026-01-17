<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    /**
     * Display a listing of the seller's orders.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Fetch orders for the authenticated seller
        $sellerId = Auth::id(); // Assuming `seller_id` exists in the `orders` table
        $orders = Order::where('seller_id', $sellerId)
            ->with(['customer', 'items.product']) // Eager load relationships
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Return the view with the orders
        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Display the specified order details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sellerId = Auth::id();
        
        // Fetch the order and ensure it belongs to the authenticated seller
        $order = Order::where('id', $id)
            ->where('seller_id', $sellerId)
            ->with(['customer', 'items.product']) // Eager load relationships
            ->firstOrFail();

        // Return the view with order details
        return view('seller.orders.show', compact('order'));
    }
}