<?php $__env->startSection('title', 'Add Product'); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen">
    <div class="space-y-6 min-h-screen">
        <div class="bg-white dark:bg-[#23263a] rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-600">
            <div class="flex items-center mb-8">
                <div class="bg-blue-100 dark:bg-blue-900 rounded-full p-2 mr-3">
                    <svg class="w-7 h-7 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M6 12h12" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Add Product</h1>
            </div>
            <?php echo $__env->make('products.partials._form', [
                'formAction' => route('admin.products.store'),
                'formMethod' => 'POST',
                'categories' => $categories,
                'product' => null,
                'submitText' => 'Create Product',
                'cancelUrl' => route('admin.products.index'),
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/products/create.blade.php ENDPATH**/ ?>