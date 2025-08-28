<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

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

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php
    $color = match($status) {
        'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
        'approved' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
        'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
        default => 'bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300'
    };
?>
<span class="inline-block px-2 py-1 rounded-full text-xs <?php echo e($color); ?>">
    <?php echo e(ucfirst($status)); ?>

</span>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/status-badge.blade.php ENDPATH**/ ?>