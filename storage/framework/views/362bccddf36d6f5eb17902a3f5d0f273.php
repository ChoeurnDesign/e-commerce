<?php $__env->startSection('title','Products On Sale'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 min-h-screen">
    <div class="flex items-center mb-6">
        <span class="mr-2">
            <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'onsale','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'onsale','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']); ?>
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
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">On Sale</h1>
    </div>

    <?php if (isset($component)) { $__componentOriginal3b92e91ca199bcc05fbf8ea1b4f94559 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b92e91ca199bcc05fbf8ea1b4f94559 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.simple-search','data' => ['placeholder' => 'ID / Name / SKU','hint' => 'Search by product id, name or SKU','width' => 'w-80','autofocus' => true,'action' => ''.e(route('admin.onsale.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.simple-search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'ID / Name / SKU','hint' => 'Search by product id, name or SKU','width' => 'w-80','autofocus' => true,'action' => ''.e(route('admin.onsale.index')).'']); ?>
        
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

    <?php if($products->count()): ?>
        <div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-[#292e45]">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-[#232c47]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Sale Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Compare Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Original Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">% Off</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-300 dark:hover:bg-[#262c47] transition">
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                <?php echo e(($products->currentPage() - 1) * $products->perPage() + $loop->iteration); ?>

                            </td>
                            <td class="px-6 py-4 text-indigo-700 dark:text-indigo-300">
                                <?php echo e($product->name); ?>

                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 px-3 py-1 rounded-full font-bold text-sm">
                                    $<?php echo e(number_format($product->sale_price,2)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full font-bold text-sm">
                                    $<?php echo e(number_format($product->compare_price,2)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded-full font-bold text-sm">
                                    $<?php echo e(number_format($product->price,2)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if($product->discount_percent): ?>
                                    <span class="inline-block bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 px-2 py-1 rounded-full text-xs font-semibold">
                                        -<?php echo e($product->discount_percent); ?>%
                                    </span>
                                <?php else: ?>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <?php if (isset($component)) { $__componentOriginald756e030c4774b83c500f23dd3d7c0ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald756e030c4774b83c500f23dd3d7c0ad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-edit-button','data' => ['href' => route('admin.onsale.edit', $product)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-edit-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.onsale.edit', $product))]); ?>
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
                                    <form method="POST" action="<?php echo e(route('admin.products.removeFromSale', $product)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <button type="submit"
                                            class="px-2 py-1 text-xs rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
                <?php echo e($products->links()); ?>

            </div>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center justify-center h-48 bg-[#23263a] rounded-lg shadow mt-4">
            <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'tag','class' => 'h-10 w-10 text-gray-400 mb-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'tag','class' => 'h-10 w-10 text-gray-400 mb-2']); ?>
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
            <p class="text-gray-400 text-lg font-medium">No products on sale.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/onsale/index.blade.php ENDPATH**/ ?>