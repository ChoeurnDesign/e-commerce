<div class="flex flex-col sm:flex-row items-center gap-4 px-6 py-4" data-product-id="<?php echo e($item['id']); ?>">
    <a href="<?php echo e(route('products.show', $item['slug'])); ?>" class="flex-shrink-0">
        <img src="<?php echo e(asset('img/products/' . $item['image'])); ?>" alt="<?php echo e($item['name']); ?>" class="w-16 h-16 object-cover rounded-lg border border-gray-200 dark:border-gray-700" />
    </a>
    <div class="flex-1 w-full min-w-0">
        <div class="flex items-center justify-between">
            <a href="<?php echo e(route('products.show', $item['slug'])); ?>"
                class="font-medium text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-purple-400 truncate block"><?php echo e($item['name']); ?></a>
            <form action="<?php echo e(route('cart.remove', $item['id'])); ?>" method="POST" class="inline ml-2">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="submit"
                    class="text-gray-400 hover:text-red-500 dark:text-gray-500 dark:hover:text-red-400 p-2.5 rounded transition"
                    title="Remove" aria-label="Remove" onclick="return confirm('Remove this item?')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
        <div class="flex items-center gap-2 mt-1">
            <?php if(isset($item['sale_price']) && $item['sale_price']): ?>
                <span class="text-sm font-semibold text-green-600 dark:text-green-400">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($item['price'])); ?>

                </span>
                <span class="text-xs text-gray-400 dark:text-gray-500 line-through">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($item['original_price'])); ?>

                </span>
            <?php else: ?>
                <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    <?php echo e(\App\Helpers\CurrencyHelper::format($item['price'])); ?>

                </span>
            <?php endif; ?>
            <?php if($item['stock_quantity'] <= 5): ?>
                <span class="text-xs text-orange-500 dark:text-orange-400 ml-2">Only <?php echo e($item['stock_quantity']); ?> left</span>
            <?php endif; ?>
        </div>
    </div>
    <div class="flex flex-col items-center gap-2 min-w-[6rem]">
        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-md overflow-hidden bg-white dark:bg-gray-700">
            <button type="button"
                class="quantity-btn px-2 py-1 text-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600 active:bg-gray-300 dark:active:bg-gray-600"
                data-action="decrease" data-product-id="<?php echo e($item['id']); ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
            </button>
            <input type="number" name="quantities[<?php echo e($item['id']); ?>]" value="<?php echo e($item['quantity']); ?>" min="1" max="<?php echo e($item['stock_quantity']); ?>"
                class="quantity-input w-16 text-center border-0 focus:ring-0 focus:outline-none bg-transparent text-gray-900 dark:text-white font-semibold text-sm appearance-none"
                data-product-id="<?php echo e($item['id']); ?>" data-price="<?php echo e($item['price']); ?>" data-original-quantity="<?php echo e($item['quantity']); ?>">
            <button type="button"
                class="quantity-btn px-2 py-1 text-gray-700 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600 active:bg-gray-300 dark:active:bg-gray-600"
                data-action="increase" data-product-id="<?php echo e($item['id']); ?>" data-max="<?php echo e($item['stock_quantity']); ?>">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </button>
        </div>
        <div class="text-xs mt-1 font-semibold text-gray-700 dark:text-gray-300 item-subtotal" data-product-id="<?php echo e($item['id']); ?>">
            <?php echo e(\App\Helpers\CurrencyHelper::format($item['subtotal'])); ?>

        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/cart/partials/item.blade.php ENDPATH**/ ?>