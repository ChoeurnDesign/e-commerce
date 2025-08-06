<?php $__env->startSection('content'); ?>
<div class="p-8 bg-gray-300 dark:bg-[#181f31] min-h-screen">
    <h1 class="text-2xl font-bold mb-6 flex items-center text-gray-900 dark:text-gray-100">
        <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'settings','class' => 'w-6 h-6 mr-2 text-gray-700 dark:text-gray-200']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'settings','class' => 'w-6 h-6 mr-2 text-gray-700 dark:text-gray-200']); ?>
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
        Settings
    </h1>
    <table class="min-w-full bg-white dark:bg-[#23263a] rounded shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <thead>
            <tr>
                <th class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-gray-700 dark:text-gray-200">#</th>
                <th class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-gray-700 dark:text-gray-200">Setting</th>
                <th class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-gray-700 dark:text-gray-200">Value</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-center text-gray-800 dark:text-gray-100"><?php echo e($loop->iteration); ?></td>
                    <td class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-gray-800 dark:text-gray-100"><?php echo e($setting->key); ?></td>
                    <td class="px-4 py-2 border-b border-gray-200 dark:border-[#23263a] text-gray-800 dark:text-gray-100"><?php echo e($setting->value); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>