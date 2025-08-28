<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string)$request->q);

        $orders = Order::with('user')
            ->search($q)              // uses the scopeSearch you defined
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends(['q' => $q]);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user','orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()
            ->route('admin.orders.index')
            ->with('success','Order deleted successfully!');
    }
}
