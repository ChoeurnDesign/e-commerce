@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 text-start text-base font-normal text-gray-300 bg-gray-800 focus:outline-none transition duration-150 ease-in-out'
    : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-normal text-gray-300 hover:text-gray-400 hover:bg-gray-700 hover:border-gray-400 focus:outline-none focus:text-gray-400 focus:bg-gray-700 focus:border-gray-400 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
