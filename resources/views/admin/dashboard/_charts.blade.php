<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">
            Sales ({{ str_replace('_', ' ', ucwords($range, '_')) }})
        </h3>
        <div class="h-64">
            @if(!empty($dailySales))
                <canvas id="salesChart" class="w-full h-full"></canvas>
            @else
                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                    <svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm">No sales data yet</p>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">
            Order Status ({{ str_replace('_', ' ', ucwords($range, '_')) }})
        </h3>
        <div class="h-64">
            @if(!empty($orderStatusData))
                <canvas id="statusChart" class="w-full h-full"></canvas>
            @else
                <div class="flex flex-col items-center justify-center h-full text-gray-400">
                    <svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                    <p class="text-sm">No orders yet</p>
                </div>
            @endif
        </div>
    </div>
</div>
