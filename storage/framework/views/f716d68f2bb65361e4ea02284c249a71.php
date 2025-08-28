<?php use Illuminate\Support\Str; ?>
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    // Array of field definition arrays:
    // Each: [
    //   'name' => 'status',
    //   'type' => 'select' | 'text' | 'number' | 'date' | 'boolean' | 'select-multi',
    //   'label' => 'Status',
    //   'placeholder' => 'All',
    //   'options' => ['approved'=>'Approved', ...], // for select / select-multi / boolean
    //   'true_label' => 'Yes', 'false_label'=>'No' (for boolean)
    //   'min','max','step','size' ...
    // ]
    'fields' => [],

    // Target action (defaults to current URL)
    'action' => url()->current(),

    // HTTP method (GET recommended for filter UIs)
    'method' => 'GET',

    // Explicit filter values override (otherwise request() is used)
    'filters' => [],

    // Keys NOT to show as chips
    'ignoreKeys' => ['page','__using_filter'],

    // Map for boolean-like fields -> nicer chip labels
    'booleanMap' => [
        'is_active'   => ['1'=>'Active','0'=>'Inactive'],
        'on_sale'     => ['1'=>'On Sale','0'=>'Not On Sale'],
        'is_featured' => ['1'=>'Featured','0'=>'Not Featured'],
    ],

    // Auto submit behavior toggles
    'autoSubmit' => false,
    'textDebounce' => 600,
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
    // Array of field definition arrays:
    // Each: [
    //   'name' => 'status',
    //   'type' => 'select' | 'text' | 'number' | 'date' | 'boolean' | 'select-multi',
    //   'label' => 'Status',
    //   'placeholder' => 'All',
    //   'options' => ['approved'=>'Approved', ...], // for select / select-multi / boolean
    //   'true_label' => 'Yes', 'false_label'=>'No' (for boolean)
    //   'min','max','step','size' ...
    // ]
    'fields' => [],

    // Target action (defaults to current URL)
    'action' => url()->current(),

    // HTTP method (GET recommended for filter UIs)
    'method' => 'GET',

    // Explicit filter values override (otherwise request() is used)
    'filters' => [],

    // Keys NOT to show as chips
    'ignoreKeys' => ['page','__using_filter'],

    // Map for boolean-like fields -> nicer chip labels
    'booleanMap' => [
        'is_active'   => ['1'=>'Active','0'=>'Inactive'],
        'on_sale'     => ['1'=>'On Sale','0'=>'Not On Sale'],
        'is_featured' => ['1'=>'Featured','0'=>'Not Featured'],
    ],

    // Auto submit behavior toggles
    'autoSubmit' => false,
    'textDebounce' => 600,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    // Normalize method
    $formMethod = strtoupper($method) === 'POST' ? 'POST' : 'GET';

    // Provide value resolver (filters override request)
    $valueResolver = function($name) use ($filters) {
        if(array_key_exists($name, $filters)) {
            return $filters[$name];
        }
        return request($name);
    };

    // De-duplicate field names
    $uniqueFields = collect($fields)
        ->filter(fn($f) => !empty($f['name']))
        ->unique('name')
        ->values();

?>

<form method="<?php echo e($formMethod); ?>"
      action="<?php echo e($action); ?>"
      data-filter-bar
      class="flex flex-wrap gap-3 items-end mb-5">

    <?php if($formMethod === 'POST'): ?>
        <?php echo csrf_field(); ?>
    <?php endif; ?>

    
    <input type="hidden" name="__using_filter" value="1">

    <?php $__currentLoopData = $uniqueFields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $type        = $f['type'] ?? 'text';
            $name        = $f['name'];
            $label       = $f['label'] ?? null;
            $placeholder = $f['placeholder'] ?? '';
            $options     = $f['options'] ?? [];
            $value       = $valueResolver($name);
            $inputBase   = 'border rounded px-3 py-2 text-sm bg-white dark:bg-[#23263a] border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-indigo-300';
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
                        <option value=""><?php echo e($placeholder ?: 'All'); ?></option>
                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optValue => $optLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($optValue); ?>" <?php if((string)$value === (string)$optValue): echo 'selected'; endif; ?>><?php echo e($optLabel); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php break; ?>

                <?php case ('select-multi'): ?>
                    <?php $vals = (array) $value; ?>
                    <select id="filter-<?php echo e($name); ?>" name="<?php echo e($name); ?>[]" multiple
                            size="<?php echo e($f['size'] ?? 5); ?>"
                            class="<?php echo e($inputBase); ?> min-w-[160px] filter-field">
                        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optValue => $optLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($optValue); ?>"
                                <?php if(in_array((string)$optValue, array_map('strval', (array)$vals), true)): echo 'selected'; endif; ?>>
                                <?php echo e($optLabel); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php break; ?>

                <?php case ('date'): ?>
                    <input id="filter-<?php echo e($name); ?>" type="date" name="<?php echo e($name); ?>" value="<?php echo e($value); ?>"
                           class="<?php echo e($inputBase); ?> min-w-[140px] filter-field">
                    <?php break; ?>

                <?php case ('number'): ?>
                    <input id="filter-<?php echo e($name); ?>"
                           type="number"
                           name="<?php echo e($name); ?>"
                           value="<?php echo e($value); ?>"
                           step="<?php echo e($f['step'] ?? '1'); ?>"
                           <?php if(isset($f['min'])): ?> min="<?php echo e($f['min']); ?>" <?php endif; ?>
                           <?php if(isset($f['max'])): ?> max="<?php echo e($f['max']); ?>" <?php endif; ?>
                           placeholder="<?php echo e($placeholder); ?>"
                           class="<?php echo e($inputBase); ?> w-28 filter-field">
                    <?php break; ?>

                <?php case ('boolean'): ?>
                    <select id="filter-<?php echo e($name); ?>" name="<?php echo e($name); ?>" class="<?php echo e($inputBase); ?> min-w-[110px] filter-field">
                        <option value=""><?php echo e($placeholder ?: 'Any'); ?></option>
                        <option value="1" <?php if((string)$value === '1'): echo 'selected'; endif; ?>><?php echo e($f['true_label'] ?? 'Yes'); ?></option>
                        <option value="0" <?php if((string)$value === '0'): echo 'selected'; endif; ?>><?php echo e($f['false_label'] ?? 'No'); ?></option>
                    </select>
                    <?php break; ?>

                <?php default: ?>
                    <input id="filter-<?php echo e($name); ?>"
                           type="text"
                           name="<?php echo e($name); ?>"
                           value="<?php echo e(is_array($value) ? '' : $value); ?>"
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
</form>

<?php
    // Build chip list from request() (or filters override) – use request() for consistency with pagination links.
    $activeQuery = request()->except($ignoreKeys);
?>

<?php if(count(array_filter($activeQuery, fn($v) => $v !== '' && $v !== null && (!is_array($v) || count(array_filter($v))))) > 0): ?>
    <div class="flex flex-wrap gap-2 mb-4">
        <?php $__currentLoopData = $activeQuery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $vals = is_array($v) ? $v : [$v];
            ?>
            <?php $__currentLoopData = $vals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($vv === '' || $vv === null): ?> <?php continue; ?> <?php endif; ?>
                <?php
                    $displayVal = $vv;
                    if(isset($booleanMap[$k][$vv])) {
                        $displayVal = $booleanMap[$k][$vv];
                    }
                    // Remove only this one value if multi
                    $remaining = request()->except([$k,'page']);
                    if(is_array(request($k)) && count($vals) > 1){
                        $remaining[$k] = collect($vals)
                            ->reject(fn($x)=> (string)$x === (string)$vv)
                            ->values()->all();
                    } elseif(is_array(request($k)) && count($vals) === 1) {
                        unset($remaining[$k]);
                    }
                    // Purge empties
                    $clean = [];
                    foreach ($remaining as $rk=>$rv){
                        if(is_array($rv)){
                            $rva = array_filter($rv, fn($x)=>$x !== null && $x !== '');
                            if(count($rva)) $clean[$rk] = $rva;
                        } else {
                            if($rv !== '' && $rv !== null) $clean[$rk] = $rv;
                        }
                    }
                    $qs = http_build_query($clean);
                ?>
                <a href="<?php echo e(url()->current() . ($qs ? '?'.$qs : '')); ?>"
                   class="group text-xs bg-gray-200 dark:bg-[#232c47] text-gray-700 dark:text-gray-200 px-2 py-1 rounded flex items-center gap-1 hover:bg-gray-300 dark:hover:bg-[#2b3458]"
                   aria-label="Remove filter <?php echo e($k); ?> <?php echo e($displayVal); ?>">
                    <span><?php echo e($k); ?>: <?php echo e(Str::limit((string)$displayVal,20)); ?></span>
                    <span class="font-bold group-hover:text-red-600">&times;</span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>

<?php if (! $__env->hasRenderedOnce('a5ead7d7-a8e1-43f5-8ce7-089747e19ffb')): $__env->markAsRenderedOnce('a5ead7d7-a8e1-43f5-8ce7-089747e19ffb');
$__env->startPush('scripts'); ?>
<script>
(function() {
    const form = document.querySelector('form[data-filter-bar]');
    if(!form) return;

    const AUTO_SUBMIT = <?php echo e($autoSubmit ? 'true' : 'false'); ?>;
    const TEXT_DEBOUNCE_MS = <?php echo e((int)$textDebounce); ?>;
    let debounceTimer = null;

    // On submit: disable empty inputs so URL stays clean
    form.addEventListener('submit', () => {
        const toEnable = [];
        [...form.elements].forEach(el => {
            if (!el.name) return;
            if (['SELECT','INPUT','TEXTAREA'].includes(el.tagName) &&
                el.type !== 'hidden' &&
                (el.value === null || el.value.trim() === '')) {
                el.disabled = true;
                toEnable.push(el);
            }
        });
        setTimeout(()=>toEnable.forEach(e=>e.disabled=false), 1000);
    });

    if(!AUTO_SUBMIT) return;

    const submit = () => {
        // requestSubmit supports HTML5 validation & method spoofing
        if(form.requestSubmit) form.requestSubmit(); else form.submit();
    };

    // Change-based auto submit
    form.querySelectorAll('select.filter-field:not([multiple]), input.filter-field[type="date"], input.filter-field[type="number"]').forEach(el => {
        el.addEventListener('change', submit);
    });

    // Multi-select change
    form.querySelectorAll('select[multiple].filter-field').forEach(el => {
        el.addEventListener('change', submit);
    });

    // Debounced text fields
    form.querySelectorAll('input.filter-text').forEach(el => {
        el.addEventListener('input', () => {
            if(debounceTimer) clearTimeout(debounceTimer);
            debounceTimer = setTimeout(submit, TEXT_DEBOUNCE_MS);
        });
        el.addEventListener('keydown', e => {
            if(e.key === 'Enter'){
                e.preventDefault();
                if(debounceTimer) clearTimeout(debounceTimer);
                submit();
            }
        });
    });
})();
</script>
<?php $__env->stopPush(); endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/admin/filter-bar.blade.php ENDPATH**/ ?>