<nav class="bg-gray-800 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800 sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
    <div class="w-full px-8">
        @include('layouts.partials.desktop-nav')
        <!-- Hamburger always visible at lg and below -->
        <button @click="mobileMenuOpen = !mobileMenuOpen"
            class="lg:hidden absolute top-4 right-6 p-1 text-gray-400 dark:text-gray-300 hover:text-gray-500 dark:hover:text-white rounded-lg hover:bg-gray-300 dark:hover:bg-gray-800">
            <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
    @include('layouts.partials.mobile-nav')
</nav>
