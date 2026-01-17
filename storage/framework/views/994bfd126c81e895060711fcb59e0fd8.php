<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['product']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['product']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>


<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group overflow-hidden border border-gray-100 dark:border-gray-800 relative z-20">
    <div class="relative overflow-hidden bg-gray-300 dark:bg-gray-800 rounded-t-2xl">
        <a href="<?php echo e(route('products.show', $product->slug)); ?>">
            <img
                src="<?php echo e($product->image ? (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset($product->image)) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name)); ?>"
                alt="<?php echo e($product->name); ?>"
                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=No+Image';">
        </a>
        <div class="absolute top-3 left-3 flex gap-2">
            <?php if($product->sale_price && $product->sale_price < $product->price): ?>
                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-medium shadow-md">Sale</span>
            <?php endif; ?>
            <?php if($product->is_featured): ?>
                <span class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-full font-medium shadow-md">Featured</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="p-5 flex flex-col h-full">
        <div class="text-xs text-indigo-600 dark:text-purple-300 font-medium mb-2 bg-gray-300 dark:bg-gray-800 px-3 py-1 rounded-full inline-block">
            <?php echo e($product->category->name ?? 'Uncategorized'); ?>

        </div>
         
        <div class="flex items-center gap-2 mb-3">
            <?php if($product->seller && $product->seller->store_name): ?>
                <a href="<?php echo e(route('stores.show', $product->seller->slug)); ?>" class="flex items-center gap-2 group">
                    <img src="<?php echo e($product->seller->store_logo_url ?? asset('images/default-store.png')); ?>"
                        alt="<?php echo e($product->seller->store_name); ?>"
                        class="w-8 h-8 rounded-full object-cover border border-gray-300 dark:border-gray-700 shadow-sm"
                        onerror="this.onerror=null;this.src='<?php echo e(asset('images/default-store.png')); ?>';">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-purple-300 truncate">
                        <?php echo e($product->seller->store_name); ?>

                    </span>
                </a>
            <?php else: ?>
                <span class="flex items-center gap-2">
                    <img src="<?php echo e(asset('images/default-store.png')); ?>"
                        alt="Unknown Store"
                        class="w-8 h-8 rounded-full object-cover border border-gray-300 dark:border-gray-700 shadow-sm">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 truncate">
                        Unknown Store
                    </span>
                </span>
            <?php endif; ?>
        </div>
        <h3 class= "text-gray-900 dark:text-gray-100 mb-3 line-clamp-2 leading-tight">
            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="hover:underline">
                <?php echo e($product->name); ?>

            </a>
        </h3>
        <div>
            <?php if($product->sale_price && $product->compare_price && $product->sale_price < $product->compare_price): ?>
                <span class="text-lg font-bold text-green-600 dark:text-green-400">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($product->sale_price)); ?>

                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($product->compare_price)); ?>

                </span>
            <?php elseif($product->sale_price && $product->sale_price < $product->price): ?>
                <span class="text-lg font-bold text-green-600 dark:text-green-400">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($product->sale_price)); ?>

                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($product->price)); ?>

                </span>
            <?php else: ?>
                <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($product->price)); ?>

                </span>
            <?php endif; ?>
            </div>
        <div class="flex items-center mb-2">
            <div class="flex text-yellow-400">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php if($product->average_rating && $i <= round($product->average_rating)): ?>
                        <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'star-empty','class' => 'w-4 h-4 inline-block']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'star-empty','class' => 'w-4 h-4 inline-block']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'star-filled','class' => 'w-4 h-4 inline-block']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'star-filled','class' => 'w-4 h-4 inline-block']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">
                <?php echo e($product->reviews_count > 0
                    ? "({$product->reviews_count} " . \Illuminate\Support\Str::plural('review', $product->reviews_count) . ")"
                    : '(No reviews yet)'); ?>

            </span>
        </div>

        <div class="flex gap-4 mt-4 items-center">
            <?php if(auth()->guard()->check()): ?>
                
                <button onclick="event.stopPropagation(); addToCart(<?php echo e($product->id); ?>, this)"
                    type="button"
                    class="add-to-cart-btn flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-full text-sm transition-all shadow-md"
                    style="font-size: 1rem; min-width:unset;"
                    data-product-id="<?php echo e($product->id); ?>">
                    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'cart']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'cart']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
                    Add To Cart
                </button>

                
                <button onclick="event.stopPropagation(); toggleWishlist(<?php echo e($product->id); ?>, this)"
                    type="button"
                    class="wishlist-btn border-2 border-gray-400 dark:border-gray-700 shadow transition-all p-0 rounded-full flex items-center justify-center w-10 h-10 <?php echo e(auth()->user()->hasInWishlist($product->id) ? 'text-red-500' : 'text-gray-400 dark:text-gray-500 hover:border-red-400 dark:hover:border-red-400'); ?>"
                    data-product-id="<?php echo e($product->id); ?>"
                    aria-label="Add to favorites">
                    <?php if(auth()->user()->hasInWishlist($product->id)): ?>
                        <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'wishlist']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'wishlist']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
                    <?php else: ?>
                        <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'wishlist-filled']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'wishlist-filled']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
                    <?php endif; ?>
                </button>
            <?php else: ?>
                
                <button onclick="event.stopPropagation(); redirectToLogin()"
                    type="button"
                    class="add-to-cart-btn flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-full text-sm transition-all shadow-md"
                    style="font-size: 1rem; min-width:unset;">
                    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'cart']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'cart']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
                    Add To Cart
                </button>

                
                <button onclick="event.stopPropagation(); redirectToLogin()"
                        type="button"
                        class="border-2 border-gray-400 dark:border-gray-700 text-gray-400 dark:text-gray-500 p-0 rounded-full shadow transition-all flex items-center justify-center w-10 h-10 hover:border-indigo-400 dark:hover:border-indigo-400"
                        aria-label="Add to favorites">
                    <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'wishlist-filled']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'wishlist-filled']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
                </button>
            <?php endif; ?>

            
            <button type="button"
                    onclick="event.stopPropagation(); showProductInfo(<?php echo e($product->id); ?>)"
                    class="border-2 border-gray-400 dark:border-gray-700 text-gray-400 dark:text-gray-500  hover:border-indigo-600 dark:hover:border-purple-400 flex items-center justify-center w-10 h-10 rounded-full transition"
                    title="More Info">
                <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'info']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'info']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
            </button>
        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/products/product-card.blade.php ENDPATH**/ ?>