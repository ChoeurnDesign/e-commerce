<form method="GET" action="{{ route('products.index') }}" class="relative w-full max-w-xl">
    <input type="text" name="search" id="search-input" placeholder="Search products..."
        class="w-full pl-10 pr-4 py-2 rounded-full border-1 border-gray-400 dark:border-gray-700 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-[#181f31] transition-all text-gray-100 placeholder-gray-400">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-indigo-500 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
</form>
