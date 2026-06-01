<?php

namespace App\Services\Report;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Aggregates sales / financial data for the admin Sales Report.
 *
 * Revenue is recognised on PAID orders only (payment_status = 'paid').
 * Platform net profit = commission earned − payment-gateway fees − refunds.
 */
class SalesReportService
{
    protected Carbon $from;
    protected Carbon $to;
    protected string $rangeKey;

    /**
     * Build the service from a range key or explicit custom dates.
     */
    public function __construct(string $range = '30d', ?string $from = null, ?string $to = null)
    {
        $this->rangeKey = $range;
        [$this->from, $this->to] = $this->resolveRange($range, $from, $to);
    }

    public function getFrom(): Carbon { return $this->from; }
    public function getTo(): Carbon   { return $this->to; }
    public function getRangeKey(): string { return $this->rangeKey; }

    public function rangeLabel(): string
    {
        return match ($this->rangeKey) {
            'today'  => 'Today',
            '7d'     => 'Last 7 Days',
            '30d'    => 'Last 30 Days',
            '90d'    => 'Last 90 Days',
            'year'   => 'This Year',
            'all'    => 'All Time',
            default  => $this->from->format('M d, Y') . ' – ' . $this->to->format('M d, Y'),
        };
    }

    /**
     * Resolve a range key into [from, to] Carbon instances.
     */
    protected function resolveRange(string $range, ?string $from, ?string $to): array
    {
        $now = Carbon::now();

        if ($range === 'custom' && $from && $to) {
            return [
                Carbon::parse($from)->startOfDay(),
                Carbon::parse($to)->endOfDay(),
            ];
        }

        return match ($range) {
            'today'  => [$now->copy()->startOfDay(),          $now->copy()->endOfDay()],
            '7d'     => [$now->copy()->subDays(6)->startOfDay(), $now->copy()->endOfDay()],
            '90d'    => [$now->copy()->subDays(89)->startOfDay(), $now->copy()->endOfDay()],
            'year'   => [$now->copy()->startOfYear(),          $now->copy()->endOfDay()],
            'all'    => [Carbon::createFromTimestamp(0),        $now->copy()->endOfDay()],
            default  => [$now->copy()->subDays(29)->startOfDay(), $now->copy()->endOfDay()], // 30d
        };
    }

    /**
     * Base query: orders that count as revenue (paid) within the range.
     */
    protected function paidOrders()
    {
        return DB::table('orders')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$this->from, $this->to]);
    }

    /**
     * Headline KPIs for the report.
     */
    public function summary(): array
    {
        $orders = $this->paidOrders();

        $grossRevenue = (float) (clone $orders)->sum('total_price');
        $orderCount   = (int)   (clone $orders)->count();
        $aov          = $orderCount > 0 ? $grossRevenue / $orderCount : 0.0;

        $paymentFees  = Schema::hasColumn('orders', 'payment_fee_amount')
            ? (float) (clone $orders)->sum('payment_fee_amount')
            : 0.0;

        // Items sold (join order_items on paid orders in range)
        $itemsSold = (int) DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$this->from, $this->to])
            ->sum('order_items.quantity');

        // Commission + seller earnings from vendor orders of paid orders
        $vendorAgg = DB::table('vendor_orders')
            ->join('orders', 'vendor_orders.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$this->from, $this->to])
            ->selectRaw('COALESCE(SUM(vendor_orders.commission_amount),0) as commission, COALESCE(SUM(vendor_orders.seller_earnings),0) as earnings')
            ->first();

        $commission     = (float) ($vendorAgg->commission ?? 0);
        $sellerEarnings = (float) ($vendorAgg->earnings ?? 0);

        // Refunds completed within range
        $refunds = 0.0;
        if (Schema::hasTable('refunds')) {
            $refunds = (float) DB::table('refunds')
                ->whereIn('status', ['completed', 'processing'])
                ->whereBetween('created_at', [$this->from, $this->to])
                ->sum('amount');
        }

        $netProfit = $commission - $paymentFees - $refunds;

        return [
            'gross_revenue'   => round($grossRevenue, 2),
            'order_count'     => $orderCount,
            'aov'             => round($aov, 2),
            'items_sold'      => $itemsSold,
            'commission'      => round($commission, 2),
            'seller_earnings' => round($sellerEarnings, 2),
            'payment_fees'    => round($paymentFees, 2),
            'refunds'         => round($refunds, 2),
            'net_profit'      => round($netProfit, 2),
        ];
    }

    /**
     * Revenue + order time-series. Daily if range <= 92 days, else monthly.
     *
     * @return array{labels: array, revenue: array, orders: array, granularity: string}
     */
    public function timeSeries(): array
    {
        $days = $this->from->diffInDays($this->to) + 1;
        $monthly = $days > 92;

        if ($monthly) {
            $rows = $this->paidOrders()
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as bucket, SUM(total_price) as revenue, COUNT(*) as orders")
                ->groupBy('bucket')->orderBy('bucket')->get();
            $fmt = fn($b) => Carbon::createFromFormat('Y-m', $b)->format('M Y');
        } else {
            $rows = $this->paidOrders()
                ->selectRaw("DATE(created_at) as bucket, SUM(total_price) as revenue, COUNT(*) as orders")
                ->groupBy('bucket')->orderBy('bucket')->get();
            $fmt = fn($b) => Carbon::parse($b)->format('M d');
        }

        $labels = $revenue = $orders = [];
        foreach ($rows as $r) {
            $labels[]  = $fmt($r->bucket);
            $revenue[] = round((float) $r->revenue, 2);
            $orders[]  = (int) $r->orders;
        }

        return [
            'labels'      => $labels,
            'revenue'     => $revenue,
            'orders'      => $orders,
            'granularity' => $monthly ? 'month' : 'day',
        ];
    }

    /**
     * Top products by revenue within range.
     */
    public function topProducts(int $limit = 10): array
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$this->from, $this->to])
            ->selectRaw('order_items.product_name, order_items.product_sku,
                         SUM(order_items.quantity) as units,
                         SUM(order_items.total) as revenue')
            ->groupBy('order_items.product_name', 'order_items.product_sku')
            ->orderByDesc('revenue')
            ->limit($limit)
            ->get()
            ->map(fn($r) => [
                'name'    => $r->product_name,
                'sku'     => $r->product_sku,
                'units'   => (int) $r->units,
                'revenue' => round((float) $r->revenue, 2),
            ])->all();
    }

    /**
     * Top sellers by revenue / commission within range.
     */
    public function topSellers(int $limit = 10): array
    {
        return DB::table('vendor_orders')
            ->join('orders', 'vendor_orders.order_id', '=', 'orders.id')
            ->join('sellers', 'vendor_orders.seller_id', '=', 'sellers.id')
            ->where('orders.payment_status', 'paid')
            ->whereBetween('orders.created_at', [$this->from, $this->to])
            ->selectRaw('sellers.store_name,
                         COUNT(DISTINCT vendor_orders.order_id) as orders,
                         SUM(vendor_orders.subtotal) as revenue,
                         SUM(vendor_orders.commission_amount) as commission,
                         SUM(vendor_orders.seller_earnings) as earnings')
            ->groupBy('sellers.store_name')
            ->orderByDesc('revenue')
            ->limit($limit)
            ->get()
            ->map(fn($r) => [
                'store'      => $r->store_name,
                'orders'     => (int) $r->orders,
                'revenue'    => round((float) $r->revenue, 2),
                'commission' => round((float) $r->commission, 2),
                'earnings'   => round((float) $r->earnings, 2),
            ])->all();
    }

    /**
     * Order-status breakdown across ALL orders in range (not just paid).
     */
    public function statusBreakdown(): array
    {
        return DB::table('orders')
            ->whereBetween('created_at', [$this->from, $this->to])
            ->selectRaw('status, COUNT(*) as count, SUM(total_price) as total')
            ->groupBy('status')
            ->orderByDesc('count')
            ->get()
            ->map(fn($r) => [
                'status' => $r->status,
                'count'  => (int) $r->count,
                'total'  => round((float) $r->total, 2),
            ])->all();
    }

    /**
     * Payment-method breakdown for paid orders in range.
     */
    public function paymentMethods(): array
    {
        return $this->paidOrders()
            ->selectRaw('payment_method, COUNT(*) as count, SUM(total_price) as total')
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->get()
            ->map(fn($r) => [
                'method' => $r->payment_method,
                'count'  => (int) $r->count,
                'total'  => round((float) $r->total, 2),
            ])->all();
    }
}
