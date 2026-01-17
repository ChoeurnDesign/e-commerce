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
    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
                <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-300">
                    <li><a href="<?php echo e(route('home')); ?>" class="hover:text-indigo-600 dark:hover:text-indigo-300">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="<?php echo e(route('categories.index')); ?>" class="hover:text-indigo-600 dark:hover:text-indigo-300">Categories</a></li>
                    <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><span class="mx-2">/</span></li>
                        <?php if($loop->last): ?>
                            <li class="text-gray-900 dark:text-gray-100 font-medium"><?php echo e($crumb->name); ?></li>
                        <?php else: ?>
                            <li><a href="<?php echo e(route('category.show', $crumb->slug)); ?>" class="hover:text-indigo-600 dark:hover:text-indigo-300"><?php echo e($crumb->name); ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ol>
            </nav>

            <?php
                $imageSrc = $category->image_url ?? asset('/img/default-category.png');
                $productsCount = $products->total() ?? (is_countable($products) ? count($products) : 0);
                $subCount = $subcategories->count() ?? 0;
                $altText = $category->image_alt ?? $category->name;
            ?>

            <!-- Subtle header -->
            <div class="rounded-xl p-6 mb-6 bg-gray-300 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <img src="<?php echo e($imageSrc); ?>" alt="<?php echo e($altText); ?>" class="w-36 h-36 md:w-40 md:h-40 object-cover rounded-full border border-gray-100 dark:border-gray-700 shadow-sm" loading="lazy" onerror="this.onerror=null;this.src='<?php echo e(asset('/img/default-category.png')); ?>'">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 dark:text-gray-100 truncate"><?php echo e($category->name); ?></h1>
                        <?php if(!empty($category->description)): ?>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 max-w-3xl"><?php echo e($category->description); ?></p>
                        <?php endif; ?>

                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-100">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-300" viewBox="0 0 20 20" fill="currentColor"><path d="M4 3a1 1 0 00-1 1v11a1 1 0 001 1h12a1 1 0 001-1V7.414A2 2 0 0016.586 6L13 2.414A2 2 0 0111.586 2H4z"/></svg>
                                <?php echo e($productsCount); ?> <?php echo e(\Illuminate\Support\Str::plural('product', $productsCount)); ?>

                            </span>

                            <?php if($subCount > 0): ?>
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-50 dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"/></svg>
                                    <?php echo e($subCount); ?> <?php echo e(\Illuminate\Support\Str::plural('subcategory', $subCount)); ?>

                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="mb-8 max-w-full mx-auto">
                <form method="GET" action="<?php echo e(route('category.show', $category->slug)); ?>" class="flex flex-wrap gap-4 items-center justify-center">
                    <?php if(request('subcategory')): ?> <input type="hidden" name="subcategory" value="<?php echo e(request('subcategory')); ?>"> <?php endif; ?>

                    <div class="relative flex-1 min-w-80 max-w-full">
                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['type' => 'text','name' => 'search','value' => request('search'),'placeholder' => 'Search products in '.e($category->name).'...','autocomplete' => 'off','class' => 'w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'text','name' => 'search','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('search')),'placeholder' => 'Search products in '.e($category->name).'...','autocomplete' => 'off','class' => 'w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                    </div>

                    <?php if(isset($allCategories)): ?>
                        <select name="category" class=" px-8 py-2 border border-gray-300 dark:border-gray-700 rounded-full bg-white dark:bg-gray-900 text-sm">
                            <option value="">All Categories</option>
                            <?php $__currentLoopData = $allCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cat->slug); ?>" <?php echo e(request('category') == $cat->slug ? 'selected' : ''); ?>><?php echo e($cat->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    <?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['type' => 'number','name' => 'min_price','value' => request('min_price'),'placeholder' => 'Min $','class' => 'w-20 px-3 py-2 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-sm rounded-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'min_price','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('min_price')),'placeholder' => 'Min $','class' => 'w-20 px-3 py-2 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-sm rounded-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['type' => 'number','name' => 'max_price','value' => request('max_price'),'placeholder' => 'Max $','class' => 'w-20 px-3 py-2 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-sm rounded-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','name' => 'max_price','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('max_price')),'placeholder' => 'Max $','class' => 'w-20 px-3 py-2 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-sm rounded-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>

                    <select name="sort" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-full bg-white dark:bg-gray-900 text-sm">
                        <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Latest</option>
                        <option value="featured" <?php echo e(request('sort') == 'featured' ? 'selected' : ''); ?>>Featured</option>
                        <option value="name" <?php echo e(request('sort') == 'name' ? 'selected' : ''); ?>>Name A-Z</option>
                        <option value="price_low" <?php echo e(request('sort') == 'price_low' ? 'selected' : ''); ?>>Price: Low to High</option>
                        <option value="price_high" <?php echo e(request('sort') == 'price_high' ? 'selected' : ''); ?>>Price: High to Low</option>
                    </select>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full text-sm">Apply</button>
                        <a href="<?php echo e(route('category.show', $category->slug)); ?>" class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-700 text-sm">Clear</a>
                    </div>
                </form>
            </div>

            <!-- Subcategories -->
            <?php if($subcategories->count() > 0): ?>
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Subcategories</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                        <?php $__currentLoopData = $subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('category.show', $category->slug)); ?>?subcategory=<?php echo e($subcategory->slug); ?>" class="group bg-white dark:bg-gray-900 border rounded-lg p-4 text-center">
                                <img 
                                    src="<?php echo e($subcategory->image ?? \App\Helpers\PlaceholderAvatar::svgDataUri($subcategory->name)); ?>" 
                                    alt="<?php echo e($subcategory->name); ?>" 
                                    class="w-12 h-12 object-cover rounded-full mx-auto mb-3 bg-gray-300 dark:bg-gray-800">
                                <h4 class="font-medium text-gray-900 dark:text-gray-100 text-sm"><?php echo e($subcategory->name); ?></h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo e($subcategory->total_products_count); ?> items</p>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Products Grid -->
            <div>
                <div class="flex justify-between items-center mb-6">
                    <div class="text-gray-600 dark:text-gray-300">
                        Showing <?php echo e($products->firstItem() ?? 0); ?> - <?php echo e($products->lastItem() ?? 0); ?> of <?php echo e($products->total()); ?> results
                    </div>
                </div>

                <?php if($products->count() > 0): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
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
                    <div class="text-center py-16">
                        <div class="text-gray-400 dark:text-gray-500 text-6xl mb-6">📦</div>
                        <h3 class="text-2xl font-semibold text-gray-600 dark:text-gray-300 mb-4">No Products Found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8">Try adjusting your filters or search terms.</p>
                    </div>
                <?php endif; ?>
            </div>
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
<?php endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/categories/show.blade.php ENDPATH**/ ?>