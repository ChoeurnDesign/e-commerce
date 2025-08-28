@props([
    'status' => '',
    'size' => 'md',     // sm | md
    'dot' => true,
    'capitalize' => true,
])

@php
    $map = [
        'approved' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200',
        'pending'  => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200',
        'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200',
    ];
    $base = $map[$status] ?? 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200';
    $pad  = $size === 'sm' ? 'px-2 py-0.5 text-[11px]' : 'px-3 py-0.5 text-xs';
    $label = $capitalize ? ucfirst($status) : $status;

    $dotColor = match($status) {
        'approved' => 'bg-green-500',
        'pending'  => 'bg-yellow-500',
        'rejected' => 'bg-red-500',
        default    => 'bg-gray-400',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1.5 font-medium rounded-full $base $pad"]) }}>
    @if($dot)
        <span class="w-2 h-2 rounded-full {{ $dotColor }}"></span>
    @endif
    {{ $label ?: '—' }}
</span>