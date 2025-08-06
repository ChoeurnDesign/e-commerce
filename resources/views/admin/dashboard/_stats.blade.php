<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
    <!-- Total Sales -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-200 dark:bg-green-900 text-green-600 dark:text-green-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Total Sales
                    <span class="text-xs text-gray-400 block">(Last 7 days)</span>
                </p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                    ${{ number_format($stats['total_sales'], 2) }}
                </p>
            </div>
        </div>
    </div>
    <!-- Total Orders -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-200 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Total Orders
                    <span class="text-xs text-gray-400 block">(Last 7 days)</span>
                </p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['total_orders']) }}</p>
            </div>
        </div>
    </div>
    <!-- Total Users -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-200 dark:bg-purple-900 text-purple-600 dark:text-purple-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Total Users
                    <span class="text-xs text-gray-400 block">(Last 7 days)</span>
                </p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['total_users']) }}</p>
            </div>
        </div>
    </div>
    <!-- Products -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-200 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Products
                    <span class="text-xs text-gray-400 block">(Last 7 days)</span>
                </p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['total_products']) }}</p>
            </div>
        </div>
    </div>
    <!-- Categories -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-indigo-200 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Categories
                    <span class="text-xs text-gray-400 block">(Last 7 days)</span>
                </p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['total_categories']) }}</p>
            </div>
        </div>
    </div>
    <!-- Pending Orders -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-200 dark:bg-red-900 text-red-600 dark:text-red-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600 dark:text-gray-300">
                    Pending Orders
                    <span class="text-xs text-gray-400 block">(Last 7 days)</span>
                </p>
                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['pending_orders']) }}</p>
            </div>
        </div>
    </div>
</div>
