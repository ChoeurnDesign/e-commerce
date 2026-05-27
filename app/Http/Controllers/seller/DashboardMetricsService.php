<?php

namespace App\Services\Seller;

use App\Models\VendorOrder;

class DashboardMetricsService
{
    /**
     * Calculate metrics for a specific seller.
     */
    public function forSeller($seller, array $options = [])
    {
        $data = [];

        // 1. Fetch counts based on your options
        if ($options['include_products'] ?? false) {
            $data['products_count'] = $seller->products()->count();
        }

        if ($options['include_orders'] ?? false) {
            $data['orders_count'] = $seller->vendorOrders()->count();
        }

        if ($options['include_ratings'] ?? false) {
            $data['average_rating'] = $seller->products()->avg('rating') ?? 0;
        }

        // 2. Financial Data Logic Update
        
        /**
         * TOTAL EARNINGS: 
         * Now only includes orders where status is 'completed'.
         * This ensures money only shows as "Earned" after the customer confirms receipt.
         */
        $data['total_earnings'] = VendorOrder::where('seller_id', $seller->id)
            ->where('status', 'completed') 
            ->sum('seller_earnings');

        /**
         * PENDING PAYOUT: 
         * Includes all orders that are paid but NOT yet completed.
         * This represents money held in escrow (Admin dashboard).
         */
        $data['pending_payout'] = VendorOrder::where('seller_id', $seller->id)
            ->whereIn('status', ['pending', 'processing', 'confirmed'])
            ->sum('seller_earnings');

        return $data;
    }
}