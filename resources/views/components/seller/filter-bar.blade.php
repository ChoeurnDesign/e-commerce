@php use Illuminate\Support\Str; @endphp
@props([
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
])

@php
    $formMethod = strtoupper($method) === 'POST' ? 'POST' : 'GET';

    $valueResolver = function($name) use ($filters) {
        return $filters[$name] ?? request($name);
    };

    $uniqueFields = collect($fields)
        ->filter(fn($f) => !empty($f['name']))
        ->unique('name')
        ->values();
@endphp

<form method="{{ $formMethod }}"
      action="{{ $action }}"
      data-filter-bar
      role="search"
      aria-label="{{ ucfirst($context) }} Filters"
      class="flex flex-wrap gap-3 items-end mb-5">

    @if($formMethod === 'POST')
        @csrf
    @endif

    <input type="hidden" name="__using_filter" value="1">

    @foreach($uniqueFields as $f)
        @php
            $type = $f['type'] ?? 'text';
            $name = $f['name'];
            $label = $f['label'] ?? null;
            $placeholder = $f['placeholder'] ?? ($context === 'seller' ? 'Search Seller...' : 'Search Admin...');
            $options = $f['options'] ?? [];
            $value = $valueResolver($name);

            $inputBase = trim('border rounded px-3 py-2 text-sm bg-white dark:bg-[#23263a] border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-200 focus:outline-none focus:ring focus:ring-indigo-300 ' .
                                ($f['class'] ?? '') . ' ' . $inputClass);
        @endphp

        <div class="flex flex-col">
            @if($label)
                <label for="filter-{{ $name }}" class="text-xs font-medium mb-1 text-gray-600 dark:text-gray-300">
                    {{ $label }}
                </label>
            @endif

            {{-- Input Types --}}
            @switch($type)
                @case('select')
                    <select id="filter-{{ $name }}" name="{{ $name }}" class="{{ $inputBase }} min-w-[140px] filter-field">
                        <option value="">{{ $placeholder }}</option>
                        @foreach($options as $optValue => $optLabel)
                            <option value="{{ $optValue }}" @selected((string)$value === (string)$optValue)>{{ $optLabel }}</option>
                        @endforeach
                    </select>
                    @break

                @case('date')
                    <input id="filter-{{ $name }}" type="date" name="{{ $name }}" value="{{ $value }}"
                           class="{{ $inputBase }} min-w-[140px] filter-field">
                    @break

                @case('boolean')
                    <select id="filter-{{ $name }}" name="{{ $name }}" class="{{ $inputBase }} min-w-[110px] filter-field">
                        <option value="">{{ $placeholder }}</option>
                        @foreach($booleanMap[$name] ?? [] as $optValue => $optLabel)
                            <option value="{{ $optValue }}" @selected((string)$value === (string)$optValue)>{{ $optLabel }}</option>
                        @endforeach
                    </select>
                    @break

                @default
                    <input id="filter-{{ $name }}" type="text" name="{{ $name }}" value="{{ is_array($value) ? '' : $value }}"
                           placeholder="{{ $placeholder }}"
                           class="{{ $inputBase }} w-48 filter-field filter-text">
            @endswitch
        </div>
    @endforeach

    {{-- Buttons --}}
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