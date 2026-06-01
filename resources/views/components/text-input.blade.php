@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-rose-100 shadow-sm focus:ring-pink-400 focus:border-pink-400 rounded-md']) }}>
