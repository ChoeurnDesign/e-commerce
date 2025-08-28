@props(['status'])
@php
    $color = match($status) {
        'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
        'approved' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
        'rejected' => 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300',
        default => 'bg-gray-100 text-gray-700 dark:bg-gray-900 dark:text-gray-300'
    };
@endphp
<span class="inline-block px-2 py-1 rounded-full text-xs {{ $color }}">
    {{ ucfirst($status) }}
</span>
