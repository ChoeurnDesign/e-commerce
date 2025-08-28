@props([
    'width' => 'w-80',
    'name' => 'q',
    'placeholder' => 'Search...',
    'label' => 'Search',
    'hint' => null,
    'action' => null,
    'autofocus' => false,
])

@php
    $value = request($name, '');
    $formAction = $action ?: url()->current();
@endphp

<form method="GET" action="{{ $formAction }}"
      class="flex flex-wrap gap-3 items-end bg-white dark:bg-[#23263a] p-4 rounded border border-gray-300 dark:border-[#23263a]">
    <div class="flex flex-col">
        @if($label)
            <label class="text-xs font-medium mb-1 text-gray-600 dark:text-gray-300">
                {{ $label }}
                @if($hint)
                    <span class="font-normal text-[10px] text-gray-400">({{ $hint }})</span>
                @endif
            </label>
        @endif
        <input
            type="text"
            name="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder }}"
            @if($autofocus) autofocus @endif
            class="{{ $width }} border rounded px-3 py-2 text-sm bg-white dark:bg-[#1e2333]
                   border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100
                   focus:outline-none focus:ring focus:ring-indigo-300" />
    </div>

    <div class="flex gap-2 items-end">
        <button type="submit"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded shadow">
            Search
        </button>

        @if($value !== '')
            <a href="{{ $formAction }}"
               class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-100 text-sm rounded">
                Reset
            </a>
        @endif
    </div>

    {{ $slot ?? '' }}
</form>
