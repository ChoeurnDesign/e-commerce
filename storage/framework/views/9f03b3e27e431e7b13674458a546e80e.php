<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title',
    'value',
    // allowed: gray | yellow | green | red
    'color' => 'gray',
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
    'title',
    'value',
    // allowed: gray | yellow | green | red
    'color' => 'gray',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    // Text color for the VALUE in light / dark
    $valuePalette = [
        'gray'   => ['light' => 'text-gray-700',   'dark' => 'dark:text-gray-200'],
        'yellow' => ['light' => 'text-yellow-600', 'dark' => 'dark:text-yellow-400'],
        'green'  => ['light' => 'text-green-600',  'dark' => 'dark:text-green-400'],
        'red'    => ['light' => 'text-red-600',    'dark' => 'dark:text-red-400'],
    ];
    $valueColor = ($valuePalette[$color]['light'] ?? 'text-gray-700') . ' ' . ($valuePalette[$color]['dark'] ?? 'dark:text-gray-200');
?>

<div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a] rounded-lg p-5 text-center transition-colors">
    <div class="mb-1 text-xs font-medium tracking-wide uppercase text-gray-600 dark:text-gray-400">
        <?php echo e($title); ?>

    </div>
    <div class="text-2xl font-semibold <?php echo e($valueColor); ?>">
        <?php echo e($value); ?>

    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/stat-card.blade.php ENDPATH**/ ?>