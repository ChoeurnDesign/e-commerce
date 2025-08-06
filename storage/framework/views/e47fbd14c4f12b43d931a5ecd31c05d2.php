<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-0'
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
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-0'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $alignmentClasses = match ($align) {
        'left' => 'origin-top-left start-0',
        'top' => 'origin-top',
        default => 'origin-top-right end-0',
    };

    $widthClass = match ($width) {
        '48' => 'w-48',
        default => is_numeric($width) ? "w-{$width}" : $width,
    };
?>

<div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
    <div @click="open = !open" @keydown.enter="open = !open" aria-haspopup="true" aria-expanded="open" tabindex="0">
        <?php echo e($trigger); ?>

    </div>
    <div
        x-show="open"
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 <?php echo e($widthClass); ?> rounded-md shadow-lg <?php echo e($alignmentClasses); ?>"
        style="display: none;"
        role="menu"
        aria-orientation="vertical"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 <?php echo e($contentClasses); ?>">
            <?php echo e($content); ?>

        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/dropdown.blade.php ENDPATH**/ ?>