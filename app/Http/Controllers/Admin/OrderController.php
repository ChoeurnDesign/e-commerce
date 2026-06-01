<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\VendorOrder;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->q);

        $orders = Order::with('user')
            ->search($q)
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends(['q' => $q]);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'orderItems.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load(['user', 'orderItems.product']);

        // Pass allowed transitions so the view can restrict the dropdown
        $allowedStatuses = Order::allowedTransitions($order->status);

        return view('admin.orders.edit', compact('order', 'allowedStatuses'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status'         => 'required|in:pending,processing,confirmed,shipped,delivered,completed,cancelled',
            'payment_status' => 'required|in:pending,awaiting_verification,paid,failed,refunded',
        ]);

        $oldStatus    = $order->status;
        $newStatus    = $validated['status'];
        $oldPayStatus = $order->payment_status;
        $newPayStatus = $validated['payment_status'];

        // ── 1. Validate status transition ─────────────────────────────────
        if ($oldStatus !== $newStatus && !$order->canTransitionTo($newStatus)) {
            return back()->with('error',
                "Cannot change status from \"{$oldStatus}\" to \"{$newStatus}\". " .
                'Allowed: ' . (implode(', ', Order::allowedTransitions($oldStatus)) ?: 'none (final state)')
            );
        }

        // ── 2. Auto-stamp timestamps ──────────────────────────────────────
        if ($newStatus === 'shipped' && !$order->shipped_at) {
            $validated['shipped_at'] = now();
        }
        if ($newStatus === 'delivered' && !$order->delivered_at) {
            $validated['delivered_at'] = now();
        }

        // ── 3. Update the order ───────────────────────────────────────────
        $order->update($validated);

        // ── 4. Handle status-specific business logic ──────────────────────

        // DELIVERED → update vendor order status + handle COD payment collection
        if ($newStatus === 'delivered' && $oldStatus !== 'delivered') {
            VendorOrder::where('order_id', $order->id)
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->update(['status' => 'confirmed']);

            // For COD orders, money is collected at delivery — credit platform wallet now
            if ($order->payment_method === 'cash_on_delivery' && !$order->payout_released) {
                $order->update(['payment_status' => 'paid']);
                $platformWallet = \App\Models\PlatformWallet::getInstance();
                $platformWallet->receiveOrderPayment($order, (float) $order->total_price);
            }
        }

        // COMPLETED → distribute earnings to seller wallets (only once)
        if ($newStatus === 'completed' && $oldStatus !== 'completed') {
            $order->distributeVendorEarnings();

            // Mark all vendor orders as completed
            VendorOrder::where('order_id', $order->id)
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->update(['status' => 'completed']);
        }

        // CANCELLED → restore stock + reverse earnings + refund platform
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            // Restore product stock
            $order->load('orderItems.product');
            $order->restoreStock();

            // Reverse wallet credits if earnings were already distributed
            $order->load('vendorOrders');
            $order->reverseEarnings();

            // Refund from platform wallet if payment was received
            if (in_array($order->payment_status, ['paid', 'awaiting_verification'])) {
                $platformWallet = \App\Models\PlatformWallet::getInstance();
                $platformWallet->refundOrder($order, (float) $order->total_price);
            }

            // Mark all vendor orders as cancelled
            VendorOrder::where('order_id', $order->id)
                ->whereNotIn('status', ['cancelled'])
                ->update(['status' => 'cancelled']);

            Log::info("Order #{$order->order_number} cancelled by admin. Stock restored, earnings reversed, platform refunded.", [
                'admin_id' => Auth::id(),
                'order_id' => $order->id,
            ]);
        }

        // ── 5. Notify customer of status change ───────────────────────────
        if ($oldStatus !== $newStatus) {
            try {
                $customer = $order->user;
                if ($customer) {
                    $customer->notify(new OrderStatusNotification($order, $newStatus));
                }
            } catch (\Throwable $e) {
                // Notification failure should not block the flow
                Log::warning("Failed to notify customer for order #{$order->order_number}: " . $e->getMessage());
            }
        }

        // ── 6. Redirect with success ──────────────────────────────────────
        $messages = [];
        if ($oldStatus !== $newStatus) {
            $messages[] = "Status: {$oldStatus} → {$newStatus}";
        }
        if ($oldPayStatus !== $newPayStatus) {
            $messages[] = "Payment: {$oldPayStatus} → {$newPayStatus}";
        }

        $summary = $messages ? implode('. ', $messages) . '.' : 'No changes made.';

        return redirect()
            ->route('admin.orders.index')
            ->with('success', "Order #{$order->order_number} updated. {$summary}");
    }

    public function destroy(Order $order)
    {
        // Prevent deleting orders that have been paid/completed
        if (in_array($order->status, ['completed', 'delivered', 'shipped'])) {
            return back()->with('error', "Cannot delete order #{$order->order_number} — it has been {$order->status}. Cancel it first.");
        }

        // Restore stock if order had items
        $order->load('orderItems.product');
        $order->restoreStock();

        $orderNumber = $order->order_number;
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', "Order #{$orderNumber} deleted. Stock restored.");
    }

    /* ═══════════════════════════════════════════════════════════════════
       BANK TRANSFER — Payment verification queue
       Admin reviews customer receipt screenshots and approves/rejects.
       ═══════════════════════════════════════════════════════════════════ */

    public function pendingPayments(Request $request)
    {
        $orders = Order::with('user')
            ->where('payment_method', 'bank_transfer')
            ->whereIn('payment_status', ['awaiting_verification', 'pending'])
            ->whereNotNull('payment_proof')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.orders.pending-payments', compact('orders'));
    }

    public function verifyPayment(Request $request, Order $order)
    {
        $note = $request->input('note');

        $order->update([
            'payment_status'            => 'paid',
            'status'                    => 'processing',
            'payment_verified_by'       => Auth::id(),
            'payment_verified_at'       => now(),
            'payment_verification_note' => $note,
        ]);

        // Move vendor orders to processing so sellers can start fulfilling
        VendorOrder::where('order_id', $order->id)->update(['status' => 'processing']);

        // Money enters the platform wallet (no gateway fee for bank transfer)
        $platformWallet = \App\Models\PlatformWallet::getInstance();
        $platformWallet->receiveOrderPayment($order, (float) $order->total_price);

        // Notify customer
        try {
            $order->user?->notify(new OrderStatusNotification($order, 'processing'));
        } catch (\Throwable $e) {
            Log::warning("Failed to notify customer for payment verification: " . $e->getMessage());
        }

        return back()->with('success', "Payment for order #{$order->order_number} verified successfully.");
    }

    public function rejectPayment(Request $request, Order $order)
    {
        $note = $request->input('note', 'Receipt could not be verified.');

        $order->update([
            'payment_status'            => 'failed',
            'status'                    => 'cancelled',
            'payment_verified_by'       => Auth::id(),
            'payment_verified_at'       => now(),
            'payment_verification_note' => $note,
        ]);

        // Restore stock since order is cancelled
        $order->load('orderItems.product');
        $order->restoreStock();

        // Notify customer
        try {
            $order->user?->notify(new OrderStatusNotification($order, 'cancelled'));
        } catch (\Throwable $e) {
            Log::warning("Failed to notify customer for payment rejection: " . $e->getMessage());
        }

        return back()->with('success', "Payment for order #{$order->order_number} rejected. Stock restored.");
    }
}
