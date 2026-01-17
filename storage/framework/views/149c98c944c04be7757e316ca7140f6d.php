<?php
    $search = request('search', '');
    $sort   = request('sort', 'name');
?>

<form method="GET" class="flex flex-wrap gap-4 items-center justify-center mb-8">
    
    <div class="relative flex-1 min-w-70 max-w-full">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 10-14 0 7 7 0 0014 0z"/>
            </svg>
        </span>
        <input type="text"
               name="search"
               value="<?php echo e($search); ?>"
               placeholder="Search stores..."
               autocomplete="off"
               class="w-full pl-10 pr-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm" />
    </div>

    
    <select name="sort"
            class="px-6 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-700 dark:text-gray-200 min-w-32 text-sm">
        <option value="name" <?php if($sort=='name'): echo 'selected'; endif; ?>>A-Z</option>
        <option value="products" <?php if($sort=='products'): echo 'selected'; endif; ?>>Top Stores</option>
        <option value="rating" <?php if($sort=='rating'): echo 'selected'; endif; ?>>Top Rated</option>
        <option value="newest" <?php if($sort=='newest'): echo 'selected'; endif; ?>>Newest</option>
    </select>

    
    <button type="submit"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full font-medium transition-all shadow-md hover:shadow-lg text-sm">
        Apply
    </button>
    <?php if(request()->hasAny(['search', 'sort'])): ?>
        <a href="<?php echo e(route('stores.index')); ?>"
           class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-5 py-2 border-2 border-gray-400 rounded-full font-medium transition-all text-sm">
            Clear
        </a>
    <?php endif; ?>
</form><?php /**PATH D:\Year_IV\pp\ShopExpress\resources\views/components/store/search-filters.blade.php ENDPATH**/ ?>