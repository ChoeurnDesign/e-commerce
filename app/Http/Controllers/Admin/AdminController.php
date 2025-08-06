<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $lastWeek = Carbon::now()->subDays(7);

        // Dashboard stats (only last 7 days)
        $stats = [
            'total_sales'      => Order::where('payment_status', 'paid')
                ->where('created_at', '>=', $lastWeek)
                ->sum('total_price'),
            'total_orders'     => Order::where('created_at', '>=', $lastWeek)->count(),
            'total_users'      => User::where('role', 'user')
                ->where('created_at', '>=', $lastWeek)
                ->count(),
            'total_products'   => Product::where('created_at', '>=', $lastWeek)->count(),
            'total_categories' => Category::where('created_at', '>=', $lastWeek)->count(),
            'pending_orders'   => Order::where('status', 'pending')
                ->where('created_at', '>=', $lastWeek)
                ->count(),
            'page_views'       => Product::where('created_at', '>=', $lastWeek)->sum('page_views'),
        ];

        // Recent orders (last 10, in last 7 days)
        $recentOrders = Order::with(['user', 'orderItems'])
            ->where('created_at', '>=', $lastWeek)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // Daily sales for the last 7 days
        $dailySales = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $sales = Order::where('payment_status', 'paid')
                ->whereDate('created_at', $date)
                ->sum('total_price');
            $dailySales[$date->format('D, M j')] = $sales;
        }

        // Order status distribution (last 7 days)
        $orderStatusData = Order::where('created_at', '>=', $lastWeek)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $pageViews = $stats['page_views'];

        // Admin notifications (last 7 days)
        $reports = Report::where('created_at', '>=', $lastWeek)
            ->latest()->take(5)->get();
        $unreadCount = Report::where('is_read', false)
            ->where('created_at', '>=', $lastWeek)
            ->count();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'dailySales',
            'orderStatusData',
            'pageViews',
            'reports',
            'unreadCount'
        ));
    }
}
