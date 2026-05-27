<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
    {{-- Customers Card --}}
    <div class="bg-white dark:bg-[#23263a] rounded-xl border border-gray-200 dark:border-transparent shadow-sm p-5 flex flex-col items-center transition-colors duration-150">
        <div class="text-indigo-600 dark:text-indigo-400 p-3 bg-indigo-50 dark:bg-gray-700 rounded-full mb-2">
            <i class="fas fa-users fa-xl"></i>
        </div>
        <span class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $stats['total_customers'] ?? 0 }}</span>
        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-1">Customers</span>
    </div>

    {{-- Orders Card --}}
    <div class="bg-white dark:bg-[#23263a] rounded-xl border border-gray-200 dark:border-transparent shadow-sm p-5 flex flex-col items-center transition-colors duration-150">
        <div class="text-indigo-600 dark:text-indigo-400 p-3 bg-indigo-50 dark:bg-gray-700 rounded-full mb-2">
            <i class="fas fa-shopping-cart fa-xl"></i>
        </div>
        <span class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $stats['total_orders'] ?? 0 }}</span>
        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-1">Orders</span>
    </div>

    {{-- Revenue Card --}}
    <div class="bg-white dark:bg-[#23263a] rounded-xl border border-gray-200 dark:border-transparent shadow-sm p-5 flex flex-col items-center transition-colors duration-150">
        <div class="text-indigo-600 dark:text-indigo-400 p-3 bg-indigo-50 dark:bg-gray-700 rounded-full mb-2">
            <i class="fas fa-dollar-sign fa-xl"></i>
        </div>
        <span class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">${{ number_format($stats['total_revenue'] ?? 0, 2) }}</span>
        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-1">Revenue</span>
    </div>

    {{-- Page Views Card --}}
    <div class="bg-white dark:bg-[#23263a] rounded-xl border border-gray-200 dark:border-transparent shadow-sm p-5 flex flex-col items-center transition-colors duration-150">
        <div class="text-indigo-600 dark:text-indigo-400 p-3 bg-indigo-50 dark:bg-gray-700 rounded-full mb-2">
            <i class="fas fa-eye fa-xl"></i>
        </div>
        <span class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $stats['page_views'] ?? 0 }}</span>
        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-1">Page Views</span>
    </div>

    {{-- Reports Card --}}
    <div class="bg-white dark:bg-[#23263a] rounded-xl border border-gray-200 dark:border-transparent shadow-sm p-5 flex flex-col items-center transition-colors duration-150">
        <div class="text-indigo-600 dark:text-indigo-400 p-3 bg-indigo-50 dark:bg-gray-700 rounded-full mb-2">
            <i class="fas fa-file-alt fa-xl"></i>
        </div>
        <span class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $stats['total_reports'] ?? 0 }}</span>
        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-1">Reports</span>
    </div>

    {{-- Average Order Value Card --}}
    <div class="bg-white dark:bg-[#23263a] rounded-xl border border-gray-200 dark:border-transparent shadow-sm p-5 flex flex-col items-center transition-colors duration-150">
        <div class="text-indigo-600 dark:text-indigo-400 p-3 bg-indigo-50 dark:bg-gray-700 rounded-full mb-2">
            <i class="fas fa-dollar-sign fa-xl"></i>
        </div>
        <span class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">${{ number_format($stats['average_order_value'] ?? 0, 2) }}</span>
        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mt-1">Avg Order Value</span>
    </div>
</div>