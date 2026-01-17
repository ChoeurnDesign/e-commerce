<?php $__env->startSection('content'); ?>
<div class="min-h-screen">
    <?php echo $__env->make('products.partials._form', [
        'title' => 'Create Product',
        'formAction' => route('seller.products.store'),
        'formMethod' => 'POST',
        'categories' => $categories,
        'product' => null,
        'submitText' => 'Create Product',
        'cancelUrl' => route('seller.products.index'),
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.seller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/seller/products/create.blade.php ENDPATH**/ ?>