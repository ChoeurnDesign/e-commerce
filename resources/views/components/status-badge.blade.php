@props(['status'])
@php
    $color = match($status) {
        'pending' => 'bg-yellow-100 text-yellow-700',
        'approved' => 'bg-green-100 text-green-700',
        'rejected' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700'
    };
@endphp
<span class="inline-block px-2 py-1 rounded-full text-xs {{ $color }}">
    {{ ucfirst($status) }}
</span>
