@php use Illuminate\Support\Str; @endphp
@props([
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
])

@php
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

@endphp

<form method="{{ $formMethod }}"
      action="{{ $action }}"
      data-filter-bar
      class="flex flex-wrap gap-3 items-end mb-5">

    @if($formMethod === 'POST')
        @csrf
    @endif

    {{-- Hidden marker (exclude from chips) --}}
    <input type="hidden" name="__using_filter" value="1">

    @foreach($uniqueFields as $f)
        @php
            $type        = $f['type'] ?? 'text';
            $name        = $f['name'];
            $label       = $f['label'] ?? null;
            $placeholder = $f['placeholder'] ?? '';
            $options     = $f['options'] ?? [];
            $value       = $valueResolver($name);
            $inputBase   = 'border rounded px-3 py-2 text-sm bg-white dark:bg-[#23263a] border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-indigo-300';
        @endphp

        <div class="flex flex-col">
            @if($label)
                <label for="filter-{{ $name }}" class="text-xs font-medium mb-1 text-gray-600 dark:text-gray-300">
                    {{ $label }}
                </label>
            @endif

            @switch($type)
                @case('select')
                    <select id="filter-{{ $name }}" name="{{ $name }}" class="{{ $inputBase }} min-w-[140px] filter-field">
                        <option value="">{{ $placeholder ?: 'All' }}</option>
                        @foreach($options as $optValue => $optLabel)
                            <option value="{{ $optValue }}" @selected((string)$value === (string)$optValue)>{{ $optLabel }}</option>
                        @endforeach
                    </select>
                    @break

                @case('select-multi')
                    @php $vals = (array) $value; @endphp
                    <select id="filter-{{ $name }}" name="{{ $name }}[]" multiple
                            size="{{ $f['size'] ?? 5 }}"
                            class="{{ $inputBase }} min-w-[160px] filter-field">
                        @foreach($options as $optValue => $optLabel)
                            <option value="{{ $optValue }}"
                                @selected(in_array((string)$optValue, array_map('strval', (array)$vals), true))>
                                {{ $optLabel }}
                            </option>
                        @endforeach
                    </select>
                    @break

                @case('date')
                    <input id="filter-{{ $name }}" type="date" name="{{ $name }}" value="{{ $value }}"
                           class="{{ $inputBase }} min-w-[140px] filter-field">
                    @break

                @case('number')
                    <input id="filter-{{ $name }}"
                           type="number"
                           name="{{ $name }}"
                           value="{{ $value }}"
                           step="{{ $f['step'] ?? '1' }}"
                           @if(isset($f['min'])) min="{{ $f['min'] }}" @endif
                           @if(isset($f['max'])) max="{{ $f['max'] }}" @endif
                           placeholder="{{ $placeholder }}"
                           class="{{ $inputBase }} w-28 filter-field">
                    @break

                @case('boolean')
                    <select id="filter-{{ $name }}" name="{{ $name }}" class="{{ $inputBase }} min-w-[110px] filter-field">
                        <option value="">{{ $placeholder ?: 'Any' }}</option>
                        <option value="1" @selected((string)$value === '1')>{{ $f['true_label'] ?? 'Yes' }}</option>
                        <option value="0" @selected((string)$value === '0')>{{ $f['false_label'] ?? 'No' }}</option>
                    </select>
                    @break

                @default
                    <input id="filter-{{ $name }}"
                           type="text"
                           name="{{ $name }}"
                           value="{{ is_array($value) ? '' : $value }}"
                           placeholder="{{ $placeholder }}"
                           class="{{ $inputBase }} w-48 filter-field filter-text">
            @endswitch
        </div>
    @endforeach

    <div class="flex gap-2 items-end">
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded">
            Filter
        </button>
        <a href="{{ $action }}"
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium px-4 py-2 rounded">
            Reset
        </a>
    </div>
</form>

@php
    // Build chip list from request() (or filters override) – use request() for consistency with pagination links.
    $activeQuery = request()->except($ignoreKeys);
@endphp

@if(count(array_filter($activeQuery, fn($v) => $v !== '' && $v !== null && (!is_array($v) || count(array_filter($v))))) > 0)
    <div class="flex flex-wrap gap-2 mb-4">
        @foreach($activeQuery as $k => $v)
            @php
                $vals = is_array($v) ? $v : [$v];
            @endphp
            @foreach($vals as $vv)
                @if($vv === '' || $vv === null) @continue @endif
                @php
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
                @endphp
                <a href="{{ url()->current() . ($qs ? '?'.$qs : '') }}"
                   class="group text-xs bg-gray-200 dark:bg-[#232c47] text-gray-700 dark:text-gray-200 px-2 py-1 rounded flex items-center gap-1 hover:bg-gray-300 dark:hover:bg-[#2b3458]"
                   aria-label="Remove filter {{ $k }} {{ $displayVal }}">
                    <span>{{ $k }}: {{ Str::limit((string)$displayVal,20) }}</span>
                    <span class="font-bold group-hover:text-red-600">&times;</span>
                </a>
            @endforeach
        @endforeach
    </div>
@endif

@pushOnce('scripts')
<script>
(function() {
    const form = document.querySelector('form[data-filter-bar]');
    if(!form) return;

    const AUTO_SUBMIT = {{ $autoSubmit ? 'true' : 'false' }};
    const TEXT_DEBOUNCE_MS = {{ (int)$textDebounce }};
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
@endPushOnce