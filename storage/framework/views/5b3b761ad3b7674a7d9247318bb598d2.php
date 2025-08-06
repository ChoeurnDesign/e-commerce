<!-- Cart -->
<a href="<?php echo e(route('cart.index')); ?>"
    class="relative p-2 mx-2 text-gray-400 dark:text-gray-300 hover:text-indigo-600 rounded-lg hover:bg-gray-300 dark:hover:bg-[#2e1065] transition-colors">
    <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <circle cx="9" cy="21" r="1" />
        <circle cx="20" cy="21" r="1" />
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M1 1h2l4 14a2 2 0 0 0 2 1.5h9a2 2 0 0 0 2-1.5l3-10.5H6" />
    </svg>
    <?php if(auth()->guard()->check()): ?>
    <?php if(isset($cartCount) && $cartCount > 0): ?>
    <span
        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold leading-none"><?php echo e($cartCount); ?></span>
    <?php endif; ?>
    <?php endif; ?>
</a>
<!-- Wishlist -->
<a href="<?php echo e(route('wishlist.index')); ?>"
    class="relative p-2 text-gray-400 dark:text-gray-300 hover:text-indigo-600 rounded-lg hover:bg-gray-300 dark:hover:bg-[#2e1065] transition-colors">
    <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
    <?php if(auth()->guard()->check()): ?>
    <?php if(isset($wishlistCount) && $wishlistCount > 0): ?>
    <span
        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold leading-none"><?php echo e($wishlistCount); ?></span>
    <?php endif; ?>
    <?php endif; ?>
</a>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/partials/nav-cart-wishlist.blade.php ENDPATH**/ ?>