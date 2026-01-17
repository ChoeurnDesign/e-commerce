<div class="flex flex-col w-full">
    <!-- Top Nav: Logo + Links -->
    <div class="flex items-center h-16 w-full border-b border-gray-200 bg-gray-800 dark:bg-gray-900 dark:border-gray-800">
        @include('layouts.partials.nav-logo')

        <!-- Desktop Links -->
        <div class="hidden lg:flex space-x-4 ml-8">
            @include('layouts.partials.nav-desktop-links')
        </div>

        <div class="hidden lg:flex ml-auto space-x-4 items-center">
            @include('layouts.partials.nav-faq-help')
        </div>

        <!-- Search bar: Only show on mobile (below lg) -->
        <div class="lg:hidden mx-4 pr-4 flex-1 justify-center ml-6">
            @include('layouts.partials.nav-search')
        </div>
    </div>

    <!-- Bottom Nav: Search + Global Actions + Hamburger -->
    <div class="flex items-center justify-between h-16 w-full">
        <div class="hidden lg:flex flex-1 mr-2 items-center">
            @include('layouts.partials.nav-search')
        </div>

        <div class="lg:hidden flex-1 justify-start ml-auto space-x-4">
            @include('layouts.partials.nav-faq-help')
        </div>

        <div class="flex items-center">
            <!-- Language/Currency -->
            <div x-data="{ open: false }" class="relative">
                @include('layouts.partials.nav-language-currency')
            </div>

            <x-chat.chat-icon :route="route('chat.index')" label="User Chat" :badge="$unreadUserChats ?? 0"/>

            {{-- Notification --}}
            <div x-data="{ open: false }" class="relative">
                @include('layouts.partials.nav-notification')
            </div>

            <div class="flex items-center">
                @include('layouts.partials.nav-cart-wishlist', [
                    'cartCount' => $cartCount ?? 0,
                    'wishlistCount' => $wishlistCount ?? 0
                ])
            </div>

            <x-dark-mode-toggle class=""/>

            <!-- User Dropdown -->
            <x-dropdown align="right" width="48">
                @include('layouts.partials.nav-user-dropdown')
            </x-dropdown>
        </div>
    </div>
</div>
