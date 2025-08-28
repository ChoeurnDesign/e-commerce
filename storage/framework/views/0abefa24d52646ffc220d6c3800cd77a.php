<?php $__env->startSection('title', 'Seller Detail'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 min-h-screen">
    <div class="flex items-center mb-6">
        <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'users','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'users','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']); ?>
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
        <h1 class="ml-2 text-2xl font-bold text-gray-900 dark:text-gray-100">Seller Detail</h1>
    </div>

    <div class="bg-white dark:bg-[#23263a] p-6 rounded shadow">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><b>Name:</b> <?php echo e($seller->user?->name ?? '-'); ?></div>
            <div><b>Email:</b> <?php echo e($seller->user?->email ?? '-'); ?></div>
            <div><b>Store:</b> <?php echo e($seller->store_name ?? '-'); ?></div>
            <div><b>Status:</b> <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $seller->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seller->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?></div>
            <div><b>Applied At:</b> <?php echo e($seller->created_at?->format('Y-m-d H:i')); ?></div>
            <div><b>Total Products:</b> <?php echo e($seller->products_count ?? $seller->products->count()); ?></div>
            <div><b>Total Orders:</b> <?php echo e($seller->orders_count ?? $seller->orders->count()); ?></div>
            <div><b>Total Sales:</b> $<?php echo e(number_format($seller->total_sales ?? 0, 2)); ?></div>
        </div>

        <div class="mt-6">
            <?php echo $__env->make('admin.sellers.partials.actions', ['seller' => $seller, 'compact' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

    <?php echo $__env->make('admin.sellers.partials.business_document', ['seller' => $seller], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('admin.sellers.partials.products', [
        'seller'   => $seller,
        'products' => $products ?? $seller->products ?? collect()
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->make('admin.sellers.partials.orders', [
        'seller' => $seller,
        'orders' => $orders ?? $seller->orders ?? collect()
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/sellers/show.blade.php ENDPATH**/ ?>