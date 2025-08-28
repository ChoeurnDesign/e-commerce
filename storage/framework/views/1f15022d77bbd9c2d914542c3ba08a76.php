<?php $__env->startSection('title', 'Import Products'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('products.partials.import_form', [
        'title' => 'Import Products',
        'formAction' => route('seller.products.import'),
        'backRoute' => route('seller.products.index'),
        'buttonText' => 'Import Products'
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.seller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/seller/products/import.blade.php ENDPATH**/ ?>