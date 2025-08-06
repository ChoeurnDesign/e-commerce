<div x-data="{ open: false }" class="relative">
    <button @click="open = !open"
        class="flex items-center py-1 bg-transparent rounded focus:outline-none transition text-gray-700 dark:text-white text-sm"
        :class="{ 'ring-2 ring-indigo-500': open }">
        <svg class="w-4 h-4 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" stroke="currentColor"/>
            <path d="M2 12h20M12 2c2.5 2 4 5.5 4 10s-1.5 8-4 10M12 2c-2.5 2-4 5.5-4 10s1.5 8 4 10" stroke="currentColor"/>
        </svg>
        <span class="text-gray-400 dark:text-gray-300">EN</span>
        <span class="mx-1 text-gray-400 dark:text-gray-300">|</span>
        <svg class="w-4 h-4 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <ellipse cx="12" cy="8" rx="8" ry="4" stroke="currentColor" />
            <path d="M4 8v8c0 2.21 3.58 4 8 4s8-1.79 8-4V8" stroke="currentColor" />
            <path d="M4 16c0 2.21 3.58 4 8 4s8-1.79 8-4" stroke="currentColor" />
        </svg>
        <span class="text-gray-400 dark:text-gray-300">$</span>
        <svg class="w-4 h-4 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <!-- Dropdown remains unchanged -->
    <div x-show="open" x-cloak @click.away="open = false"
        x-transition
        class="absolute left-0 mt-1 w-40 bg-white dark:bg-[#181b23] text-gray-700 dark:text-white shadow-md rounded z-50 py-1 border border-indigo-500 text-sm">
        <div class="px-3 pt-1 pb-0 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Language</div>
        <a href="#" class="block px-3 py-1 text-gray-700 dark:text-white hover:bg-gray-300 dark:hover:bg-[#2e1065] transition">English</a>
        <div class="border-t my-1 border-indigo-500"></div>
        <div class="px-3 pt-0 pb-0 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Currency</div>
        <a href="#" class="block px-3 py-1 text-gray-700 dark:text-white hover:bg-gray-300 dark:hover:bg-[#2e1065] transition">$ - USD</a>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/partials/nav-language-currency.blade.php ENDPATH**/ ?>