@props([
    'label' => '',
    'value' => '—',
    'color' => 'pink',
    'icon'  => null,
    'size'  => 'lg',       // lg | sm
])

@php
    // Whitelist color stems to prevent invalid class injection
    $palette = [
        'pink'   => 'text-pink-600',
        'indigo' => 'text-indigo-600',
        'green'  => 'text-green-600',
        'yellow' => 'text-yellow-600',
        'red'    => 'text-red-600',
        'blue'   => 'text-blue-600',
        'gray'   => 'text-gray-700',
    ];
    $colorClass = $palette[$color] ?? $palette['pink'];

    $valueSize = $size === 'sm' ? 'text-2xl' : 'text-3xl';
    $labelSize = $size === 'sm' ? 'text-xs' : 'text-sm';
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow p-6 flex flex-col items-center w-full border border-pink-100']) }}>
    <div class="flex items-center gap-3">
        @if($icon)
            <span class="p-2 rounded-md bg-gray-50 text-gray-600">
                {!! $icon !!}
            </span>
        @endif
        <div class="flex flex-col items-center">
            <div class="font-bold leading-none mb-2 {{ $valueSize }} {{ $colorClass }}">
                {{ $value }}
            </div>
            <div class="font-medium {{ $labelSize }} text-gray-700 tracking-wide uppercase">
                {{ $label }}
            </div>
        </div>
    </div>
</div>