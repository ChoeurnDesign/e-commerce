<!-- resources/views/seller/products/index.blade.php -->

<?php $__env->startSection('title', 'Products Management'); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('products.partials.index', [
        'products' => $products,
        'imagePartial' => 'products.partials.image-seller', 
        'createRoute' => route('seller.products.create'),
        'importRoute' => route('seller.products.import.form'),
        'showRouteName' => 'seller.products.show',
        'editRouteName' => 'seller.products.edit',
        'deleteRouteName' => 'seller.products.destroy',
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.seller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/seller/products/index.blade.php ENDPATH**/ ?>