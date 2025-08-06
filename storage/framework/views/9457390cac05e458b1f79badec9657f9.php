<?php $__env->startSection('title', 'Edit On Sale Product'); ?>
<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-100 dark:border-gray-600 mt-10">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit On Sale Product</h2>
    <form action="<?php echo e(route('admin.onsale.update', ['product' => $product->id])); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Product Name</label>
            <div class="mt-1 block w-full rounded-md bg-gray-100 dark:bg-[#23263a] px-4 py-2 text-gray-900 dark:text-gray-100"><?php echo e($product->name); ?></div>
        </div>
        <!-- Original Price (readonly) -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Original Price ($)</label>
            <input type="number" value="<?php echo e($product->price); ?>" readonly
                class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">On Sale?</label>
            <input type="checkbox" name="on_sale" value="1" <?php echo e(old('on_sale', $product->on_sale) ? 'checked' : ''); ?>>
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Yes</span>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Sale Price ($)</label>
            <input type="number" name="sale_price" value="<?php echo e(old('sale_price', $product->sale_price)); ?>" step="0.01" min="0"
                class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <?php $__errorArgs = ['sale_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-600 dark:text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Compare Price ($)</label>
            <input type="number" name="compare_price" value="<?php echo e(old('compare_price', $product->compare_price)); ?>" step="0.01" min="0"
                class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <?php $__errorArgs = ['compare_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-600 dark:text-red-400 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="pt-4 flex space-x-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                Update Sale Status
            </button>
            <a href="<?php echo e(route('admin.onsale.index')); ?>" class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-400 dark:hover:bg-[#262c47] text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg font-semibold transition duration-200">
                Cancel
            </a>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/onsale/edit.blade.php ENDPATH**/ ?>