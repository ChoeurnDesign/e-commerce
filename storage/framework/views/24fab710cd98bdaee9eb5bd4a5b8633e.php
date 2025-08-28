<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      :class="{ 'dark': dark }"
      x-init="$watch('dark', v => localStorage.setItem('theme', v ? 'dark' : 'light'))">
<head>
    <?php echo $__env->make('layouts.head', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <title><?php echo $__env->yieldContent('title', 'Seller Area'); ?></title>
</head>
<body class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100 font-sans antialiased transition-colors">
    <div class="flex h-screen">
        <?php echo $__env->make('seller.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="flex-1 flex flex-col overflow-hidden">
            <?php echo $__env->make('seller.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <main class="flex-1 overflow-y-auto p-6 bg-gray-300 dark:bg-[#101624] transition-colors text-gray-900 dark:text-gray-100">
                <?php echo $__env->make('seller.partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/seller.blade.php ENDPATH**/ ?>