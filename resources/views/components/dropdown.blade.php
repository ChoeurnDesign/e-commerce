@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-0'
])

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

<div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">
    <div @click="open = !open" @keydown.enter="open = !open" aria-haspopup="true" aria-expanded="open" tabindex="0">
        {{ $trigger }}
    </div>
    <div
        x-show="open"
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $widthClass }} rounded-md shadow-lg {{ $alignmentClasses }}"
        style="display: none;"
        role="menu"
        aria-orientation="vertical"
    >
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
