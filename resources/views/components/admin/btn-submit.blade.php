<button type="submit"
    {{ $attributes->merge(['class' => 'inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-full shadow-lg']) }}>
    {{ $slot ?? 'Save' }}
</button>
