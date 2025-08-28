<?php $__env->startSection('title', 'Seller Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<?php
    $seller        = $seller ?? auth()->user()->seller;
?>

<?php if(!$seller): ?>
    <div class="p-6 bg-red-50 dark:bg-red-900/30 border border-red-300 dark:border-red-700 rounded">
        <h2 class="text-lg font-semibold text-red-700 dark:text-red-300 mb-2">No Seller Account</h2>
        <p class="text-sm text-red-600 dark:text-red-200">
            You have not created a seller profile yet.
            <a href="<?php echo e(route('seller.register.form')); ?>" class="underline text-indigo-600 dark:text-indigo-400">
                Start here
            </a>.
        </p>
    </div>
<?php else: ?>
<div class="max-w-full mx-auto py-6 space-y-10">

    
    <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 flex items-center gap-3">
            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm5.25 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75z" />
            </svg>
            Dashboard
        </h1>

        <?php if($seller->status === 'approved'): ?>
            <a href="<?php echo e(route('seller.products.create')); ?>"
               class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Add Product
            </a>
        <?php endif; ?>
    </div>

    
    <section aria-label="Key metrics" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php if (isset($component)) { $__componentOriginal31a36d53ea03891af2776809f0145c30 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal31a36d53ea03891af2776809f0145c30 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seller.metric-card','data' => ['label' => 'Active Products','value' => $productsCount,'color' => 'indigo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seller.metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Active Products','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($productsCount),'color' => 'indigo']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal31a36d53ea03891af2776809f0145c30)): ?>
<?php $attributes = $__attributesOriginal31a36d53ea03891af2776809f0145c30; ?>
<?php unset($__attributesOriginal31a36d53ea03891af2776809f0145c30); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal31a36d53ea03891af2776809f0145c30)): ?>
<?php $component = $__componentOriginal31a36d53ea03891af2776809f0145c30; ?>
<?php unset($__componentOriginal31a36d53ea03891af2776809f0145c30); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal31a36d53ea03891af2776809f0145c30 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal31a36d53ea03891af2776809f0145c30 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seller.metric-card','data' => ['label' => 'Total Orders','value' => $ordersCount,'color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seller.metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Total Orders','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ordersCount),'color' => 'green']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal31a36d53ea03891af2776809f0145c30)): ?>
<?php $attributes = $__attributesOriginal31a36d53ea03891af2776809f0145c30; ?>
<?php unset($__attributesOriginal31a36d53ea03891af2776809f0145c30); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal31a36d53ea03891af2776809f0145c30)): ?>
<?php $component = $__componentOriginal31a36d53ea03891af2776809f0145c30; ?>
<?php unset($__componentOriginal31a36d53ea03891af2776809f0145c30); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal31a36d53ea03891af2776809f0145c30 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal31a36d53ea03891af2776809f0145c30 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.seller.metric-card','data' => ['label' => 'Average Rating','value' => $averageRating !== null ? number_format($averageRating,2) : '—','color' => 'yellow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seller.metric-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Average Rating','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($averageRating !== null ? number_format($averageRating,2) : '—'),'color' => 'yellow']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal31a36d53ea03891af2776809f0145c30)): ?>
<?php $attributes = $__attributesOriginal31a36d53ea03891af2776809f0145c30; ?>
<?php unset($__attributesOriginal31a36d53ea03891af2776809f0145c30); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal31a36d53ea03891af2776809f0145c30)): ?>
<?php $component = $__componentOriginal31a36d53ea03891af2776809f0145c30; ?>
<?php unset($__componentOriginal31a36d53ea03891af2776809f0145c30); ?>
<?php endif; ?>
    </section>

    
    <section class="bg-white dark:bg-gray-800 rounded-lg shadow p-8">
        <div class="mb-4 flex flex-wrap items-center gap-3">
            <span class="font-semibold text-lg text-gray-900 dark:text-gray-100">Store Status:</span>
            <span class="px-4 py-1 rounded-full text-sm font-semibold capitalize
                <?php if($seller->status === 'approved'): ?>
                    bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200
                <?php elseif($seller->status === 'pending'): ?>
                    bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200
                <?php elseif($seller->status === 'rejected'): ?>
                    bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200
                <?php else: ?>
                    bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200
                <?php endif; ?>">
                <?php echo e($seller->status); ?>

            </span>
        </div>

        <?php if($seller->status === 'approved'): ?>
            <div class="flex items-start gap-4">
                <svg class="w-10 h-10 text-green-500 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div>
                    <p class="text-green-700 dark:text-green-300 text-lg font-semibold">Your seller account is active!</p>
                    <p class="text-gray-600 dark:text-gray-400">Manage your products, track sales, and grow your store.</p>
                </div>
            </div>
        <?php elseif($seller->status === 'pending'): ?>
            <div class="flex items-start gap-4">
                <svg class="w-10 h-10 text-yellow-500 dark:text-yellow-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 8v4m0 4h.01" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="12" cy="12" r="10" />
                </svg>
                <div>
                    <p class="text-yellow-700 dark:text-yellow-200 text-lg font-semibold">Application Pending</p>
                    <p class="text-gray-600 dark:text-gray-400">
                        Awaiting admin review. Ensure all required details are complete.
                        <a href="<?php echo e(route('seller.register.form')); ?>" class="text-indigo-600 dark:text-indigo-400 underline">Review store profile</a>.
                    </p>
                    <?php if ($__env->exists('seller.partials.onboarding-checklist', ['seller' => $seller])) echo $__env->make('seller.partials.onboarding-checklist', ['seller' => $seller], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        <?php elseif($seller->status === 'rejected'): ?>
            <div class="flex items-start gap-4">
                <svg class="w-10 h-10 text-red-500 dark:text-red-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div>
                    <p class="text-red-700 dark:text-red-200 text-lg font-semibold">Application Rejected</p>
                    <p class="text-gray-600 dark:text-gray-400">
                        Update required info & re-apply:
                        <a href="<?php echo e(route('seller.register.form')); ?>" class="text-indigo-600 dark:text-indigo-400 underline">Store profile</a>.
                    </p>
                    <?php if($seller->admin_comment): ?>
                        <p class="mt-2 text-sm text-red-500 dark:text-red-400">Reason: <?php echo e($seller->admin_comment); ?></p>
                    <?php endif; ?>
                    <?php if ($__env->exists('seller.partials.onboarding-checklist', ['seller' => $seller])) echo $__env->make('seller.partials.onboarding-checklist', ['seller' => $seller], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </div>
        <?php else: ?>
            <p class="text-gray-600 dark:text-gray-400">Status information unavailable.</p>
        <?php endif; ?>
    </section>

</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.seller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/seller/dashboard.blade.php ENDPATH**/ ?>