<?php $__env->startSection('title', 'Products Management'); ?>

<?php $__env->startSection('content'); ?>
<!-- Header -->
<div class="flex justify-between items-center mb-6 flex-wrap gap-4">
    <div class="flex items-center">
        <span class="mr-2">
            <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'products','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'products','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']); ?>
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
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Products</h1>
    </div>
    <div class="flex space-x-4">
        <?php if(isset($importRoute)): ?>
            <a href="<?php echo e($importRoute); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-6 h-6 text-white mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Import
            </a>
        <?php endif; ?>
        <?php if(isset($createRoute)): ?>
            <a href="<?php echo e($createRoute); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Product
            </a>
        <?php endif; ?>
    </div>
</div>


<?php if(isset($filterFields) && is_array($filterFields)): ?>
    <?php if (isset($component)) { $__componentOriginal6745939b27c8af4f46b782316e447f80 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6745939b27c8af4f46b782316e447f80 = $attributes; } ?>
<?php $component = App\View\Components\Admin\FilterBar::resolve(['fields' => $filterFields,'action' => $filterAction ?? request()->url()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.filter-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\FilterBar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6745939b27c8af4f46b782316e447f80)): ?>
<?php $attributes = $__attributesOriginal6745939b27c8af4f46b782316e447f80; ?>
<?php unset($__attributesOriginal6745939b27c8af4f46b782316e447f80); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6745939b27c8af4f46b782316e447f80)): ?>
<?php $component = $__componentOriginal6745939b27c8af4f46b782316e447f80; ?>
<?php unset($__componentOriginal6745939b27c8af4f46b782316e447f80); ?>
<?php endif; ?>
<?php endif; ?>

<!-- Products Table -->
<div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
            <thead>
                <tr class="bg-gray-300 dark:bg-[#232c47]">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Category</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Added By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-100 dark:hover:bg-[#262c47]">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <?php echo $__env->make('products.partials.image-unified', ['product' => $product], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100"><?php echo e($product->name); ?></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">SKU: <?php echo e($product->sku); ?></div>
                                    <div class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">
                                        ID: <?php echo e($product->id); ?>

                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-100">
                            <?php echo e($product->category->name ?? 'No Category'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap justify-center flex text-sm text-gray-800 dark:text-gray-100">
                            <?php if($product->creator): ?>
                                <span class="flex items-center">
                                    <span class="inline-block px-2 py-1 rounded-full shadow text-xs font-semibold
                                        <?php echo e($product->creator->role == 'admin' ? 'bg-blue-900 text-blue-200' :
                                           ($product->creator->role == 'seller' ? 'bg-yellow-500 text-white' : 'bg-gray-400 text-white')); ?>">
                                        <?php echo e(ucfirst($product->creator->role)); ?>

                                    </span>
                                    <span class="ml-2"><?php echo e($product->creator->name); ?></span>
                                </span>
                            <?php else: ?>
                                <span class="text-gray-400">Unknown</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-100">$<?php echo e(number_format($product->price, 2)); ?></div>
                            <?php if($product->sale_price): ?>
                                <div class="text-xs text-green-600 dark:text-green-400">Sale: $<?php echo e(number_format($product->sale_price, 2)); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm <?php echo e($product->stock_quantity > 10 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                                <?php echo e($product->stock_quantity); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs rounded-full
                                  <?php echo e($product->is_active ? 'bg-green-100 dark:bg-green-950 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-950 text-red-800 dark:text-red-300'); ?>">
                                <?php echo e($product->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center space-x-3">
                                <?php if(isset($showRouteName)): ?>
                                    <?php if (isset($component)) { $__componentOriginal70a2035071353f1201414054627b0022 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70a2035071353f1201414054627b0022 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-view-button','data' => ['href' => route($showRouteName, $product)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-view-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route($showRouteName, $product))]); ?>
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
                                <?php endif; ?>
                                <?php if(isset($editRouteName)): ?>
                                    <?php if (isset($component)) { $__componentOriginald756e030c4774b83c500f23dd3d7c0ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald756e030c4774b83c500f23dd3d7c0ad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-edit-button','data' => ['href' => route($editRouteName, $product)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-edit-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route($editRouteName, $product))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald756e030c4774b83c500f23dd3d7c0ad)): ?>
<?php $attributes = $__attributesOriginald756e030c4774b83c500f23dd3d7c0ad; ?>
<?php unset($__attributesOriginald756e030c4774b83c500f23dd3d7c0ad); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald756e030c4774b83c500f23dd3d7c0ad)): ?>
<?php $component = $__componentOriginald756e030c4774b83c500f23dd3d7c0ad; ?>
<?php unset($__componentOriginald756e030c4774b83c500f23dd3d7c0ad); ?>
<?php endif; ?>
                                <?php endif; ?>
                                <?php if(isset($deleteRouteName)): ?>
                                    <?php if (isset($component)) { $__componentOriginal8f15d364f5bcededd1a8e1e23253c652 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f15d364f5bcededd1a8e1e23253c652 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-delete-button','data' => ['action' => route($deleteRouteName, $product)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-delete-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route($deleteRouteName, $product))]); ?>
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
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-300">
                            No products found for the current filters.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
        <?php echo e($products->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/products/partials/index.blade.php ENDPATH**/ ?>