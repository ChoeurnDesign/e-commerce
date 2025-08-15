<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="<?php echo e(route('orders.history')); ?>"
                   class="inline-flex items-center text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Orders
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 mb-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Order #<?php echo e($order->order_number); ?></h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-2">Placed on <?php echo e($order->created_at->format('F d, Y \a\t h:i A')); ?></p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <?php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-700 dark:text-yellow-100 dark:border-yellow-600',
                                'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-700 dark:text-blue-100 dark:border-blue-600',
                                'processing' => 'bg-indigo-100 text-indigo-800 border-indigo-200 dark:bg-indigo-700 dark:text-indigo-100 dark:border-indigo-600',
                                'shipped' => 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-700 dark:text-purple-100 dark:border-purple-600',
                                'delivered' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-700 dark:text-green-100 dark:border-green-600',
                                'cancelled' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-700 dark:text-red-100 dark:border-red-600'
                            ];
                        ?>
                        <span class="inline-flex px-4 py-2 text-sm font-semibold rounded-lg border <?php echo e($statusColors[$order->status] ?? 'bg-gray-300 text-gray-800 border-gray-200 dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600'); ?>">
                            <?php echo e(ucfirst($order->status)); ?>

                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Order Items (<?php echo e($order->orderItems->count()); ?> items)</h2>
                        </div>
                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="p-6 flex items-center space-x-4">
                                    <?php if($item->product && $item->product->image): ?>
                                        <img src="<?php echo e(asset('img/products/' . $item->product->image)); ?>"
                                             alt="<?php echo e($item->product_name); ?>"
                                             class="w-16 h-16 object-cover rounded-lg">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-gray-300 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>

                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100"><?php echo e($item->product_name); ?></h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">SKU: <?php echo e($item->product_sku); ?></p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Quantity: <?php echo e($item->quantity); ?></p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            <?php echo e(\App\Helpers\CurrencyHelper::format($item->price)); ?>

                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Each</p>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                            <?php echo e(\App\Helpers\CurrencyHelper::format($item->total)); ?>

                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Total</p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="px-6 py-4 bg-gray-300 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                    <span class="text-gray-900 dark:text-gray-100">
                                        <?php echo e(\App\Helpers\CurrencyHelper::format($order->subtotal)); ?>

                                    </span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Tax</span>
                                    <span class="text-gray-900 dark:text-gray-100">
                                        <?php echo e(\App\Helpers\CurrencyHelper::format($order->tax_amount)); ?>

                                    </span>
                                </div>
                                <div class="flex justify-between text-lg font-bold border-t border-gray-200 dark:border-gray-700 pt-2">
                                    <span class="text-gray-900 dark:text-gray-100">Total</span>
                                    <span class="text-gray-900 dark:text-gray-100">
                                        <?php echo e(\App\Helpers\CurrencyHelper::format($order->total_price)); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Payment Information</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Method</span>
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100"><?php echo e(ucfirst(str_replace('_', ' ', $order->payment_method))); ?></p>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Payment Status</span>
                                <p class="text-sm font-medium <?php echo e($order->payment_status === 'paid' ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400'); ?>">
                                    <?php echo e(ucfirst($order->payment_status)); ?>

                                </p>
                            </div>
                            <?php if($order->payment_id): ?>
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Transaction ID</span>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100"><?php echo e($order->payment_id); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Shipping Address</h3>
                        <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                            <p class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($order->customer_name); ?></p>
                            <p><?php echo e($order->shipping_address); ?></p>
                            <p><?php echo e($order->shipping_city); ?>, <?php echo e($order->shipping_state); ?> <?php echo e($order->shipping_postal_code); ?></p>
                            <p><?php echo e($order->shipping_country); ?></p>
                            <?php if($order->customer_phone): ?>
                                <p class="mt-2"><?php echo e($order->customer_phone); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($order->billing_address !== $order->shipping_address): ?>
                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Billing Address</h3>
                            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                <p class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($order->customer_name); ?></p>
                                <p><?php echo e($order->billing_address); ?></p>
                                <p><?php echo e($order->billing_city); ?>, <?php echo e($order->billing_state); ?> <?php echo e($order->billing_postal_code); ?></p>
                                <p><?php echo e($order->billing_country); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($order->notes): ?>
                        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Notes</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($order->notes); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/orders/show.blade.php ENDPATH**/ ?>