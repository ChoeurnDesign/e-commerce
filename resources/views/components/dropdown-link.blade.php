@props(['type' => 'link'])

@if($type === 'button')
    <button {{ $attributes->merge([
        'type' => 'button',
        'class' => 'flex items-center w-full px-4 py-2.5 text-start text-sm leading-5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out cursor-pointer'
    ]) }}>
        {{ $slot }}
    </button>
@else
    <a {{ $attributes->merge([
        'class' => 'flex items-center w-full px-4 py-2.5 text-start text-sm leading-5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out'
    ]) }}>
        {{ $slot }}
    </a>
@endif