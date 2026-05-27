@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1'])

@php
    $alignmentClasses = match ($align) {
        'left' => 'origin-top-left start-0',
        'top' => 'origin-top',
        default => 'origin-top-right end-0',
    };
    $widthClass = match ($width) {
        '48' => 'w-48',
        default => is_numeric($width) ? "w-{$width}" : $width,
    };
@endphp

<div class="relative inline-block" x-data="{ open: false }" @keydown.escape.window="open = false">
    <div @click="open = !open" class="cursor-pointer">
        {{ $trigger ?? '' }}
    </div>

    <div x-show="open"
        x-cloak
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-[150] mt-2 {{ $widthClass }} rounded-md shadow-lg {{ $alignmentClasses }}"
        style="display: none;">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>