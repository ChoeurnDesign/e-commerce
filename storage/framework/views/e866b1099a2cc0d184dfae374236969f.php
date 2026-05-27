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

<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group overflow-hidden border border-gray-100 dark:border-gray-800 relative z-20 flex flex-col h-full">
    
    <div class="relative overflow-hidden bg-gray-300 dark:bg-gray-800 rounded-t-2xl flex-shrink-0">
        <a href="<?php echo e(route('products.show', $product->slug)); ?>">
            <?php
                $imageUrl = $product->image_url;
                $fallbackText = urlencode(substr($product->name, 0, 20));
            ?>
            <img
                src="<?php echo e($imageUrl); ?>"
                alt="<?php echo e($product->name); ?>"
                class="w-full h-36 sm:h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                loading="lazy"
                onerror="
                    if(!this.classList.contains('failed')) {
                        this.src='https://placehold.co/400x400/1e293b/94a3b8?text=<?php echo e($fallbackText); ?>';
                        this.classList.add('failed');
                        this.parentElement.parentElement.classList.add('bg-gray-100', 'dark:bg-gray-800');
                    }
                "
                onload="this.parentElement.parentElement.classList.remove('bg-gray-300', 'dark:bg-gray-800');"
            >
        </a>
        <div class="absolute top-3 left-3 flex gap-2">
            <?php if($product->sale_price && $product->sale_price < $product->price): ?>
                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium shadow-md">Sale</span>
            <?php endif; ?>
            <?php if($product->is_featured): ?>
                <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full font-medium shadow-md">Featured</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="p-3 sm:p-5 flex flex-col flex-grow">
        <div class="flex items-center justify-between mb-1.5 sm:mb-2">
            <div class="text-[10px] sm:text-xs text-indigo-600 dark:text-indigo-400 font-medium bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 sm:py-1 rounded-full inline-block truncate max-w-[60%]">
                <?php echo e($product->category->name ?? 'Uncategorized'); ?>

            </div>
            
            <?php if($product->seller): ?>
                <a href="<?php echo e(route('stores.show', $product->seller->slug)); ?>" 
                   class="text-[10px] font-bold text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition-colors uppercase tracking-tight">
                    <?php echo e(Str::limit($product->seller->store_name, 12)); ?>

                </a>
            <?php endif; ?>
        </div>

        <h3 class="text-sm sm:text-base text-gray-900 dark:text-gray-100 mb-2 sm:mb-3 line-clamp-2 leading-tight font-medium">
            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                <?php echo e($product->name); ?>

            </a>
        </h3>
        
        <div>
            <?php if($product->sale_price && $product->compare_price && $product->sale_price < $product->compare_price): ?>
                <span class="text-sm sm:text-lg font-bold text-green-600 dark:text-green-400">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($product->sale_price)); ?>

                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($product->compare_price)); ?>

                </span>
            <?php elseif($product->sale_price && $product->sale_price < $product->price): ?>
                <span class="text-sm sm:text-lg font-bold text-green-600 dark:text-green-400">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($product->sale_price)); ?>

                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($product->price)); ?>

                </span>
            <?php else: ?>
                <span class="text-sm sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($product->price)); ?>

                </span>
            <?php endif; ?>
        </div>

        
        <div class="flex items-center mb-2">
            <div class="flex <?php echo e($product->average_rating > 0 ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'); ?>">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => ''.e(($product->average_rating > 0 && $i <= round($product->average_rating)) ? 'star-filled' : 'star-empty').'','class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => ''.e(($product->average_rating > 0 && $i <= round($product->average_rating)) ? 'star-filled' : 'star-empty').'','class' => 'w-4 h-4']); ?>
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
                <?php endfor; ?>
            </div>
            <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">
                <?php echo e($product->reviews_count > 0
                    ? "({$product->reviews_count} " . \Illuminate\Support\Str::plural('review', $product->reviews_count) . ")"
                    : '(No reviews yet)'); ?>

            </span>
        </div>

        
        <div class="flex justify-between items-center mt-auto pt-4">
            <div class="flex items-center">
                <?php if(auth()->guard()->check()): ?>
                    <button onclick="event.stopPropagation(); addToCart(<?php echo e($product->id); ?>, this)"
                        type="button"
                        class="add-to-cart-btn flex items-center gap-1 sm:gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-2.5 sm:px-4 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm transition-all shadow-md">
                        <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'cart','class' => 'w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'cart','class' => 'w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0']); ?>
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
                        <span class="hidden xs:inline sm:inline">Add</span>
                    </button>
                <?php else: ?>
                    <button onclick="event.stopPropagation(); redirectToLogin()"
                        type="button"
                        class="add-to-cart-btn flex items-center gap-1 sm:gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-2.5 sm:px-4 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm transition-all shadow-md">
                        <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'cart','class' => 'w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'cart','class' => 'w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0']); ?>
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
                        <span class="hidden xs:inline sm:inline">Add</span>
                    </button>
                <?php endif; ?>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-3">
                <?php if(auth()->guard()->check()): ?>
                    <?php $inWishlist = auth()->user()->hasInWishlist($product->id); ?>
                    <button onclick="event.stopPropagation(); toggleWishlist(<?php echo e($product->id); ?>, this)"
                        type="button"
                        class="wishlist-btn border border-gray-300 dark:border-gray-700 shadow-sm transition-all rounded-full flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10
                        <?php echo e($inWishlist ? 'text-red-500 border-red-400' : 'text-gray-400 dark:text-gray-500 hover:border-red-400 hover:text-red-400'); ?>">
                        <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => ''.e($inWishlist ? 'wishlist-filled' : 'wishlist').'','class' => 'w-4 h-4 sm:w-5 sm:h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => ''.e($inWishlist ? 'wishlist-filled' : 'wishlist').'','class' => 'w-4 h-4 sm:w-5 sm:h-5']); ?>
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
                    </button>
                <?php else: ?>
                    <button onclick="event.stopPropagation(); redirectToLogin()"
                        type="button"
                        class="border border-gray-300 dark:border-gray-700 text-gray-400 dark:text-gray-500 rounded-full shadow-sm transition-all flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 hover:border-indigo-400">
                        <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'wishlist','class' => 'w-4 h-4 sm:w-5 sm:h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'wishlist','class' => 'w-4 h-4 sm:w-5 sm:h-5']); ?>
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
                    </button>
                <?php endif; ?>

                <button type="button"
                    onclick="event.stopPropagation(); showProductInfo(<?php echo e($product->id); ?>)"
                    class="border border-gray-300 dark:border-gray-700 text-gray-400 hover:text-indigo-600 hover:border-indigo-500 flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full transition shadow-sm">
                    <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'info','class' => 'w-4 h-4 sm:w-5 sm:h-5']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'info','class' => 'w-4 h-4 sm:w-5 sm:h-5']); ?>
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
                </button>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\Year_IV\Semester II\pp\ShopExpress\resources\views/components/products/product-card.blade.php ENDPATH**/ ?>