<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\VendorOrder;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function userOrders()
    {
        $orders = Order::with(['orderItems.product'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.history', compact('orders'));
    }

    /**
     * Display a specific order by order number
     * @param string $orderNumber
     */
    public function show(string $orderNumber)
    {
        $order = Order::with(['orderItems.product.seller'])
            ->where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }

    /**
     * Confirm receipt of order
     * @param Order $order
     */
    public function confirmReceipt(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status === 'completed') {
            return back()->with('info', 'This order is already completed.');
        }

        // Customer can confirm receipt when order is delivered, shipped, or confirmed by seller
        $allowedStatuses = ['delivered', 'shipped', 'confirmed'];
        if (!in_array($order->status, $allowedStatuses)) {
            return back()->with('error', 'Order cannot be confirmed at this stage. Current status: ' . ucfirst($order->status));
        }

        try {
            DB::beginTransaction();

            // 1. If COD and payment still pending → mark as paid + credit platform
            if ($order->payment_method === 'cash_on_delivery' && $order->payment_status !== 'paid') {
                $order->update(['payment_status' => 'paid']);
                \App\Models\PlatformWallet::getInstance()
                    ->receiveOrderPayment($order, (float) $order->total_price);
            }

            // 2. Update order + vendor orders to completed
            $order->update(['status' => 'completed']);

            VendorOrder::where('order_id', $order->id)
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->update(['status' => 'completed']);

            // 3. Distribute earnings via platform wallet
            //    (credits seller wallets, debits platform, records transactions)
            $order->distributeVendorEarnings();

            DB::commit();
            return back()->with('success', 'Order confirmed! Thank you for shopping with us.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment
     * @param int $orderId
     */
    public function handlePaymentSuccess(int $orderId)
    {
        $order = Order::findOrFail($orderId);

        $order->update([
            'payment_status' => 'paid',
            'status' => 'processing'
        ]);

        // Sync vendor orders to processing
        VendorOrder::where('order_id', $order->id)->update([
            'status' => 'processing'
        ]);

        return redirect()->route('orders.show', $order->order_number)
                         ->with('success', 'Payment successful!');
    }
}