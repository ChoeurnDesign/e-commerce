<?php use Illuminate\Support\Str; ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'fields' => [],
    'action' => url()->current(),
    'method' => 'GET',
    'filters' => [],
    'context' => 'admin', // 'admin' or 'seller'
    'ignoreKeys' => ['page', '__using_filter'],
    'booleanMap' => [
        'is_active'   => ['1' => 'Active', '0' => 'Inactive'],
        'on_sale'     => ['1' => 'On Sale', '0' => 'Not On Sale'],
        'is_featured' => ['1' => 'Featured', '0' => 'Not Featured'],
    ],
    'autoSubmit' => false,
    'textDebounce' => 600,
    'inputClass' => '', // allow external override
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
    'fields' => [],
    'action' => url()->current(),
    'method' => 'GET',
    'filters' => [],
    'context' => 'admin', // 'admin' or 'seller'
    'ignoreKeys' => ['page', '__using_filter'],
    'booleanMap' => [
        'is_active'   => ['1' => 'Active', '0' => 'Inactive'],
        'on_sale'     => ['1' => 'On Sale', '0' => 'Not On Sale'],
        'is_featured' => ['1' => 'Featured', '0' => 'Not Featured'],
    ],
    'autoSubmit' => false,
    'textDebounce' => 600,
    'inputClass' => '', // allow external override
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $formMethod = strtoupper($method) === 'POST' ? 'POST' : 'GET';

    $valueResolver = function($name) use ($filters) {
        return $filters[$name] ?? request($name);
    };

    $uniqueFields = collect($fields)
        ->filter(fn($f) => !empty($f['name']))
        ->unique('name')
        ->values();
?>

<form method="<?php echo e($formMethod); ?>"
      action="<?php echo e($action); ?>"
      data-filter-bar
      role="search"
      aria-label="<?php echo e(ucfirst($context)); ?> Filters"
      class="flex flex-wrap gap-3 items-end mb-5">

    <?php if($formMethod === 'POST'): ?>
        <?php echo csrf_field(); ?>
    <?php endif; ?>

    <input type="hidden" name="__using_filter" value="1">

    <?php $__currentLoopData = $uniqueFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $type = $f['type'] ?? 'text';
            $name = $f['name'];
            $label = $f['label'] ?? null;
            $placeholder = $f['placeholder'] ?? ($context === 'seller' ? 'Search Seller...' : 'Search Admin...');
            $options = $f['options'] ?? [];
            $value = $valueResolver($name);

            $inputBase = trim('border rounded px-3 py-2 text-sm bg-white dark:bg-[#23263a] border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-indigo-300 ' .
                                ($f['class'] ?? '') . ' ' . $inputClass);
        ?>

        <div class="flex flex-col">
            <?php if($label): ?>
                <label for="filter-<?php echo e($name); ?>" class="text-xs font-medium mb-1 text-gray-600 dark:text-gray-300">
                    <?php echo e($label); ?>

                </label>
            <?php endif; ?>

            
            <?php switch($type):
                case ('select'): ?>
                    <select id="filter-<?php echo e($name); ?>" name="<?php echo e($name); ?>" class="<?php echo e($inputBase); ?> min-w-[140px] filter-field">
                        <option value=""><?php echo e($placeholder); ?></option>
                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optValue => $optLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($optValue); ?>" <?php if((string)$value === (string)$optValue): echo 'selected'; endif; ?>><?php echo e($optLabel); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php break; ?>

                <?php case ('date'): ?>
                    <input id="filter-<?php echo e($name); ?>" type="date" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>"
                           class="<?php echo e($inputBase); ?> min-w-[140px] filter-field">
                    <?php break; ?>

                <?php case ('boolean'): ?>
                    <select id="filter-<?php echo e($name); ?>" name="<?php echo e($name); ?>" class="<?php echo e($inputBase); ?> min-w-[110px] filter-field">
                        <option value=""><?php echo e($placeholder); ?></option>
                        <?php $__currentLoopData = $booleanMap[$name] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optValue => $optLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($optValue); ?>" <?php if((string)$value === (string)$optValue): echo 'selected'; endif; ?>><?php echo e($optLabel); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php break; ?>

                <?php default: ?>
                    <input id="filter-<?php echo e($name); ?>" type="text" name="<?php echo e($name); ?>" value="<?php echo e(is_array($value) ? '' : $value); ?>"
                           placeholder="<?php echo e($placeholder); ?>"
                           class="<?php echo e($inputBase); ?> w-48 filter-field filter-text">
            <?php endswitch; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <div class="flex gap-2 items-end">
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded">
            Filter
        </button>
        <a href="<?php echo e($action); ?>"
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium px-4 py-2 rounded">
            Reset
        </a>
    </div>
</form><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/seller/filter-bar.blade.php ENDPATH**/ ?>