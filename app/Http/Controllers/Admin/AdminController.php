<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\UserReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // 1. Resolve timeline filter window based on requested inputs
        $range = $request->input('range', '1_week');

        $startDate = match ($range) {
            '1_month'  => Carbon::now()->subMonth(),
            '3_months' => Carbon::now()->subMonths(3),
            '6_months' => Carbon::now()->subMonths(6),
            '1_year'   => Carbon::now()->subYear(),
            default    => Carbon::now()->subDays(7), // default fallback to 7 days
        };

        // 2. Dashboard metrics overview grid (bound dynamically to filter context window)
        $stats = [
            'total_sales'      => Order::query()->where('payment_status', 'paid')
                ->where('created_at', '>=', $startDate)
                ->sum('total_price'),
            'total_orders'     => Order::query()->where('created_at', '>=', $startDate)->count(),
            'total_users'      => User::query()->where('role', 'user')
                ->where('created_at', '>=', $startDate)
                ->count(),
            'total_products'   => Product::query()->where('created_at', '>=', $startDate)->count(),
            'total_categories' => Category::query()->where('created_at', '>=', $startDate)->count(),
            'pending_orders'   => Order::query()->where('status', 'pending')
                ->where('created_at', '>=', $startDate)
                ->count(),
            'page_views'       => Product::query()->where('created_at', '>=', $startDate)->sum('page_views'),
        ];

        // 3. Recent Orders stream breakdown list
        $recentOrders = Order::query()->with(['user', 'orderItems'])
            ->where('created_at', '>=', $startDate)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // 4. Dynamic step rendering loops tracking daily sales values
        $dailySales = [];
        // Calculate standard length loops corresponding to filter timeline parameters
        $daysCount = match ($range) {
            '1_month'  => 30,
            '3_months' => 90,
            '6_months' => 180,
            '1_year'   => 365,
            default    => 7,
        };

        for ($i = ($daysCount - 1); $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $sales = Order::query()->where('payment_status', 'paid')
                ->whereDate('created_at', $date)
                ->sum('total_price');
            
            // Format labels more tightly if showing longer timelines to keep the chart legible
            $labelFormat = $daysCount > 30 ? 'M j, Y' : 'D, M j';
            $dailySales[$date->format($labelFormat)] = $sales;
        }

        // 5. Order state distribution patterns for analytics chart layers
        $orderStatusData = Order::query()->where('created_at', '>=', $startDate)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $pageViews = $stats['page_views'];

        // 6. Admin notifications streams 
        $reports = UserReport::query()->where('created_at', '>=', $startDate)
            ->latest()->take(5)->get();
            
        $unreadCount = UserReport::query()->where('is_read', false)
            ->where('created_at', '>=', $startDate)
            ->count();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'dailySales',
            'orderStatusData',
            'pageViews',
            'reports',
            'unreadCount',
            'range'
        ));
    }
}