<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label' => '',
    'value' => '—',
    'color' => 'indigo',   // allowed: indigo, green, yellow, red, blue, gray
    'icon'  => null,       // optional raw SVG or HTML
    'size'  => 'lg',       // lg | sm
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
    'label' => '',
    'value' => '—',
    'color' => 'indigo',   // allowed: indigo, green, yellow, red, blue, gray
    'icon'  => null,       // optional raw SVG or HTML
    'size'  => 'lg',       // lg | sm
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    // Whitelist color stems to prevent invalid class injection
    $palette = [
        'indigo' => 'text-indigo-600 dark:text-indigo-400',
        'green'  => 'text-green-600 dark:text-green-400',
        'yellow' => 'text-yellow-600 dark:text-yellow-300',
        'red'    => 'text-red-600 dark:text-red-400',
        'blue'   => 'text-blue-600 dark:text-blue-400',
        'gray'   => 'text-gray-700 dark:text-gray-300',
    ];
    $colorClass = $palette[$color] ?? $palette['indigo'];

    $valueSize = $size === 'sm' ? 'text-2xl' : 'text-3xl';
    $labelSize = $size === 'sm' ? 'text-xs' : 'text-sm';
?>

<div <?php echo e($attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center w-full'])); ?>>
    <div class="flex items-center gap-3">
        <?php if($icon): ?>
            <span class="p-2 rounded-md bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300">
                <?php echo $icon; ?>

            </span>
        <?php endif; ?>
        <div class="flex flex-col items-center">
            <div class="font-bold leading-none mb-2 <?php echo e($valueSize); ?> <?php echo e($colorClass); ?>">
                <?php echo e($value); ?>

            </div>
            <div class="font-medium <?php echo e($labelSize); ?> text-gray-700 dark:text-gray-200 tracking-wide uppercase">
                <?php echo e($label); ?>

            </div>
        </div>
    </div>
</div><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/seller/stat-card.blade.php ENDPATH**/ ?>