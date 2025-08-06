@props(['active' => false])

@php
$base = 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none';
$activeClasses = 'border-indigo-400 focus:border-indigo-700';
$inactiveClasses = 'border-transparent text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-300 hover:border-indigo-200 focus:text-indigo-700 focus:border-indigo-200';

$classes = $base . ' ' . ($active ? $activeClasses : $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
