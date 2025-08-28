<img class="h-10 w-10 rounded-lg object-cover"
     src="<?php echo e($product->image ? asset($product->image) : 'https://via.placeholder.com/400x400?text=' . urlencode($product->name)); ?>"
     alt="<?php echo e($product->name); ?>">
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/products/partials/image-seller.blade.php ENDPATH**/ ?>