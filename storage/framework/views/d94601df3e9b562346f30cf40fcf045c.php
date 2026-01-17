<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'seller',
    'logoClass' => 'w-44 h-44',
    'bannerClass' => 'h-64',
    'bannerFontClass' => 'text-4xl',
    'logoOffset' => '-bottom-24',
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
    'seller',
    'logoClass' => 'w-44 h-44',
    'bannerClass' => 'h-64',
    'bannerFontClass' => 'text-4xl',
    'logoOffset' => '-bottom-24',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $rawBanner = $seller->store_banner ?? $seller->banner_image ?? null;

    if ($rawBanner) {
        $path = ltrim($rawBanner, '/');
        $path = preg_replace('#^(public/|storage/)#', '', $path);
        $bannerUrl = asset('storage/' . $path);
    } else {
        $bannerUrl = null;
    }
?>

<div class="relative">
    <!-- Card container background (top area) -->
    <div class="overflow-hidden shadow-2xl bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900">
        <!-- Banner with large rounded inner corners to match new design -->
        <div class="<?php echo e($bannerClass); ?> w-full bg-slate-800/20 flex items-center justify-center px-6 py-4">
            <?php if($bannerUrl): ?>
                <img src="<?php echo e($bannerUrl); ?>"
                     alt="<?php echo e($seller->store_name ?? $seller->name); ?> Banner"
                     class="w-full h-full object-cover "
                     onerror="this.onerror=null;this.src='<?php echo e(asset('images/default-banner.png')); ?>';" />
            <?php else: ?>
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-sky-700 via-emerald-600 to-yellow-500">
                    <span class="text-white dark:text-gray-200 tracking-wide <?php echo e($bannerFontClass); ?> font-medium opacity-90">
                        Store Banner
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <!-- a short spacer so the logo can overlap visually similar to the image -->
        
    </div>

    <!-- Store Logo: overlaps banner, aligned left like the provided design -->
    <div class="absolute left-16 transform  <?php echo e($logoOffset); ?> z-20">
        <img src="<?php echo e($seller->store_logo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($seller->store_name ?? $seller->name)); ?>"
             alt="<?php echo e($seller->store_name ?? $seller->name); ?>"
             class="<?php echo e($logoClass); ?> rounded-full shadow-xl bg-white dark:bg-slate-800 object-cover"
             onerror="this.onerror=null;this.src='<?php echo e(asset('images/default-store.png')); ?>';" />
    </div>
</div><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/store/banner-header.blade.php ENDPATH**/ ?>