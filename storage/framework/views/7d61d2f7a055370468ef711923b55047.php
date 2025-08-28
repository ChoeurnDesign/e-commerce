<?php $__env->startSection('title', 'Categories Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 min-h-screen">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <span class="mr-2">
                <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'categories','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'categories','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']); ?>
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
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Categories</h1>
        </div>

        <a href="<?php echo e(route('admin.categories.create')); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Category
        </a>
    </div>

    <!-- Categories Table -->
    <div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead>
                    <tr class="bg-gray-300 dark:bg-[#232c47]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Category Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Parent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Products</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                    <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-300 dark:hover:bg-[#262c47]">
                            <td class="px-6 py-4">
                                <img src="<?php echo e($category->image ? asset($category->image) : asset('/img/default-category.png')); ?>"
                                    alt="<?php echo e($category->name); ?>"
                                    class="h-20 w-20 rounded-full object-cover border border-indigo-200 dark:border-indigo-700"
                                    onerror="this.onerror=null;this.src='<?php echo e(asset('/img/default-category.png')); ?>';">
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                <?php echo e($category->name); ?>

                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                <?php echo e(Str::limit($category->description, 50)); ?>

                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                <?php echo e($category->parent?->name ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 px-2 py-1 rounded-full text-xs"><?php echo e($category->products_count ?? 0); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-3">
                                    <?php if (isset($component)) { $__componentOriginal70a2035071353f1201414054627b0022 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70a2035071353f1201414054627b0022 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-view-button','data' => ['href' => route('admin.categories.show', $category)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-view-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.categories.show', $category))]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-edit-button','data' => ['href' => route('admin.categories.edit', $category)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-edit-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.categories.edit', $category))]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-delete-button','data' => ['action' => route('admin.categories.destroy', $category)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-delete-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.categories.destroy', $category))]); ?>
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
                            <td colspan="6" class="py-12 text-center text-gray-500 dark:text-gray-300 text-lg">
                                No categories found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
            <?php echo e($categories->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>