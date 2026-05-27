<div class="flex flex-col w-full relative">
<!-- Top Navbar -->
<div class="flex items-center h-16 px-4 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">

    @include('layouts.partials.nav-logo')

    <!-- Desktop Links -->
    <div class="hidden lg:flex ml-8 space-x-4">
        @include('layouts.partials.nav-desktop-links')
    </div>

    <!-- Mobile Actions -->
    <div class="flex items-center gap-0.5 ml-auto lg:hidden">

        <!-- Search -->
        <button @click="openSearch = !openSearch"
            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <svg x-show="!openSearch" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <svg x-show="openSearch" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Theme -->
        <button onclick="window.toggleTheme();"
            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <span class="dark:hidden">
                <x-icon-dashboard name="moon" class="w-5 h-5" />
            </span>
            <span class="hidden dark:block">
                <x-icon-dashboard name="sun" class="w-5 h-5" />
            </span>
        </button>

        <!-- Menu -->
        <button @click="mobileMenuOpen = !mobileMenuOpen"
            class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Desktop Right -->
    <div class="hidden lg:flex ml-auto items-center space-x-4">
        @include('layouts.partials.nav-faq-help')
    </div>
</div>

<!-- Search Section -->
<div class="h-14 px-4 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 items-center"
     :class="openSearch ? 'flex' : 'hidden lg:flex'">

    <div class="flex items-center w-full">

        <!-- Search -->
        <div class="flex-1">
            @include('layouts.partials.nav-search')
        </div>

        <!-- Desktop Icons -->
        <div class="hidden lg:flex items-center space-x-4 ml-6">

            @include('layouts.partials.nav-language-currency')
            @include('layouts.partials.nav-notification')

            @include('layouts.partials.nav-cart-wishlist', [
                'cartCount' => $cartCount ?? 0,
                'wishlistCount' => $wishlistCount ?? 0
            ])

            <button onclick="window.toggleTheme();"
                class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <span class="dark:hidden">
                    <x-icon-dashboard name="moon" class="w-5 h-5" />
                </span>
                <span class="hidden dark:block">
                    <x-icon-dashboard name="sun" class="w-5 h-5" />
                </span>
            </button>

            <x-dropdown align="right" width="48">
                @include('layouts.partials.nav-user-dropdown')
            </x-dropdown>

        </div>
    </div>
</div>
</div>
