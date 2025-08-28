@props([
    'title',
    'value',
    // allowed: gray | yellow | green | red
    'color' => 'gray',
])

@php
    // Text color for the VALUE in light / dark
    $valuePalette = [
        'gray'   => ['light' => 'text-gray-700',   'dark' => 'dark:text-gray-200'],
        'yellow' => ['light' => 'text-yellow-600', 'dark' => 'dark:text-yellow-400'],
        'green'  => ['light' => 'text-green-600',  'dark' => 'dark:text-green-400'],
        'red'    => ['light' => 'text-red-600',    'dark' => 'dark:text-red-400'],
    ];
    $valueColor = ($valuePalette[$color]['light'] ?? 'text-gray-700') . ' ' . ($valuePalette[$color]['dark'] ?? 'dark:text-gray-200');
@endphp

<div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a] rounded-lg p-5 text-center transition-colors">
    <div class="mb-1 text-xs font-medium tracking-wide uppercase text-gray-600 dark:text-gray-400">
        {{ $title }}
    </div>
    <div class="text-2xl font-semibold {{ $valueColor }}">
        {{ $value }}
    </div>
</div>
