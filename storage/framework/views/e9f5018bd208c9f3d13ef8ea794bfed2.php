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
    <div class="py-12 bg-gray-300 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-red-600 dark:text-yellow-400 drop-shadow-lg">
                    <?php echo e(__('Shops On Sale')); ?>

                </h1>
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    <?php echo e(__('Browse all items currently on sale and save big!')); ?>

                </p>
            </div>

            <?php if($saleProducts->count() > 0): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                 <?php $__currentLoopData = $saleProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal7f6ddac8eec65d4d0856184e2105c7fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f6ddac8eec65d4d0856184e2105c7fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.products.product-card','data' => ['product' => $product,'isSale' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('products.product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product),'isSale' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7f6ddac8eec65d4d0856184e2105c7fe)): ?>
<?php $attributes = $__attributesOriginal7f6ddac8eec65d4d0856184e2105c7fe; ?>
<?php unset($__attributesOriginal7f6ddac8eec65d4d0856184e2105c7fe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7f6ddac8eec65d4d0856184e2105c7fe)): ?>
<?php $component = $__componentOriginal7f6ddac8eec65d4d0856184e2105c7fe; ?>
<?php unset($__componentOriginal7f6ddac8eec65d4d0856184e2105c7fe); ?>
<?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
                <div class="text-center py-12" role="status">
                    <div class="text-gray-400 dark:text-gray-600 text-6xl mb-4" aria-hidden="true">🛍️</div>
                    <h3 class="text-xl text-gray-600 dark:text-gray-300 mb-2"><?php echo e(__('No Products On Sale')); ?></h3>
                    <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('Currently, there are no products on sale. Please check back later!')); ?></p>
                </div>
            <?php endif; ?>
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
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/products/shops-on-sale.blade.php ENDPATH**/ ?>