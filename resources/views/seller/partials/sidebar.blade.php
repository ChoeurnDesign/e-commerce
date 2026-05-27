<aside class="fixed md:relative inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-900 flex-shrink-0 flex flex-col border-r border-gray-200 dark:border-gray-700 shadow-lg transition-all duration-300 ease-in-out"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    <div class="flex items-center justify-between h-16 border-b border-gray-200 dark:border-gray-700 px-4">
        <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-2 flex-1 min-w-0">
            <div class="relative w-10 h-10">
                @php
                    $seller = auth()->user()->seller;
                    $sidebarLogo = $seller?->store_logo_url;
                    $storeName = $seller?->store_name;
                    $storeInitials = 'S';
                    if ($storeName) {
                        $words = explode(' ', $storeName);
                        $storeInitials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), $words)));
                    }
                @endphp

                @if($sidebarLogo)
                    <img src="{{ $sidebarLogo }}" 
                         alt="Store Logo" 
                         class="w-10 h-10 rounded-full object-cover border border-indigo-500"
                         onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');">
                    <div class="w-10 h-10 rounded-full bg-indigo-600 text-white hidden flex items-center justify-center font-semibold text-xs border border-indigo-500">
                        {{ $storeInitials }}
                    </div>
                @else
                    <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold text-xs border border-indigo-500">
                        {{ $storeInitials }}
                    </div>
                @endif
            </div>
            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400 tracking-wide truncate">Seller Panel</span>
        </a>
        {{-- Close on mobile only --}}
        <button @click="sidebarOpen = false"
                class="md:hidden flex-shrink-0 p-1.5 rounded-lg text-gray-400 hover:text-gray-700 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    @php
        $is = fn(...$names) => request()->routeIs($names);
        $linkBase = 'flex items-center px-3 py-2 rounded-lg transition font-medium';
        
        // Active/Idle states that adapt to theme
        $activePrimary = 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300';
        $idlePrimary   = 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800';
        
        $idleIcon      = 'text-gray-600 dark:text-gray-300';
        $activeIcon    = 'text-indigo-600 dark:text-indigo-300';
    @endphp

    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="{{ route('seller.dashboard') }}"
           class="{{ $linkBase }} {{ $is('seller.dashboard') ? $activePrimary : $idlePrimary }}">
            <x-icon-dashboard name="dashboard" class="mr-3 h-5 w-5 {{ $is('seller.dashboard') ? $activeIcon : $idleIcon }}" />
            Dashboard
        </a>

        <a href="{{ route('seller.products.index') }}"
           class="{{ $linkBase }} {{ $is('seller.products.*') ? $activePrimary : $idlePrimary }}">
            <x-icon-dashboard name="products" class="mr-3 h-5 w-5 {{ $is('seller.products.*') ? $activeIcon : $idleIcon }}" />
            Products
        </a>

        <a href="{{ route('seller.images.index') }}"
           class="{{ $linkBase }} {{ $is('seller.images.*') ? $activePrimary : $idlePrimary }}">
            <x-icon-nav name="images" class="mr-3 h-5 w-5 {{ $is('seller.images.*') ? $activeIcon : $idleIcon }}" />
            Image Gallery
        </a>

        <a href="{{ route('seller.orders.index') }}"
           class="{{ $linkBase }} {{ $is('seller.orders.*') ? $activePrimary : $idlePrimary }}">
            <x-icon-dashboard name="orders" class="mr-3 h-5 w-5 {{ $is('seller.orders.*') ? $activeIcon : $idleIcon }}" />
            Orders
        </a>

        <a href="{{ route('seller.earnings') }}" 
            class="{{ $linkBase }} {{ $is('seller.earnings') ? $activePrimary : $idlePrimary }}">
            <x-icon-nav name="wallet" class="mr-3 h-5 w-5 {{ $is('seller.earnings') ? $activeIcon : $idleIcon }}" />
            Earnings
        </a>

        <a href="{{ route('seller.reviews.index') }}"
           class="{{ $linkBase }} {{ $is('seller.reviews.*') ? $activePrimary : $idlePrimary }}">
            <x-icon-nav name="reviews" class="mr-3 h-5 w-5 {{ $is('seller.reviews.*') ? $activeIcon : $idleIcon }}" />
            Reviews
        </a>

        <a href="{{ route('seller.settings.edit') }}"
           class="{{ $linkBase }} {{ $is('seller.settings.edit') ? $activePrimary : $idlePrimary }}">
            <x-icon-nav name="settings" class="mr-3 h-5 w-5 {{ $is('seller.settings.edit') ? $activeIcon : $idleIcon }}" />
            Settings
        </a>
        
        <a href="{{ route('home') }}"
           class="{{ $linkBase }} text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 mt-8">
            <x-icon-dashboard name="back" class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-300" />
            Visit Store
        </a>
    </nav>

    <div class="mt-auto px-4 py-4 border-t border-gray-200 dark:border-gray-700">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center px-3 py-2 rounded-lg bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200 font-medium hover:bg-red-200 dark:hover:bg-red-800 transition">
                <x-icon-dashboard name="signout" class="h-5 w-5 text-red-500 dark:text-red-200 mr-2" />
                Logout
            </button>
        </form>
    </div>
</aside>