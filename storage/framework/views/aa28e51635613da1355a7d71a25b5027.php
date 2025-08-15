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
    <?php $__env->startSection('title', 'My Wishlist - ShopExpress'); ?>

    <div class="container mx-auto px-4 py-8 bg-gray-300 dark:bg-gray-900"> 
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">My Wishlist</h1> 
                <p class="text-gray-600 dark:text-gray-400"><?php echo e($wishlistItems->total()); ?> <?php echo e(Str::plural('item', $wishlistItems->total())); ?> in your wishlist</p> 
            </div>

            <?php if($wishlistItems->count() > 0): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php $__currentLoopData = $wishlistItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300"> 
                            <div class="relative">
                                <img src="<?php echo e($product->image ? asset('img/products/' . $product->image) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name)); ?>"

                                    alt="<?php echo e($product->name); ?>" class="w-full h-48 object-cover">

                                <button
                                    onclick="toggleWishlist(<?php echo e($product->id); ?>, this)"
                                    class="absolute top-3 right-3 bg-white/90 hover:bg-white dark:bg-gray-700/90 dark:hover:bg-gray-700 text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-500 p-3 rounded-full shadow-lg transition duration-200" 
                                    data-product-id="<?php echo e($product->id); ?>"
                                >
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </button>

                                <?php if($product->category): ?>
                                    <span class="absolute top-2 left-2 bg-indigo-600 text-white px-2 py-1 rounded text-xs">
                                        <?php echo e($product->category->name); ?>

                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2 text-gray-900 dark:text-gray-100"> 
                                    <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="hover:text-indigo-600 dark:hover:text-purple-400"> 
                                        <?php echo e($product->name); ?>

                                    </a>
                                </h3>

                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2"> 
                                    <?php echo e($product->short_description); ?>

                                </p>

                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400"> 
                                        $<?php echo e(number_format($product->price, 2)); ?>

                                    </span>

                                    <?php if($product->compare_price && $product->compare_price > $product->price): ?>
                                        <span class="text-sm text-gray-500 line-through dark:text-gray-400"> 
                                            $<?php echo e(number_format($product->compare_price, 2)); ?>

                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="flex items-center mb-3 min-h-[24px]">
                                    <?php if($product->reviews_count > 0): ?>
                                        <div class="flex text-yellow-400">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <?php if($i <= $product->average_rating): ?>
                                                    <span>★</span>
                                                <?php else: ?>
                                                    <span class="text-gray-300 dark:text-gray-600">☆</span> 
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="text-sm text-gray-600 dark:text-gray-400 ml-2"> 
                                            (<?php echo e($product->reviews_count); ?> <?php echo e(Str::plural('review', $product->reviews_count)); ?>)
                                        </span>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-400 italic dark:text-gray-500">No Review</span> 
                                    <?php endif; ?>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="<?php echo e(route('products.show', $product->slug)); ?>"
                                       class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-full hover:bg-indigo-700 transition duration-200 text-center text-sm font-medium">
                                        View Details
                                    </a>

                                    <button
                                        onclick="addToCart(<?php echo e($product->id); ?>, this)"
                                        class="bg-green-600 text-white py-2 px-4 rounded-full hover:bg-green-700 transition duration-200 text-sm font-medium add-to-cart-btn"
                                        data-product-id="<?php echo e($product->id); ?>">
                                        <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.45A1 1 0 007.5 17h9.02a1 1 0 00.86-.5L21 13M7 13V6a1 1 0 01.883-.993L8 5h9a1 1 0 01.993.883L18 6v7"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-8">
                    <?php echo e($wishlistItems->links()); ?>

                </div>

            <?php else: ?>
                <div class="text-center py-16">
                    <div class="text-6xl mb-4 text-gray-400 dark:text-gray-500">💔</div> 
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Your wishlist is empty</h2> 
                    <p class="text-gray-600 dark:text-gray-400 mb-8">Start adding products you love to your wishlist!</p> 
                    <a href="<?php echo e(route('products.index')); ?>"
                       class="bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-200 font-medium">
                        Explore Products
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
<?php endif; ?>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/wishlist/index.blade.php ENDPATH**/ ?>