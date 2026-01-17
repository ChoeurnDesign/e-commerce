<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
    <div class="bg-white dark:bg-[#23263a] rounded-md shadow p-4 flex flex-col items-center">
        <div class="text-indigo-600 dark:text-indigo-300"><i class="fas fa-users fa-2x"></i></div>
        <span class="text-2xl text-gray-100 mt-2">{{ $stats['total_customers'] ?? 0 }}</span>
        <span class="text-xs text-gray-100">Customers</span>
    </div>
    <div class="bg-white dark:bg-[#23263a] rounded-md shadow p-4 flex flex-col items-center">
        <div class="text-indigo-600 dark:text-indigo-300"><i class="fas fa-shopping-cart fa-2x"></i></div>
        <span class="text-2xl text-gray-100 mt-2">{{ $stats['total_orders'] ?? 0 }}</span>
        <span class="text-xs text-gray-100">Orders</span>
    </div>
    <div class="bg-white dark:bg-[#23263a] rounded-md shadow p-4 flex flex-col items-center">
        <div class="text-indigo-600 dark:text-indigo-300"><i class="fas fa-dollar-sign fa-2x"></i></div>
        <span class="text-2xl text-gray-100 mt-2">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</span>
        <span class="text-xs text-gray-100">Revenue</span>
    </div>
    <div class="bg-white dark:bg-[#23263a] rounded-md shadow p-4 flex flex-col items-center">
        <div class="text-indigo-600 dark:text-indigo-300"><i class="fas fa-eye fa-2x"></i></div>
        <span class="text-2xl text-gray-100 mt-2">{{ $stats['page_views'] ?? 0 }}</span>
        <span class="text-xs text-gray-100">Page Views</span>
    </div>
    <div class="bg-white dark:bg-[#23263a] rounded-md shadow p-4 flex flex-col items-center">
        <div class="text-indigo-600 dark:text-indigo-300"><i class="fas fa-file-alt fa-2x"></i></div>
        <span class="text-2xl text-gray-100 mt-2">{{ $stats['total_reports'] ?? 0 }}</span>
        <span class="text-xs text-gray-100">Reports</span>
    </div>
    <div class="bg-white dark:bg-[#23263a] rounded-md shadow p-4 flex flex-col items-center">
        <div class="text-indigo-600 dark:text-indigo-300"><i class="fas fa-dollar-sign fa-2x"></i></div>
        <span class="text-2xl text-gray-100 mt-2">${{ number_format($stats['average_order_value'], 2) }}</span>
        <span class="text-xs text-gray-100">Avg Order Value</span>
    </div>
</div>
