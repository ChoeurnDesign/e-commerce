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
    <div class="py-8 bg-gray-200 dark:bg-gray-900 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-8">
                <div class="flex items-center mb-8">
                    <img src="<?php echo e($seller->logo ?? 'https://ui-avatars.com/api/?name='.urlencode($seller->store_name ?? $seller->name)); ?>"
                         alt="<?php echo e($seller->store_name ?? $seller->name); ?>"
                         class="w-24 h-24 rounded-full border-4 border-sky-500 dark:border-sky-700 mr-6 bg-white dark:bg-gray-900 object-cover">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100"><?php echo e($seller->store_name ?? $seller->name); ?></h1>
                        <p class="text-gray-600 dark:text-gray-300 mt-2"><?php echo e($seller->description ?? 'No description provided.'); ?></p>
                        <div class="mt-3">
                            <span class="inline-block bg-sky-100 dark:bg-sky-900 text-sky-700 dark:text-sky-300 px-3 py-1 rounded mr-2">
                                Products: <?php echo e($seller->products_count ?? $seller->products()->count()); ?>

                            </span>
                            <span class="inline-block bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 px-3 py-1 rounded mr-2">
                                Followers: <?php echo e($seller->followers_count ?? 0); ?>

                            </span>
                            <span class="inline-block bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-3 py-1 rounded">
                                Opened: <?php echo e($seller->created_at->format('Y-m-d')); ?>

                            </span>
                        </div>
                    </div>
                </div>
                <div class="mb-6">
                    <h2 class="font-semibold text-lg mb-2 text-gray-900 dark:text-gray-100">Contact Information</h2>
                    <ul class="text-gray-700 dark:text-gray-300">
                        <li><strong>Email:</strong> <?php echo e($seller->contact_email ?? 'N/A'); ?></li>
                        <li><strong>Location:</strong> <?php echo e($seller->location ?? 'Not specified'); ?></li>
                        <li><strong>Business Document:</strong> <?php echo e($seller->business_document ?? 'N/A'); ?></li>
                    </ul>
                </div>
                <div class="mb-6">
                    <h2 class="font-semibold text-lg mb-2 text-gray-900 dark:text-gray-100">Products</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="bg-gray-100 dark:bg-gray-700 rounded p-4">
                                <div class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($product->name); ?></div>
                                <div class="text-sky-700 dark:text-sky-400 font-bold">$<?php echo e($product->price); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-gray-500 dark:text-gray-400 col-span-3">No products found.</div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-6 flex justify-center">
                        <?php echo e($products->links()); ?>

                    </div>
                </div>
                <div>
                    <a href="<?php echo e(route('stores.index')); ?>" class="text-sky-700 dark:text-sky-400 hover:underline">← Back to all stores</a>
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
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/store/show.blade.php ENDPATH**/ ?>