<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        {{-- Dynamic Title --}}
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            {{-- This will dynamically show "Last 1 Month", "Last 3 Months", etc. --}}
            Sales (Last {{ str_replace('_', ' ', $range) }})
        </h3>
        <div class="h-64">
            @if(!empty($dailySales))
                <canvas id="salesChart" class="w-full h-full"></canvas>
            @else
                <div class="flex items-center justify-center h-full">
                    <p class="text-gray-500 dark:text-gray-400">No sales data yet</p>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        {{-- Dynamic Title --}}
       <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Order Status Distribution (Last {{ str_replace('_', ' ', $range) }})
        </h3>
        <div class="h-64">
            @if(!empty($orderStatusData))
                <canvas id="statusChart" class="w-full h-full"></canvas>
            @else
                <div class="flex items-center justify-center h-full">
                    <p class="text-gray-500 dark:text-gray-400">No orders yet</p>
                </div>
            @endif
        </div>
    </div>
</div>