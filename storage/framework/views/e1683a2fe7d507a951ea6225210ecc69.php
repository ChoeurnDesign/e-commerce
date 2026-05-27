<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50" 
     x-data="{ mobileMenuOpen: false, openSearch: false }">
    <div class="w-full">
        <?php echo $__env->make('layouts.partials.desktop-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    <?php echo $__env->make('layouts.partials.mobile-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</nav><?php /**PATH D:\Year_IV\Semester II\pp\ShopExpress\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>