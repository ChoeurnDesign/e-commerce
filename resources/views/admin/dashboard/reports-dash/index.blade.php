@extends('layouts.admin')

@section('title', 'Reports Management')

@section('content')
<div class="p-8 bg-gray-300 dark:bg-[#181f31] min-h-screen">
    <h1 class="text-3xl mb-2 text-gray-900 dark:text-gray-100">Market Report for Ecommerce Website</h1>
    <p class="mb-8 text-gray-600 dark:text-gray-300">
        This dashboard highlights site activity and conversion stats with analytics charts based on your real store data.
    </p>

    {{-- KPI Cards --}}
    @include('admin.dashboard.reports-dash._kpi-cards', ['stats' => $stats])

    {{-- Analytics Charts --}}
    @include('admin.dashboard.reports-dash._analytics-charts', [
        'months' => $months,
        'ordersChart' => $ordersChart,
        'revenueChart' => $revenueChart,
        'userTypes' => $userTypes,
        'userTypeCounts' => $userTypeCounts,
        'reportsStatusData' => $reportsStatusData,
        'reportsStatusLabels' => $reportsStatusLabels
    ])

    {{-- Recent Orders Table --}}
    @include('admin.dashboard.reports-dash._recent-orders', ['recentOrders' => $recentOrders])
</div>
@endsection

@push('scripts')
    @include('admin.dashboard.reports-dash._chart-scripts', [
        'months' => $months,
        'ordersChart' => $ordersChart,
        'revenueChart' => $revenueChart,
        'userTypes' => $userTypes,
        'userTypeCounts' => $userTypeCounts,
        'reportsStatusData' => $reportsStatusData,
        'reportsStatusLabels' => $reportsStatusLabels
    ])
@endpush
