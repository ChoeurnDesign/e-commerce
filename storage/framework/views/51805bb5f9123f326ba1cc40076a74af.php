<!-- Categories Preview Section -->
<div id="categories" class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                <?php echo e(__('Shop by Category')); ?>

            </h2>
            <p class="text-gray-600 dark:text-gray-300 text-lg">
                <?php echo e(__('Explore our wide range of product categories')); ?>

            </p>
        </div>
        <?php if (isset($component)) { $__componentOriginal3f6b257a1210a29e9db4090961a0ec03 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f6b257a1210a29e9db4090961a0ec03 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.categories.category-card','data' => ['parentCategories' => $parentCategories]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('categories.category-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['parentCategories' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($parentCategories)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f6b257a1210a29e9db4090961a0ec03)): ?>
<?php $attributes = $__attributesOriginal3f6b257a1210a29e9db4090961a0ec03; ?>
<?php unset($__attributesOriginal3f6b257a1210a29e9db4090961a0ec03); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f6b257a1210a29e9db4090961a0ec03)): ?>
<?php $component = $__componentOriginal3f6b257a1210a29e9db4090961a0ec03; ?>
<?php unset($__componentOriginal3f6b257a1210a29e9db4090961a0ec03); ?>
<?php endif; ?>
    </div>
    <div class="text-center mt-12">
        <a href="<?php echo e(route('categories.index')); ?>"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-purple-700 dark:hover:bg-purple-600 dark:focus:ring-purple-400">
            <?php echo e(__('View All Categories')); ?>

        </a>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/home/categories-preview.blade.php ENDPATH**/ ?>