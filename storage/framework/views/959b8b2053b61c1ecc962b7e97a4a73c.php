<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['parentCategories' => null, 'title' => 'Categories']));

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

foreach (array_filter((['parentCategories' => null, 'title' => 'Categories']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    $categories = collect($parentCategories ?? [])->map(function($c){
        // Determine image URL: full URL, storage URL, or SVG placeholder
        $imageUrl = null;
        if (!empty($c->image) && filter_var($c->image, FILTER_VALIDATE_URL)) {
            $imageUrl = $c->image;
        } elseif (!empty($c->image)) {
            try {
                // Use asset() to generate URL for public/storage/categories
                $imageUrl = asset('storage/' . $c->image);
            } catch (\Throwable $e) {
                $imageUrl = null;
            }
        }

        if (!$imageUrl) {
            // Use placeholder helper
            $imageUrl = \App\Helpers\PlaceholderAvatar::svgDataUri($c->name ?? 'Category');
        }

        return (object)[
            'id' => $c->id ?? null,
            'name' => $c->name ?? 'Untitled Category',
            'slug' => $c->slug ?? null,
            'description' => $c->description ?? '',
            'image' => $imageUrl,
            'productsCount' => $c->total_products_count ?? $c->products_count ?? 0,
            'children' => $c->children ?? collect(),
        ];
    });
?>

<section class="my-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-extrabold text-gray-900 dark:text-gray-100"><?php echo e($title); ?></h2>
        <a href="<?php echo e(route('categories.index') ?? route('products.index')); ?>" class="text-sm text-indigo-600 hover:text-indigo-700">See all</a>
    </div>

    <?php if($categories->isNotEmpty()): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 shadow-sm hover:shadow-md transition overflow-hidden">
                    <a <?php if($category->slug): ?> href="<?php echo e(route('category.show', $category->slug)); ?>" <?php endif; ?> class="block group">
                        <div class="w-full h-44 md:h-48 lg:h-52 overflow-hidden bg-gray-100 dark:bg-gray-800">
                            <img src="<?php echo e($category->image); ?>"
                                 alt="<?php echo e($category->name); ?>"
                                 loading="lazy"
                                 onerror="this.onerror=null;this.src='<?php echo e(asset('img/default-category.png')); ?>';"
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500">
                        </div>

                        <div class="p-4 md:p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 truncate"><?php echo e($category->name); ?></h3>
                                    <?php if($category->description): ?>
                                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-300 line-clamp-2"><?php echo e($category->description); ?></p>
                                    <?php endif; ?>
                                </div>

                                <div class="flex-shrink-0 text-right">
                                    <div class="text-sm font-medium text-indigo-600 dark:text-indigo-300">
                                        <?php echo e($category->productsCount); ?> <?php echo e(Str::plural('item', $category->productsCount)); ?>

                                    </div>
                                </div>
                            </div>

                            <?php if($category->children && $category->children->count() > 0): ?>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <?php $__currentLoopData = $category->children->slice(0,4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $sName = $sub->name ?? 'Sub';
                                            $sSlug = $sub->slug ?? null;
                                            $sCount = $sub->total_products_count ?? $sub->products_count ?? 0;
                                        ?>

                                        <?php if($sSlug): ?>
                                            <a href="<?php echo e(route('category.show', $sSlug)); ?>" class="inline-flex items-center gap-2 px-2 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-xs text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                                                <span class="truncate"><?php echo e($sName); ?></span>
                                                <span class="text-xs text-gray-400">· <?php echo e($sCount); ?></span>
                                            </a>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-2 px-2 py-1 rounded-full bg-gray-50 dark:bg-gray-900 text-xs text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                                <span class="truncate"><?php echo e($sName); ?></span>
                                                <span class="text-xs text-gray-400">· <?php echo e($sCount); ?></span>
                                            </span>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php if($category->children->count() > 4): ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-gray-50 dark:bg-gray-900 text-xs text-gray-500 dark:text-gray-400">
                                            +<?php echo e($category->children->count() - 4); ?> more
                                        </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="mt-4 flex items-center justify-between gap-3">
                                <div>
                                    <?php if($category->slug): ?>
                                        <a href="<?php echo e(route('category.show', $category->slug)); ?>" class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-full hover:bg-indigo-700 transition">
                                            View All
                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-200 text-gray-600 text-sm rounded-full">Unavailable</span>
                                    <?php endif; ?>
                                </div>

                                <div class="text-xs text-gray-400">Updated recently</div>
                            </div>
                        </div>
                    </a>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="py-20 text-center">
            <div class="mx-auto w-44 h-44 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-500 text-6xl mb-6">📦</div>
            <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-100 mb-2">No categories yet</h3>
            <p class="text-gray-500 dark:text-gray-300 mb-6">When you add categories they will appear here.</p>
            <a href="<?php echo e(route('products.index')); ?>" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-6 rounded-full transition">Browse products</a>
        </div>
    <?php endif; ?>
</section><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/categories/category-card.blade.php ENDPATH**/ ?>