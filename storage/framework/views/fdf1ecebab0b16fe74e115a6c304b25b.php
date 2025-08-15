<?php $__env->startSection('content'); ?>
<div class="p-8 bg-gray-300 dark:bg-[#181f31] min-h-screen">
    <h1 class="text-3xl mb-2 text-gray-900 dark:text-gray-100">Market Report for Ecommerce Website</h1>
    <p class="mb-8 text-gray-600 dark:text-gray-300">
        This dashboard highlights site activity and conversion stats with analytics charts based on your real store data.
    </p>

    
    <?php echo $__env->make('admin.dashboard.reports-dash._kpi-cards', ['stats' => $stats], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php echo $__env->make('admin.dashboard.reports-dash._analytics-charts', [
        'months' => $months,
        'ordersChart' => $ordersChart,
        'revenueChart' => $revenueChart,
        'userTypes' => $userTypes,
        'userTypeCounts' => $userTypeCounts,
        'reportsStatusData' => $reportsStatusData,
        'reportsStatusLabels' => $reportsStatusLabels
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php echo $__env->make('admin.dashboard.reports-dash._recent-orders', ['recentOrders' => $recentOrders], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('admin.dashboard.reports-dash._chart-scripts', [
        'months' => $months,
        'ordersChart' => $ordersChart,
        'revenueChart' => $revenueChart,
        'userTypes' => $userTypes,
        'userTypeCounts' => $userTypeCounts,
        'reportsStatusData' => $reportsStatusData,
        'reportsStatusLabels' => $reportsStatusLabels
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/dashboard/reports-dash/index.blade.php ENDPATH**/ ?>