<a {{ $attributes->merge([
    'class' =>
        'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-800 focus:outline-none focus:bg-indigo-100 dark:focus:bg-indigo-900 transition duration-150 ease-in-out'
]) }}>
    {{ $slot }}
</a>
