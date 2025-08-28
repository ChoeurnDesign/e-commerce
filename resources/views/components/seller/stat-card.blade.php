@props([
    'label' => '',
    'value' => '—',
    'color' => 'indigo',   // allowed: indigo, green, yellow, red, blue, gray
    'icon'  => null,       // optional raw SVG or HTML
    'size'  => 'lg',       // lg | sm
])

@php
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
@endphp

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 rounded-lg shadow p-6 flex flex-col items-center w-full']) }}>
    <div class="flex items-center gap-3">
        @if($icon)
            <span class="p-2 rounded-md bg-gray-50 dark:bg-gray-700/50 text-gray-600 dark:text-gray-300">
                {!! $icon !!}
            </span>
        @endif
        <div class="flex flex-col items-center">
            <div class="font-bold leading-none mb-2 {{ $valueSize }} {{ $colorClass }}">
                {{ $value }}
            </div>
            <div class="font-medium {{ $labelSize }} text-gray-700 dark:text-gray-200 tracking-wide uppercase">
                {{ $label }}
            </div>
        </div>
    </div>
</div>