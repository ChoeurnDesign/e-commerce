<?php

use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

if (!function_exists('order_total')) {
    function order_total() {
        $orderTotal = 0;
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->get();
            foreach ($cartItems as $item) {
                $orderTotal += $item->quantity * $item->product->price;
            }
        }
        return $orderTotal;
    }
}
