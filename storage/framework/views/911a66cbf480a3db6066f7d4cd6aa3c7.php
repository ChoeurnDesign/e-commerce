<img class="h-10 w-auto rounded-lg object-cover border border-gray-100 dark:border-[#23263a]"
    src="<?php echo e($product->image ? asset('img/products/' . $product->image) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name)); ?>"
    alt="<?php echo e($product->name); ?>">
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/products/partials/image-admin.blade.php ENDPATH**/ ?>