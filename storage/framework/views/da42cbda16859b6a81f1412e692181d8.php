<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
    <a href="<?php echo e(route('admin.products.create')); ?>" class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 hover:shadow-md transition duration-200 block border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Add Product</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Create a new product</p>
            </div>
        </div>
    </a>
    <a href="<?php echo e(route('admin.categories.create')); ?>" class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 hover:shadow-md transition duration-200 block border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Add Category</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Create a new category</p>
            </div>
        </div>
    </a>
    <a href="<?php echo e(route('admin.orders.index')); ?>" class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 hover:shadow-md transition duration-200 block border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 text-purple-600 dark:text-purple-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Manage Orders</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">View all orders</p>
            </div>
        </div>
    </a>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/dashboard/_quick-actions.blade.php ENDPATH**/ ?>