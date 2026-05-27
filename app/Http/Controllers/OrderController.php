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

        // Allow confirmation if the seller has confirmed or shipped the item
        $allowedStatuses = ['shipped', 'confirmed'];
        if (!in_array($order->status, $allowedStatuses)) {
            return back()->with('error', 'Order cannot be confirmed at this stage.');
        }

        try {
            DB::beginTransaction();

            // 1. Update the main Customer Order status to completed
            $order->update(['status' => 'completed']);

            // 2. Update the Vendor Orders status to completed
            VendorOrder::where('order_id', $order->id)->update([
                'status' => 'completed'
            ]);

            // 3. Credit seller wallets only for COD orders (card/PayPal wallets are credited at checkout)
            if ($order->payment_status !== 'paid' && !$order->payout_released) {
                foreach ($order->vendorOrders as $vendorOrder) {
                    $wallet = Wallet::firstOrCreate(
                        ['seller_id' => $vendorOrder->seller_id],
                        ['balance' => 0]
                    );
                    $wallet->increment('balance', $vendorOrder->seller_earnings);
                }
                $order->update(['payout_released' => true]);
            }

            DB::commit();
            return back()->with('success', 'Order confirmed! Thank you.');

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