@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-normal ml-2 mb-2 text-normal text-gray-800 dark:text-gray-200']) }}>
    {{ $value ?? $slot }}
</label>
