<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlatformWallet extends Model
{
    protected $table = 'platform_wallet';

    protected $fillable = [
        'balance',
        'total_revenue',
        'total_commission',
        'total_paid_out',
        'total_payment_fees',
    ];

    /**
     * Get the single platform wallet instance (auto-creates if missing).
     */
    public static function getInstance(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'balance'            => 0,
            'total_revenue'      => 0,
            'total_commission'   => 0,
            'total_paid_out'     => 0,
            'total_payment_fees' => 0,
        ]);
    }

    /**
     * Record a payment gateway fee (Stripe/PayPal).
     * Fee is deducted from platform balance and tracked separately.
     */
    public function recordPaymentFee(Order $order, float $fee): PlatformTransaction
    {
        $this->decrement('balance', $fee);
        $this->increment('total_payment_fees', $fee);

        return PlatformTransaction::create([
            'type'          => 'payment_fee',
            'amount'        => $fee,
            'balance_after' => $this->fresh()->balance,
            'description'   => "Payment gateway fee for order #{$order->order_number}",
            'order_id'      => $order->id,
        ]);
    }

    /**
     * Record an incoming payment from a customer order.
     * Full order total goes into platform balance.
     */
    public function receiveOrderPayment(Order $order, float $amount): PlatformTransaction
    {
        $this->increment('balance', $amount);
        $this->increment('total_revenue', $amount);

        return PlatformTransaction::create([
            'type'          => 'order_received',
            'amount'        => $amount,
            'balance_after' => $this->fresh()->balance,
            'description'   => "Payment received for order #{$order->order_number}",
            'order_id'      => $order->id,
        ]);
    }

    /**
     * Release seller earnings from platform balance to seller wallet.
     * Platform keeps the commission, pays out the seller_earnings.
     */
    public function payoutToSeller(
        VendorOrder $vendorOrder,
        float $sellerEarnings,
        float $commission
    ): PlatformTransaction {
        // Deduct seller earnings from platform balance
        $this->decrement('balance', $sellerEarnings);
        // Track commission earned
        $this->increment('total_commission', $commission);
        $this->increment('total_paid_out', $sellerEarnings);

        return PlatformTransaction::create([
            'type'          => 'seller_payout',
            'amount'        => $sellerEarnings,
            'balance_after' => $this->fresh()->balance,
            'description'   => "Seller earnings released for order #{$vendorOrder->order?->order_number}",
            'order_id'      => $vendorOrder->order_id,
            'seller_id'     => $vendorOrder->seller_id,
        ]);
    }

    /**
     * Refund an order — remove the amount from platform balance.
     */
    public function refundOrder(Order $order, float $amount): PlatformTransaction
    {
        $this->decrement('balance', $amount);

        return PlatformTransaction::create([
            'type'          => 'refund',
            'amount'        => $amount,
            'balance_after' => $this->fresh()->balance,
            'description'   => "Refund for order #{$order->order_number}",
            'order_id'      => $order->id,
        ]);
    }
}
