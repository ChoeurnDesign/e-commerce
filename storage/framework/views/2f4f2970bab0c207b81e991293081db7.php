<form method="GET" action="<?php echo e(route('admin.sellers.index')); ?>" class="flex flex-wrap items-center gap-3 mb-6">
    <input
        type="text"
        name="search"
        value="<?php echo e(request('search')); ?>"
        placeholder="Search seller, email, or store…"
        class="px-4 py-2 rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#23263a] text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400"
    />

    <select
        name="status"
        class="px-8 py-2 rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#23263a] text-gray-800 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-400"
    >
        <option value="">All Statuses</option>
        <option value="pending" <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>>Pending</option>
        <option value="approved" <?php if(request('status') === 'approved'): echo 'selected'; endif; ?>>Approved</option>
        <option value="rejected" <?php if(request('status') === 'rejected'): echo 'selected'; endif; ?>>Rejected</option>
    </select>

    <button
        type="submit"
        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 rounded text-white font-semibold transition"
    >
        Filter
    </button>

    <?php if(request('search') || request('status')): ?>
        <a href="<?php echo e(route('admin.sellers.index')); ?>"
           class="px-5 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 rounded text-gray-700 dark:text-gray-200 font-semibold transition">
            Reset
        </a>
    <?php endif; ?>
</form>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/sellers/partials/filters.blade.php ENDPATH**/ ?>