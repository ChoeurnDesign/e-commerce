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
    $inputId = 'simple-search-' . md5($name);
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
            id="{{ $inputId }}"
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

@if($autofocus)
<script>
    (function() {
        const el = document.getElementById('{{ $inputId }}');
        if (!el) return;
        // Wait for browser/autofocus to run, then move caret to end if there's already text
        window.requestAnimationFrame(() => {
            if (el.value && el.value.length) {
                try {
                    // modern browsers
                    el.focus();
                    el.setSelectionRange(el.value.length, el.value.length);
                } catch (e) {
                    // fallback: reassign value to move caret to end
                    const v = el.value;
                    el.value = '';
                    el.value = v;
                    el.focus();
                }
            } else {
                // ensure focused if autofocus requested
                el.focus();
            }
        });
    })();
</script>
@endif