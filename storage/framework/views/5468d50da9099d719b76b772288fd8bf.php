<!-- resources/views/admin/products/index.blade.php -->

<?php $__env->startSection('title', 'Products Management'); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('products.partials.index', [
        'products' => $products,
        'imagePartial' => 'products.partials.image-admin',
        'createRoute' => route('admin.products.create'),
        'importRoute' => route('admin.products.import.form'),
        'showRouteName' => 'admin.products.show',
        'editRouteName' => 'admin.products.edit',
        'deleteRouteName' => 'admin.products.destroy',
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/products/index.blade.php ENDPATH**/ ?>