<div class="flex justify-between items-center px-6 py-4 border-b border-gray-100 dark:border-gray-700">
    <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">
        Cart (<?php echo e($cartTotals['total_quantity'] ?? 0); ?> items)
    </h2>
    <form action="<?php echo e(route('cart.clear')); ?>" method="POST" class="inline">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button type="submit"
            class="text-xs text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-600 font-medium px-3 py-1 rounded transition"
            onclick="return confirm('Clear your cart?')">
            Clear All
        </button>
    </form>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/cart/partials/header.blade.php ENDPATH**/ ?>