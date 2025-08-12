<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserReport;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ReportDashController extends Controller
{
    public function index()
    {
        // Calculate total orders and revenue
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Stats array for dashboard analytics/market report
        $stats = [
            'total_customers' => User::count(),
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_reports' => UserReport::count(),
            'page_views' => Product::sum('page_views'),
            'goal_conversion' => '0%',
            'average_order_value' => $averageOrderValue, // <-- Added
        ];

        // Orders by month (current year)
        $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'];
        $ordersByMonthRaw = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();
        $ordersChart = [];
        foreach ($months as $i => $name) {
            $ordersChart[] = $ordersByMonthRaw[$i] ?? 0;
        }

        // Revenue by month (current year)
        $revenueByMonthRaw = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as sum'))
            ->whereYear('created_at', now()->year)
            ->where('payment_status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('sum', 'month')
            ->toArray();
        $revenueChart = [];
        foreach ($months as $i => $name) {
            $revenueChart[] = (float)($revenueByMonthRaw[$i] ?? 0);
        }

        // User Types
        $userTypes = ['Regular', 'Admin'];
        $userTypeCounts = [
            User::where('role', '!=', 'admin')->count(),
            User::where('role', 'admin')->count(),
        ];

        // Reports Status
        $reportsStatusLabels = ['Open', 'Resolved'];
        $reportsStatusData = [
            UserReport::where('status', 'open')->count(),
            UserReport::where('status', 'resolved')->count(),
        ];

        // Recent Orders
        $recentOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard.reports-dash.index', compact(
            'stats',
            'months',
            'ordersChart',
            'revenueChart',
            'userTypes',
            'userTypeCounts',
            'reportsStatusData',
            'reportsStatusLabels',
            'recentOrders'
        ));
    }
}
