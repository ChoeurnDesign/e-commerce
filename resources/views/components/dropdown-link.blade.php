@props(['type' => 'link'])

@if($type === 'button')
    <button {{ $attributes->merge([
        'type' => 'button',
        'class' => 'flex items-center w-full px-4 py-2.5 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer'
    ]) }}>
        {{ $slot }}
    </button>
@else
    <a {{ $attributes->merge([
        'class' => 'flex items-center w-full px-4 py-2.5 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out'
    ]) }}>
        {{ $slot }}
    </a>
@endif