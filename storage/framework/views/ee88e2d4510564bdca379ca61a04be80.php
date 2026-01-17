<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'action' => route('products.index'),
    'categories' => collect(),
    'showAdvanced' => true,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'action' => route('products.index'),
    'categories' => collect(),
    'showAdvanced' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $search    = request('search', '');
    $category  = request('category', '');
    $minPrice  = request('min_price', '');
    $maxPrice  = request('max_price', '');
    $sort      = request('sort', 'latest');
    $minRating = request('min_rating', '');
    $onSale    = request('on_sale', '');
?>

<form method="GET" action="<?php echo e($action); ?>"
      class="flex flex-wrap gap-4 items-center justify-center">

    
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
               placeholder="Search products..."
               autocomplete="off"
               class="w-full pl-10 pr-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm" />
    </div>

    
    <select name="category"
            class="px-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-700 dark:text-gray-200 min-w-40 text-sm">
        <option value="">All Categories</option>
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($cat->slug); ?>" <?php if($category == $cat->slug): echo 'selected'; endif; ?>><?php echo e($cat->name); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>

    
    <input type="number" name="min_price" value="<?php echo e($minPrice); ?>" placeholder="Min $"
           class="w-20 px-3 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 text-center transition-all text-gray-700 dark:text-gray-200 text-sm placeholder-gray-500 dark:placeholder-gray-400" />

    <input type="number" name="max_price" value="<?php echo e($maxPrice); ?>" placeholder="Max $"
           class="w-20 px-3 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 text-center transition-all text-gray-700 dark:text-gray-200 text-sm placeholder-gray-500 dark:placeholder-gray-400" />

    
    <?php if($showAdvanced): ?>
        <select name="min_rating"
                class="px-6 py-2 pr-8 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 text-sm text-gray-700 dark:text-gray-200">
            <option value="">Min ★</option>
            <?php for($r=5;$r>=1;$r--): ?>
                <option value="<?php echo e($r); ?>" <?php if($minRating == (string)$r): echo 'selected'; endif; ?>><?php echo e($r); ?>★ & Up</option>
            <?php endfor; ?>
        </select>

        <label class="flex items-center gap-1 px-3 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full bg-white dark:bg-gray-900 text-sm text-gray-700 dark:text-gray-200 cursor-pointer">
            <input type="checkbox" name="on_sale" value="1"
                   class="rounded text-indigo-600 focus:ring-indigo-500"
                   <?php if($onSale === '1'): echo 'checked'; endif; ?>>
            <span>On Sale</span>
        </label>
    <?php endif; ?>

    
    <select name="sort"
            class="px-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-700 dark:text-gray-200 min-w-32 text-sm">
        <option value="latest"     <?php if($sort=='latest'): echo 'selected'; endif; ?>>Latest</option>
        <option value="price_low"  <?php if($sort=='price_low'): echo 'selected'; endif; ?>>Price ↑</option>
        <option value="price_high" <?php if($sort=='price_high'): echo 'selected'; endif; ?>>Price ↓</option>
        <option value="name"       <?php if($sort=='name'): echo 'selected'; endif; ?>>A-Z</option>
        <option value="rating"     <?php if($sort=='rating'): echo 'selected'; endif; ?>>Top Rated</option>
    </select>

    
    <button type="submit"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full font-medium transition-all shadow-md hover:shadow-lg text-sm">
        Apply
    </button>
    <a href="<?php echo e($action); ?>"
       class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-5 py-2 border-2 border-gray-400 rounded-full font-medium transition-all text-sm">
        Clear
    </a>
</form><?php /**PATH D:\Year_IV\pp\ShopExpress\resources\views/components/products/search-filters.blade.php ENDPATH**/ ?>