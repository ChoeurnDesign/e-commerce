@props(['active' => false])

@php
$base = 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none';
$activeClasses = 'border-pink-400 focus:border-pink-700';
$inactiveClasses = 'border-transparent text-gray-300 hover:text-pink-600 hover:border-pink-200 focus:text-pink-700 focus:border-pink-200';

$classes = $base . ' ' . ($active ? $activeClasses : $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

