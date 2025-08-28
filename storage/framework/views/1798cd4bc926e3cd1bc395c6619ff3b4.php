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
     <?php $__env->slot('header', null, []); ?> 
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
     <?php $__env->endSlot(); ?>

    <div class="py-8 bg-gray-200 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">All Products</h1>
                <p class="text-gray-600 dark:text-gray-300">
                    Discover our amazing collection of available products
                </p>
            </div>

            <div class="mb-8">
                <?php if (isset($component)) { $__componentOriginalce12ad9f1851453ead205644fda0fd72 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalce12ad9f1851453ead205644fda0fd72 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.products.search-filters','data' => ['categories' => $categories,'showAdvanced' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('products.search-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['categories' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($categories),'show-advanced' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalce12ad9f1851453ead205644fda0fd72)): ?>
<?php $attributes = $__attributesOriginalce12ad9f1851453ead205644fda0fd72; ?>
<?php unset($__attributesOriginalce12ad9f1851453ead205644fda0fd72); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalce12ad9f1851453ead205644fda0fd72)): ?>
<?php $component = $__componentOriginalce12ad9f1851453ead205644fda0fd72; ?>
<?php unset($__componentOriginalce12ad9f1851453ead205644fda0fd72); ?>
<?php endif; ?>
            </div>

            <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                <p class="text-gray-600 dark:text-gray-300 font-medium">
                    <span class="text-green-600 dark:text-green-400 font-semibold">
                        <?php echo e($products->total()); ?>

                    </span>
                    products found
                    <?php if(request('search')): ?>
                        for
                        <span class="italic text-indigo-600 dark:text-indigo-400">
                            "<?php echo e(request('search')); ?>"
                        </span>
                    <?php endif; ?>
                </p>
                <div class="text-sm text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-800 px-4 py-2 rounded-full border border-gray-200 dark:border-gray-700">
                    Page <?php echo e($products->currentPage()); ?> of <?php echo e($products->lastPage()); ?>

                </div>
            </div>

            <?php if($products->count()): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (isset($component)) { $__componentOriginal7f6ddac8eec65d4d0856184e2105c7fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f6ddac8eec65d4d0856184e2105c7fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.products.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('products.product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
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
                <div class="flex justify-center">
                    <?php echo e($products->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-16 bg-white dark:bg-gray-900 rounded-2xl shadow-md border border-gray-300 dark:border-gray-700">
                    <div class="text-6xl mb-4 text-gray-400 dark:text-gray-600">📦</div>
                    <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-4">
                        No Available Products Found
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        Try adjusting your filters or search terms.
                    </p>
                    <a href="<?php echo e(route('products.index')); ?>"
                       class="bg-indigo-600 hover:bg-indigo-700 dark:bg-purple-700 dark:hover:bg-purple-600 text-white px-8 py-3 rounded-full font-medium transition-all shadow-md hover:shadow-lg">
                        View All Products
                    </a>
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
<?php endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/products/index.blade.php ENDPATH**/ ?>