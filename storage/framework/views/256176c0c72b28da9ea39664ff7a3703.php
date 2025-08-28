<?php
    // Ensure $orders is a collection
    $orders = $orders ?? collect();
?>

<div class="mb-8">
    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Seller Orders</h3>

    <?php if($orders->count()): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a] bg-white dark:bg-[#23263a] rounded shadow">
                <thead>
                <tr class="bg-gray-200 dark:bg-[#232c47]">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Order Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Created At</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-[#23263a] bg-white dark:bg-[#23263a]">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-100 dark:hover:bg-[#232c47]">
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-semibold">
                            #<?php echo e($order->id); ?>

                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                            <?php echo e($order->order_number); ?>

                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                            <?php echo e($order->customer?->name ?? '-'); ?>

                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                            $<?php echo e(number_format((float) ($order->total_price ?? 0), 2)); ?>

                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-2 py-1 rounded-full text-xs
                                <?php if($order->status === 'pending'): ?> bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300
                                <?php elseif($order->status === 'completed'): ?> bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300
                                <?php elseif($order->status === 'cancelled'): ?> bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300
                                <?php else: ?> bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 <?php endif; ?>">
                                <?php echo e(ucfirst($order->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                            <?php echo e(optional($order->created_at)->format('Y-m-d H:i')); ?>

                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>"
                               class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs rounded transition"
                               title="View Order" target="_blank">
                                View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="text-gray-500 dark:text-gray-300 text-center py-8">
            No orders found for this seller.
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/sellers/partials/orders.blade.php ENDPATH**/ ?>