<?php

namespace App\Services\Commission;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Seller;
use Carbon\Carbon;

/**
 * Centralized commission, fee, and discount calculation service.
 *
 * Resolution priority (highest wins):
 *   1. Seller promo period — if active, commission = 0%
 *   2. Category commission_rate — if set on product's category
 *   3. Seller commission_rate — if set on seller
 *   4. Platform default — from settings, fallback 10%
 *
 * Payment fees:
 *   - Stripe:  2.9% + $0.30
 *   - PayPal:  3.49% + $0.49
 *   - COD:     0%
 *   - Bank:    0%
 *
 * Coupon allocation:
 *   - platform-funded: platform absorbs the discount, seller keeps full subtotal
 *   - seller-funded:   seller's subtotal reduced by their share before commission
 */
class CommissionService
{
    /**
     * Payment gateway fee schedule (percent of amount + flat fee).
     */
    public const PAYMENT_FEES = [
        'credit_card'      => ['percent' => 2.90, 'flat' => 0.30],
        'paypal'           => ['percent' => 3.49, 'flat' => 0.49],
        'cash_on_delivery' => ['percent' => 0.00, 'flat' => 0.00],
        'bank_transfer'    => ['percent' => 0.00, 'flat' => 0.00],
    ];

    /**
     * Resolve the commission rate to apply for a given product.
     *
     * @return array{rate: float, source: string}
     */
    public function resolveRate(Product $product): array
    {
        $seller = $product->seller;

        // 1. Seller promo period → 0%
        if ($seller && $seller->promo_until && Carbon::parse($seller->promo_until)->isFuture()) {
            return ['rate' => 0.00, 'source' => 'promo'];
        }

        // 2. Category override
        $category = $product->category;
        if ($category && $category->commission_rate !== null) {
            return ['rate' => (float) $category->commission_rate, 'source' => 'category'];
        }

        // 3. Seller-specific rate
        if ($seller && $seller->commission_rate !== null) {
            return ['rate' => (float) $seller->commission_rate, 'source' => 'seller'];
        }

        // 4. Platform default (could be from settings table)
        $default = (float) (setting('platform_commission_rate', 10.00));
        return ['rate' => $default, 'source' => 'default'];
    }

    /**
     * Calculate payment processing fee for an order amount.
     */
    public function calculatePaymentFee(string $method, float $amount): float
    {
        $schedule = self::PAYMENT_FEES[$method] ?? ['percent' => 0, 'flat' => 0];
        return round(($amount * $schedule['percent'] / 100) + $schedule['flat'], 2);
    }

    /**
     * Calculate commission for a given subtotal and rate.
     */
    public function calculateCommission(float $subtotal, float $rate): float
    {
        return round($subtotal * $rate / 100, 2);
    }

    /**
     * Allocate a coupon discount to a vendor's subtotal.
     *
     * Returns the vendor's adjusted subtotal after their share of the discount.
     *
     * @param Coupon|null $coupon       The coupon used (null = no discount)
     * @param float       $vendorTotal  This vendor's subtotal
     * @param float       $orderTotal   Total of all vendor subtotals in the order
     * @param float       $totalDiscount The full discount amount on the order
     *
     * @return array{adjusted_subtotal: float, discount_allocated: float, funded_by: string}
     */
    public function allocateCouponDiscount(
        ?Coupon $coupon,
        float $vendorTotal,
        float $orderTotal,
        float $totalDiscount
    ): array {
        if (!$coupon || $totalDiscount <= 0 || $orderTotal <= 0) {
            return [
                'adjusted_subtotal'   => $vendorTotal,
                'discount_allocated'  => 0.00,
                'funded_by'           => 'platform',
            ];
        }

        $fundedBy = $coupon->funded_by ?? 'platform';

        // Vendor's pro-rata share of the discount
        $vendorShare = round(($vendorTotal / $orderTotal) * $totalDiscount, 2);

        if ($fundedBy === 'platform') {
            // Platform eats the discount — seller keeps full subtotal
            return [
                'adjusted_subtotal'   => $vendorTotal,
                'discount_allocated'  => 0.00,
                'funded_by'           => 'platform',
            ];
        }

        // Seller-funded → reduce seller's subtotal before commission
        return [
            'adjusted_subtotal'   => round($vendorTotal - $vendorShare, 2),
            'discount_allocated'  => $vendorShare,
            'funded_by'           => 'seller',
        ];
    }

    /**
     * Calculate full vendor financials for a group of products from the same seller.
     *
     * @param  \Illuminate\Support\Collection  $items        Order items (with product loaded)
     * @param  Coupon|null                     $coupon       Coupon applied (if any)
     * @param  float                           $orderTotal   Full order subtotal (all vendors)
     * @param  float                           $totalDiscount Full order discount
     *
     * @return array
     */
    public function computeVendorFinancials(
        $items,
        ?Coupon $coupon,
        float $orderTotal,
        float $totalDiscount
    ): array {
        $rawSubtotal = round((float) $items->sum('total'), 2);

        // Use the first item's product to resolve rate (all items from same seller use same rules)
        $firstProduct = $items->first()->product ?? null;
        $rateInfo = $firstProduct
            ? $this->resolveRate($firstProduct)
            : ['rate' => 10.00, 'source' => 'default'];

        // Allocate discount
        $allocation = $this->allocateCouponDiscount($coupon, $rawSubtotal, $orderTotal, $totalDiscount);

        $taxableSubtotal  = $allocation['adjusted_subtotal'];
        $commissionAmount = $this->calculateCommission($taxableSubtotal, $rateInfo['rate']);
        $sellerEarnings   = round($taxableSubtotal - $commissionAmount, 2);

        return [
            'subtotal'           => $rawSubtotal,
            'discount_allocated' => $allocation['discount_allocated'],
            'commission_rate'    => $rateInfo['rate'],
            'commission_source'  => $rateInfo['source'],
            'commission_amount'  => $commissionAmount,
            'seller_earnings'    => $sellerEarnings,
        ];
    }
}
