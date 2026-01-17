<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'width' => 'w-80',
    'name' => 'q',
    'placeholder' => 'Search...',
    'label' => 'Search',
    'hint' => null,
    'action' => null,
    'autofocus' => false,
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
    'width' => 'w-80',
    'name' => 'q',
    'placeholder' => 'Search...',
    'label' => 'Search',
    'hint' => null,
    'action' => null,
    'autofocus' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $value = request($name, '');
    $formAction = $action ?: url()->current();
    $inputId = 'simple-search-' . md5($name);
?>

<form method="GET" action="<?php echo e($formAction); ?>"
      class="flex flex-wrap gap-3 items-end bg-white dark:bg-[#23263a] p-4 rounded border border-gray-300 dark:border-[#23263a]">
    <div class="flex flex-col">
        <?php if($label): ?>
            <label class="text-xs font-medium mb-1 text-gray-600 dark:text-gray-300">
                <?php echo e($label); ?>

                <?php if($hint): ?>
                    <span class="font-normal text-[10px] text-gray-400">(<?php echo e($hint); ?>)</span>
                <?php endif; ?>
            </label>
        <?php endif; ?>
        <input
            id="<?php echo e($inputId); ?>"
            type="text"
            name="<?php echo e($name); ?>"
            value="<?php echo e($value); ?>"
            placeholder="<?php echo e($placeholder); ?>"
            <?php if($autofocus): ?> autofocus <?php endif; ?>
            class="<?php echo e($width); ?> border rounded px-3 py-2 text-sm bg-white dark:bg-[#1e2333]
                   border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100
                   focus:outline-none focus:ring focus:ring-indigo-300" />
    </div>

    <div class="flex gap-2 items-end">
        <button type="submit"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded shadow">
            Search
        </button>

        <?php if($value !== ''): ?>
            <a href="<?php echo e($formAction); ?>"
               class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-100 text-sm rounded">
                Reset
            </a>
        <?php endif; ?>
    </div>

    <?php echo e($slot ?? ''); ?>

</form>

<?php if($autofocus): ?>
<script>
    (function() {
        const el = document.getElementById('<?php echo e($inputId); ?>');
        if (!el) return;
        // Wait for browser/autofocus to run, then move caret to end if there's already text
        window.requestAnimationFrame(() => {
            if (el.value && el.value.length) {
                try {
                    // modern browsers
                    el.focus();
                    el.setSelectionRange(el.value.length, el.value.length);
                } catch (e) {
                    // fallback: reassign value to move caret to end
                    const v = el.value;
                    el.value = '';
                    el.value = v;
                    el.focus();
                }
            } else {
                // ensure focused if autofocus requested
                el.focus();
            }
        });
    })();
</script>
<?php endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/admin/simple-search.blade.php ENDPATH**/ ?>