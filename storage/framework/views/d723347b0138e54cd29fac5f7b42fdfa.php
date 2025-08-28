<div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 flex flex-col md:flex-row gap-6 border border-gray-100 dark:border-[#23263a]">
    <div class="flex-shrink-0 flex justify-center items-center">
        <img
            class="h-50 w-50 max-w-full rounded-xl object-cover border border-gray-100 dark:border-[#23263a] shadow-lg"
            src="<?php echo e($product->image ? asset($product->image) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name)); ?>"
            alt="<?php echo e($product->name); ?>"
        >
    </div>
    <div class="flex-1 space-y-3">
        <h3 class="text-xl text-gray-900 dark:text-gray-100"><?php echo e($product->name); ?></h3>
        <div class="text-sm text-gray-500 dark:text-gray-400">SKU: <?php echo e($product->sku); ?></div>
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-200">Category:</span>
            <span class="text-gray-900 dark:text-gray-100"><?php echo e($product->category->name ?? 'No Category'); ?></span>
        </div>
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-200">Price:</span>
            <span class="text-gray-900 dark:text-gray-100">$<?php echo e(number_format($product->price, 2)); ?></span>
            <?php if($product->sale_price): ?>
                <span class="ml-3 font-medium text-green-600 dark:text-green-400">Sale: $<?php echo e(number_format($product->sale_price, 2)); ?></span>
            <?php endif; ?>
        </div>
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-200">Stock:</span>
            <span class="text-gray-900 dark:text-gray-100"><?php echo e($product->stock_quantity); ?></span>
        </div>
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-200">Status:</span>
            <span class="inline-flex px-2 py-1 text-xs rounded-full <?php echo e($product->is_active ? 'bg-green-100 dark:bg-green-950 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-950 text-red-800 dark:text-red-300'); ?>">
                <?php echo e($product->is_active ? 'Active' : 'Inactive'); ?>

            </span>
        </div>
        <div>
            <span class="font-medium text-gray-700 dark:text-gray-200">Description:</span>
            <span class="text-gray-800 dark:text-gray-200 ml-1">
                <?php echo nl2br(e($product->description)); ?>

            </span>
        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/products/partials/_details.blade.php ENDPATH**/ ?>