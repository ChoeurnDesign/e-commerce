<div id="featured-products" class="py-10 sm:py-16 bg-gray-50 dark:bg-gray-900/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-7 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-3">
                <?php echo e(__('Featured Products')); ?>

            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base max-w-xl mx-auto">
                <?php echo e(__('Check out our handpicked selection of amazing products')); ?>

            </p>
        </div>

        <?php if($featuredProducts->count() > 0): ?>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if (isset($component)) { $__componentOriginal7f6ddac8eec65d4d0856184e2105c7fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f6ddac8eec65d4d0856184e2105c7fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.products.product-card','data' => ['product' => $product,'minimal' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('products.product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product),'minimal' => true]); ?>
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

            <div class="text-center mt-8 sm:mt-12">
                <a href="<?php echo e(route('products.index')); ?>"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                           py-2.5 px-7 sm:py-3 sm:px-8 rounded-full text-sm sm:text-base
                           transition duration-300 shadow-md hover:shadow-lg
                           dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    <?php echo e(__('View All Products')); ?>

                </a>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="text-gray-300 dark:text-gray-600 text-5xl mb-4">🛍️</div>
                <h3 class="text-lg text-gray-500 dark:text-gray-400"><?php echo e(__('No Products Yet')); ?></h3>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\Year_IV\Semester II\pp\ShopExpress\resources\views/components/home/featured-products.blade.php ENDPATH**/ ?>