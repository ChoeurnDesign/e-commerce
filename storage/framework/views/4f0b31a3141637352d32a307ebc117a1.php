<tr class="hover:bg-gray-300 dark:hover:bg-[#262c47]">
    <td class="px-6 py-4">
        <div class="flex items-center">
            <img class="h-10 w-10 rounded-lg object-cover" src="<?php echo e($product->image ? asset('img/products/' . $product->image) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name)); ?>" alt="<?php echo e($product->name); ?>">
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900 dark:text-gray-100"><?php echo e($product->name); ?></div>
                <div class="text-sm text-gray-500 dark:text-gray-400">SKU: <?php echo e($product->sku); ?></div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
        <?php echo e($product->category->name ?? 'No Category'); ?>

    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-900 dark:text-gray-100">$<?php echo e(number_format($product->price, 2)); ?></div>
        <?php if($product->sale_price): ?>
            <div class="text-sm text-green-600 dark:text-green-400">Sale: $<?php echo e(number_format($product->sale_price, 2)); ?></div>
        <?php endif; ?>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="text-sm <?php echo e($product->stock_quantity > 10 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
            <?php echo e($product->stock_quantity); ?>

        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <span class="inline-flex px-2 py-1 text-xs rounded-full <?php echo e($product->is_active ? 'bg-green-100 dark:bg-green-950 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-950 text-red-800 dark:text-red-300'); ?>">
            <?php echo e($product->is_active ? 'Active' : 'Inactive'); ?>

        </span>
    </td>
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center justify-center space-x-3">
            <?php if (isset($component)) { $__componentOriginal70a2035071353f1201414054627b0022 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70a2035071353f1201414054627b0022 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-view-button','data' => ['href' => route('admin.products.show', $product)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-view-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.products.show', $product))]); ?>
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
            <?php if (isset($component)) { $__componentOriginald756e030c4774b83c500f23dd3d7c0ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald756e030c4774b83c500f23dd3d7c0ad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-edit-button','data' => ['href' => route('admin.products.edit', $product)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-edit-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.products.edit', $product))]); ?>
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
            <?php if (isset($component)) { $__componentOriginal8f15d364f5bcededd1a8e1e23253c652 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f15d364f5bcededd1a8e1e23253c652 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-delete-button','data' => ['action' => route('admin.products.destroy', $product)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-delete-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.products.destroy', $product))]); ?>
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
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/products/partials/row.blade.php ENDPATH**/ ?>