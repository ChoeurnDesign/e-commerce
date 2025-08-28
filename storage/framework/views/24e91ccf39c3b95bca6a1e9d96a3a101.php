<?php $__env->startSection('title', 'Orders Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <span class="mr-2">
            <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'orders','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'orders','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $attributes = $__attributesOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__attributesOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $component = $__componentOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__componentOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
        </span>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Orders</h1>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal3b92e91ca199bcc05fbf8ea1b4f94559 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b92e91ca199bcc05fbf8ea1b4f94559 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.simple-search','data' => ['placeholder' => 'Order # / Name / Email','hint' => 'ID, order number, customer name/email','autofocus' => true,'width' => 'w-80']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.simple-search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Order # / Name / Email','hint' => 'ID, order number, customer name/email','autofocus' => true,'width' => 'w-80']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b92e91ca199bcc05fbf8ea1b4f94559)): ?>
<?php $attributes = $__attributesOriginal3b92e91ca199bcc05fbf8ea1b4f94559; ?>
<?php unset($__attributesOriginal3b92e91ca199bcc05fbf8ea1b4f94559); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b92e91ca199bcc05fbf8ea1b4f94559)): ?>
<?php $component = $__componentOriginal3b92e91ca199bcc05fbf8ea1b4f94559; ?>
<?php unset($__componentOriginal3b92e91ca199bcc05fbf8ea1b4f94559); ?>
<?php endif; ?>

    <div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead>
                <tr class="bg-gray-300 dark:bg-[#232c47]">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Total Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Payment Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Order Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-300 dark:hover:bg-[#262c47]">
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">#<?php echo e($order->id); ?></td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                            <?php echo e($order->display_name); ?>

                            <br>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                <?php echo e($order->display_email); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-indigo-700 dark:text-indigo-300">
                            $<?php echo e(number_format($order->total_price, 2)); ?>

                        </td>
                        <td class="px-6 py-4">
                            
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                <?php echo e($order->payment_status == 'paid'
                                    ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300'
                                    : ($order->payment_status == 'pending'
                                        ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300'
                                        : 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300')); ?>">
                                <?php echo e(ucfirst($order->payment_status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                                    'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300' => $order->status === 'pending',
                                    'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' => $order->status === 'processing',
                                    'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200'        => $order->status === 'confirmed',
                                    'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300'=> $order->status === 'shipped',
                                    'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300'    => $order->status === 'delivered' || $order->status === 'completed',
                                    'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300'            => $order->status === 'cancelled',
                                    'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200'        => ! in_array($order->status, ['pending','processing','confirmed','shipped','delivered','completed','cancelled']),
                                ]); ?>"">
                                <?php echo e(ucfirst($order->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                            <?php echo e($order->created_at->format('Y-m-d H:i')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center space-x-3">
                                <?php if (isset($component)) { $__componentOriginal70a2035071353f1201414054627b0022 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70a2035071353f1201414054627b0022 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-view-button','data' => ['href' => route('admin.orders.show', $order)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-view-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.orders.show', $order))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal70a2035071353f1201414054627b0022)): ?>
<?php $attributes = $__attributesOriginal70a2035071353f1201414054627b0022; ?>
<?php unset($__attributesOriginal70a2035071353f1201414054627b0022); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal70a2035071353f1201414054627b0022)): ?>
<?php $component = $__componentOriginal70a2035071353f1201414054627b0022; ?>
<?php unset($__componentOriginal70a2035071353f1201414054627b0022); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal8f15d364f5bcededd1a8e1e23253c652 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f15d364f5bcededd1a8e1e23253c652 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-delete-button','data' => ['action' => route('admin.orders.destroy', $order)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-delete-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.orders.destroy', $order))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f15d364f5bcededd1a8e1e23253c652)): ?>
<?php $attributes = $__attributesOriginal8f15d364f5bcededd1a8e1e23253c652; ?>
<?php unset($__attributesOriginal8f15d364f5bcededd1a8e1e23253c652); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f15d364f5bcededd1a8e1e23253c652)): ?>
<?php $component = $__componentOriginal8f15d364f5bcededd1a8e1e23253c652; ?>
<?php unset($__componentOriginal8f15d364f5bcededd1a8e1e23253c652); ?>
<?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-500 dark:text-gray-300 text-lg">
                            No orders found.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
            <?php echo e($orders->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>