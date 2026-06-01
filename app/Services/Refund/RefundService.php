<?php

namespace App\Services\Refund;

use App\Models\CustomerWallet;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PlatformWallet;
use App\Models\Refund;
use App\Models\ReturnRequest;
use App\Models\ReturnRequestItem;
use App\Models\VendorOrder;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Centralized service for return + refund processing.
 *
 * Money flow on refund:
 *   1. Platform wallet refunded (balance decreases)
 *   2. Seller wallet debited (earnings reversed)
 *   3. Stock restored (if items returned)
 *   4. Refund issued to customer:
 *        - original_payment → Stripe/PayPal refund API (or manual for COD/bank)
 *        - store_credit     → CustomerWallet credited
 */
class RefundService
{
    /**
     * Customer requests a return.
     *
     * @param  array  $itemPayload  [['order_item_id' => 1, 'quantity' => 2], ...]
     */
    public function createReturnRequest(
        Order $order,
        VendorOrder $vendorOrder,
        array $itemPayload,
        string $reasonCode,
        ?string $reasonDescription = null,
        string $refundMethod = 'original_payment'
    ): ReturnRequest {
        return DB::transaction(function () use (
            $order, $vendorOrder, $itemPayload, $reasonCode, $reasonDescription, $refundMethod
        ) {
            $returnRequest = ReturnRequest::create([
                'order_id'              => $order->id,
                'vendor_order_id'       => $vendorOrder->id,
                'user_id'               => $order->user_id,
                'seller_id'             => $vendorOrder->seller_id,
                'reason_code'           => $reasonCode,
                'reason_description'    => $reasonDescription,
                'refund_method'         => $refundMethod,
                'return_items_required' => true,
                'status'                => 'pending_seller_review',
                'refund_amount'         => 0, // calculated below
            ]);

            $totalRefund = 0.0;

            foreach ($itemPayload as $itemData) {
                $orderItem = OrderItem::find($itemData['order_item_id']);
                if (!$orderItem || $orderItem->order_id !== $order->id) continue;

                $qty       = max(1, min((int) $itemData['quantity'], $orderItem->quantity));
                $unitPrice = (float) $orderItem->price;
                $lineRefund = round($unitPrice * $qty, 2);

                ReturnRequestItem::create([
                    'return_request_id' => $returnRequest->id,
                    'order_item_id'     => $orderItem->id,
                    'quantity'          => $qty,
                    'unit_refund'       => $unitPrice,
                    'line_refund'       => $lineRefund,
                ]);

                $totalRefund += $lineRefund;
            }

            $returnRequest->update(['refund_amount' => round($totalRefund, 2)]);

            return $returnRequest->fresh();
        });
    }

    /**
     * Seller approves a return request.
     */
    public function approve(ReturnRequest $returnRequest, ?string $response = null): ReturnRequest
    {
        if (!$returnRequest->canTransitionTo('approved')) {
            throw new \RuntimeException("Cannot approve return from status: {$returnRequest->status}");
        }

        $returnRequest->update([
            'status'              => 'approved',
            'seller_response'     => $response,
            'seller_responded_at' => now(),
        ]);

        return $returnRequest->fresh();
    }

    /**
     * Seller rejects a return request.
     */
    public function reject(ReturnRequest $returnRequest, string $reason): ReturnRequest
    {
        if (!$returnRequest->canTransitionTo('rejected')) {
            throw new \RuntimeException("Cannot reject return from status: {$returnRequest->status}");
        }

        $returnRequest->update([
            'status'              => 'rejected',
            'seller_response'     => $reason,
            'seller_responded_at' => now(),
            'resolved_at'         => now(),
        ]);

        return $returnRequest->fresh();
    }

    /**
     * Customer cancels their own return request before seller has actioned.
     */
    public function cancelByCustomer(ReturnRequest $returnRequest): ReturnRequest
    {
        if (!in_array($returnRequest->status, ['pending_seller_review', 'approved'])) {
            throw new \RuntimeException("Cannot cancel return in status: {$returnRequest->status}");
        }

        $returnRequest->update([
            'status'      => 'cancelled',
            'resolved_at' => now(),
        ]);

        return $returnRequest->fresh();
    }

    /**
     * Process the actual refund. Runs the full money flow:
     *   - Platform balance reduced
     *   - Seller wallet reversed (if completed order)
     *   - Stock restored
     *   - Refund record created
     *   - Customer wallet credited (if store credit)
     */
    public function processRefund(ReturnRequest $returnRequest): Refund
    {
        if (!in_array($returnRequest->status, ['approved', 'received', 'disputed'])) {
            throw new \RuntimeException("Cannot process refund from status: {$returnRequest->status}");
        }

        return DB::transaction(function () use ($returnRequest) {
            $order  = $returnRequest->order;
            $amount = (float) $returnRequest->refund_amount;

            // 1. Refund money from platform wallet
            $platformWallet = PlatformWallet::getInstance();
            $platformWallet->refundOrder($order, $amount);

            // 2. Reverse seller wallet for the proportional earnings
            $vendorOrder = $returnRequest->vendorOrder;
            if ($vendorOrder && $vendorOrder->seller_earnings > 0) {
                // Calculate proportional earnings to reverse
                $vendorSubtotal       = (float) $vendorOrder->subtotal;
                $vendorEarnings       = (float) $vendorOrder->seller_earnings;
                $proportionalEarnings = $vendorSubtotal > 0
                    ? round(($amount / $vendorSubtotal) * $vendorEarnings, 2)
                    : 0;

                if ($proportionalEarnings > 0) {
                    $sellerWallet = Wallet::where('seller_id', $vendorOrder->seller_id)->first();
                    if ($sellerWallet) {
                        $deduct = min($sellerWallet->balance, $proportionalEarnings);
                        $sellerWallet->decrement('balance', $deduct);
                    }
                }
            }

            // 3. Restore stock for returned items
            foreach ($returnRequest->items as $returnItem) {
                $orderItem = $returnItem->orderItem;
                if ($orderItem && $orderItem->product) {
                    $orderItem->product->increment('stock_quantity', $returnItem->quantity);
                }
            }

            // 4. Issue refund to customer
            $refund = $this->issueCustomerRefund($returnRequest, $amount);

            // 5. Update return request status
            $returnRequest->update([
                'status'                 => 'refunded',
                'refund_processed_at'    => now(),
                'refund_transaction_id'  => $refund->gateway_refund_id,
            ]);

            return $refund;
        });
    }

    /**
     * Issue the actual refund to customer based on their chosen method.
     */
    protected function issueCustomerRefund(ReturnRequest $returnRequest, float $amount): Refund
    {
        $order        = $returnRequest->order;
        $method       = $order->payment_method;
        $refundMethod = $returnRequest->refund_method;

        $refund = Refund::create([
            'order_id'          => $order->id,
            'return_request_id' => $returnRequest->id,
            'amount'            => $amount,
            'payment_method'    => $method,
            'refund_type'       => $refundMethod,
            'status'            => 'pending',
            'processed_by'      => Auth::id(),
            'processed_at'      => now(),
        ]);

        try {
            if ($refundMethod === 'store_credit') {
                // Credit customer's store credit wallet
                $wallet = CustomerWallet::forUser($order->user_id);
                $wallet->addCredit($amount);

                $refund->update([
                    'status'           => 'completed',
                    'gateway_refund_id' => 'CREDIT-' . strtoupper(\Illuminate\Support\Str::random(8)),
                    'notes'             => 'Refunded as store credit',
                ]);
            } else {
                // Original payment method
                switch ($method) {
                    case 'credit_card':
                        $gatewayId = $this->processStripeRefund($order, $amount);
                        $refund->update([
                            'status'            => 'completed',
                            'gateway_refund_id' => $gatewayId,
                        ]);
                        break;

                    case 'paypal':
                        // PayPal refund API would go here — for now mark as processing
                        $refund->update([
                            'status'            => 'processing',
                            'gateway_refund_id' => 'PP-RF-' . strtoupper(\Illuminate\Support\Str::random(8)),
                            'notes'             => 'PayPal refund queued — manual processing required',
                        ]);
                        break;

                    case 'cash_on_delivery':
                    case 'bank_transfer':
                        // Manual bank transfer back to customer
                        $refund->update([
                            'status'            => 'pending',
                            'notes'             => 'Manual ' . strtoupper(str_replace('_', ' ', $method)) . ' refund — admin must initiate bank transfer to customer.',
                        ]);
                        break;
                }
            }
        } catch (\Throwable $e) {
            $refund->update([
                'status'         => 'failed',
                'failure_reason' => $e->getMessage(),
            ]);
            Log::error('Refund processing failed', [
                'refund_id' => $refund->id,
                'error'     => $e->getMessage(),
            ]);
        }

        return $refund->fresh();
    }

    /**
     * Process Stripe refund (placeholder — real implementation needs Stripe SDK).
     */
    protected function processStripeRefund(Order $order, float $amount): string
    {
        // In production, uncomment and configure:
        // \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        // $refund = \Stripe\Refund::create([
        //     'payment_intent' => $order->payment_id,
        //     'amount'         => (int) round($amount * 100),
        // ]);
        // return $refund->id;

        return 'STRIPE-MOCK-' . strtoupper(\Illuminate\Support\Str::random(10));
    }

    /**
     * Mark return as completed (customer has received refund).
     */
    public function complete(ReturnRequest $returnRequest): ReturnRequest
    {
        if ($returnRequest->status !== 'refunded') {
            throw new \RuntimeException('Only refunded returns can be completed.');
        }

        $returnRequest->update([
            'status'      => 'completed',
            'resolved_at' => now(),
        ]);

        return $returnRequest->fresh();
    }
}
