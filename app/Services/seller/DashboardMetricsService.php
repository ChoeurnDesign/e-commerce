<?php

namespace App\Services\Seller;

use App\Models\Seller;
use Illuminate\Support\Facades\Cache;

class DashboardMetricsService
{
    /**
     * Build key metrics for a seller.
     *
     * @param Seller $seller
     * @param array{
     *   cache?: bool,
     *   ttl?: int,
     *   include_products?: bool,
     *   include_orders?: bool,
     *   include_ratings?: bool
     * } $options
     */
    public function forSeller(Seller $seller, array $options = []): array
    {
        $useCache = $options['cache'] ?? true;
        $ttl      = $options['ttl'] ?? 300; // seconds

        $cacheKey = "seller_metrics_v1_{$seller->id}_" .
            ($options['include_products'] ?? 0) .
            ($options['include_orders'] ?? 0) .
            ($options['include_ratings'] ?? 0);

        if (!$useCache) {
            return $this->build($seller, $options);
        }

        return Cache::remember($cacheKey, $ttl, fn() => $this->build($seller, $options));
    }

    protected function build(Seller $seller, array $options): array
    {
        $includeProducts = $options['include_products'] ?? true;
        $includeOrders   = $options['include_orders'] ?? true;
        $includeRatings  = $options['include_ratings'] ?? false;

        $productsCount = $includeProducts ? (int)$seller->products()->count() : null;
        $ordersCount   = $includeOrders ? (int)$seller->orders()->count() : null;

        $averageRating = null;
        if ($includeRatings && method_exists($seller, 'products')) {
            // Example: if each product has reviews() with 'rating'
            $productIds = $seller->products()->pluck('id');
            if ($productIds->isNotEmpty() && schema_has_table('reviews')) {
                $avg = \DB::table('reviews')
                    ->whereIn('product_id', $productIds)
                    ->avg('rating');
                $averageRating = $avg !== null ? round($avg, 2) : null;
            }
        }

        return [
            'products_count' => $productsCount,
            'orders_count'   => $ordersCount,
            'average_rating' => $averageRating,
        ];
    }
}

/**
 * Helper to safely check table existence without throwing.
 */
if (!function_exists('schema_has_table')) {
    function schema_has_table(string $table): bool
    {
        try {
            return \Schema::hasTable($table);
        } catch (\Throwable) {
            return false;
        }
    }
}