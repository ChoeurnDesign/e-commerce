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
    <div class="py-8 bg-gray-200 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">All Stores</h1>
                <p class="text-gray-600 dark:text-gray-300">Browse all our featured stores and sellers</p>
            </div>

            
            <?php if (isset($component)) { $__componentOriginal4b8c21220716b8cc42e8baf49501fa1d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b8c21220716b8cc42e8baf49501fa1d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.store.search-filters','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('store.search-filters'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4b8c21220716b8cc42e8baf49501fa1d)): ?>
<?php $attributes = $__attributesOriginal4b8c21220716b8cc42e8baf49501fa1d; ?>
<?php unset($__attributesOriginal4b8c21220716b8cc42e8baf49501fa1d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4b8c21220716b8cc42e8baf49501fa1d)): ?>
<?php $component = $__componentOriginal4b8c21220716b8cc42e8baf49501fa1d; ?>
<?php unset($__componentOriginal4b8c21220716b8cc42e8baf49501fa1d); ?>
<?php endif; ?>

            
            <div class="mb-6 text-gray-600 dark:text-gray-400">
                <span class="font-semibold"><?php echo e(number_format($sellers->total())); ?></span> stores found
                <?php if(request('search')): ?>
                    for "<span class="italic text-sky-600 dark:text-sky-400"><?php echo e(request('search')); ?></span>"
                <?php endif; ?>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php $__empty_1 = true; $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:scale-105 transition-transform duration-200 group relative overflow-hidden pb-6 flex flex-col">
                        
                        <?php if($seller->is_featured ?? false): ?>
                            <span class="absolute top-3 left-3 bg-gradient-to-r from-pink-500 to-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Featured</span>
                        <?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginalc132df06a9593e4f03748b2046b1e9c4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc132df06a9593e4f03748b2046b1e9c4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.store.banner-header','data' => ['seller' => $seller,'logoClass' => 'w-24 h-24','bannerClass' => 'h-28','bannerFontClass' => 'text-xl','logoOffset' => '-bottom-14']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('store.banner-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['seller' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seller),'logoClass' => 'w-24 h-24','bannerClass' => 'h-28','bannerFontClass' => 'text-xl','logoOffset' => '-bottom-14']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc132df06a9593e4f03748b2046b1e9c4)): ?>
<?php $attributes = $__attributesOriginalc132df06a9593e4f03748b2046b1e9c4; ?>
<?php unset($__attributesOriginalc132df06a9593e4f03748b2046b1e9c4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc132df06a9593e4f03748b2046b1e9c4)): ?>
<?php $component = $__componentOriginalc132df06a9593e4f03748b2046b1e9c4; ?>
<?php unset($__componentOriginalc132df06a9593e4f03748b2046b1e9c4); ?>
<?php endif; ?>

                        <div class="px-4 pb-4 pt-6 text-center flex-1 flex flex-col">
                            <h2 class="text-lg truncate mt-10 mb-1 text-gray-900 dark:text-gray-100"><?php echo e($seller->store_name ?? $seller->name); ?></h2>
                            
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate mb-2">@ <?php echo e($seller->slug); ?></p>
                            
                            
                            <?php if($seller->products && $seller->products->count()): ?>
                                <div class="flex justify-center gap-1 mb-3">
                                    <?php $__currentLoopData = $seller->products->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <img src="<?php echo e($product->image_url ?? asset('images/product-placeholder.png')); ?>"
                                             alt="<?php echo e($product->name); ?>"
                                             class="w-8 h-8 rounded object-cover border border-gray-200 dark:border-gray-700">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>

                            <div class="flex justify-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
                                <span>
                                    <i class="fas fa-box"></i>
                                    <?php echo e($seller->products_count ?? $seller->products()->count()); ?> Products
                                </span>
                                <span class="text-sm text-gray-400">
                                    
                                    <?php echo e($seller->followers_count ?? 0); ?> followers
                                </span>
                            </div>

                            <div class="mt-auto flex items-center gap-2 w-full justify-between">
                                
                                <?php
                                    $avg = round($seller->storeReviews()->avg('rating'), 1);
                                    $count = $seller->storeReviews()->count();
                                ?>
                                <div class="flex items-center">
                                    <?php if($count > 0): ?>
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($avg >= $i): ?>
                                                <span class="text-yellow-400 text-sm">&#9733;</span>
                                            <?php elseif($avg > $i - 1): ?>
                                                <span class="text-yellow-400 text-sm">&#9733;</span>
                                            <?php else: ?>
                                                <span class="text-gray-300 dark:text-gray-700 text-sm">&#9733;</span>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                        <span class="ml-1 text-xs text-gray-400 dark:text-gray-500">
                                            (<?php echo e($avg); ?>) / <?php echo e($count); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-400 dark:text-gray-600 text-xs">No ratings</span>
                                    <?php endif; ?>
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="<?php echo e(route('stores.show', $seller)); ?>"
                                       class="bg-sky-600 dark:bg-sky-700 text-white px-4 py-2 rounded-full font-semibold shadow hover:bg-sky-700 dark:hover:bg-sky-800 transition text-sm">
                                        View Store
                                    </a>

                                    
                                    <?php
                                        $isFollowing = isset($followedSellerIds) ? in_array($seller->id, $followedSellerIds) : (auth()->check() ? auth()->user()->isFollowingSeller($seller) : false);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-4 text-center text-gray-500 dark:text-gray-400">No stores found.</div>
                <?php endif; ?>
            </div>
            <div class="mt-10 flex justify-center">
                <?php echo e($sellers->appends(request()->query())->links()); ?>

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
<?php endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/stores/index.blade.php ENDPATH**/ ?>