<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>[x-cloak] { display: none !important; }</style>

    <title><?php echo e($settings['store_name'] ?? config('app.name', 'ShopExpress')); ?></title>
    <meta name="description" content="<?php echo $__env->yieldContent('description', 'Shop the best products online at ' . ($settings['store_name'] ?? 'ShopExpress')); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('keywords', 'shopping, online store, products'); ?>">

    <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', $settings['store_name'] ?? 'ShopExpress'); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('og_description', 'Shop the best products online'); ?>">
    <meta property="og:image" content="<?php echo $__env->yieldContent('og_image', asset($settings['store_logo'] ?? 'images/logo.png')); ?>">
    <meta property="og:url" content="<?php echo $__env->yieldContent('og_url', url()->current()); ?>">
    <meta property="og:type" content="website">

    
    <?php if(!empty($settings['store_logo'])): ?>
        <link rel="icon" type="image/png" href="<?php echo e(asset($settings['store_logo'])); ?>">
    <?php else: ?>
        <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/head.blade.php ENDPATH**/ ?>