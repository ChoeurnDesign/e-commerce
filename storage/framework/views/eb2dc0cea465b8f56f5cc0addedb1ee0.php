<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Sales Chart (Last 7 Days) -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Sales (Last 7 Days)</h3>
        <div class="h-64">
            <?php if(!empty($dailySales)): ?>
                <canvas id="salesChart" class="w-full h-full"></canvas>
            <?php else: ?>
                <div class="flex items-center justify-center h-full">
                    <p class="text-gray-500 dark:text-gray-400">No sales data yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Order Status Chart (Last 7 Days) -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-200 dark:border-[#23263a]">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Status Distribution (Last 7 Days)</h3>
        <div class="h-64">
            <?php if(!empty($orderStatusData)): ?>
                <canvas id="statusChart" class="w-full h-full"></canvas>
            <?php else: ?>
                <div class="flex items-center justify-center h-full">
                    <p class="text-gray-500 dark:text-gray-400">No orders yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/dashboard/_charts.blade.php ENDPATH**/ ?>