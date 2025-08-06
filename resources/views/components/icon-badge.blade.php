<span {{ $attributes->merge([
    'class' => 'absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 min-w-[1.2em] px-1
    flex items-center justify-center font-medium leading-none'
]) }}>
    {{ $slot }}
</span>
