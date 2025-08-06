@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium ml-2 text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
