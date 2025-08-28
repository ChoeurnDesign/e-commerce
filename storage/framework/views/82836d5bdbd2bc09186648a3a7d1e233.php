<?php $__env->startSection('title', 'Edit Product'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-full mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Product</h2>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#262c47] text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition duration-200">
            &larr; Back to Products
        </a>
    </div>

    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-100 dark:border-[#23263a]">
        <?php echo $__env->make('products.partials._form', [
            'formAction' => route('admin.products.update', $product),
            'formMethod' => 'PUT',
            'categories' => $categories,
            'product' => $product,
            'submitText' => 'Update Product',
            'cancelUrl' => route('admin.products.index'),
        ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>