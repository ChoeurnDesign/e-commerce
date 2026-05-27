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
            ->search($q)
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

    public function edit(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // 1. Validate the incoming request
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,confirmed,shipped,delivered,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        // 2. Update the order in the database
        $order->update($validated);

        // 3. TRIGGER: Distribute earnings if the status is set to 'delivered'
        // This connects your Controller to the logic we added in the Model
        if ($order->status === 'delivered') {
            $order->distributeVendorEarnings();
        }

        // 4. Redirect back
        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order #' . $order->id . ' updated successfully!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Order deleted successfully!');
    }
}