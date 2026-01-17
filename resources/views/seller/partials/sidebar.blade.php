<aside class="w-64 bg-gray-900 flex-shrink-0 hidden md:flex flex-col border-r border-gray-700 shadow-lg transition-colors duration-300 z-10 relative">
    <div class="flex items-center justify-center h-20 border-b border-gray-700">
        <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset($settings['store_logo'] ?? 'images/logo.png') }}" alt="Store Logo" class="w-10 h-10 rounded-full object-cover">
            <span class="text-xl font-bold text-indigo-400 tracking-wide">Seller Panel</span>
        </a>
    </div>

    @php
        $is = fn(...$names) => request()->routeIs($names);
        $linkBase = 'flex items-center px-3 py-2 rounded-lg transition font-medium';
        $activePrimary = 'bg-indigo-900 text-indigo-300';
        $idlePrimary   = 'text-gray-200 hover:bg-gray-800';
        $idleIcon      = 'text-gray-300';
        $activeIcon    = 'text-indigo-300';
    @endphp

    <nav class="flex-1 px-4 py-6 space-y-2">

        {{-- Dashboard --}}
        <a href="{{ route('seller.dashboard') }}"
           class="{{ $linkBase }} {{ $is('seller.dashboard') ? $activePrimary : $idlePrimary }}">
            <x-icon-nav name="dashboard" class="mr-3 h-5 w-5 {{ $is('seller.dashboard') ? $activeIcon : $idleIcon }}" />
            Dashboard
        </a>

        {{-- Products --}}
        <a href="{{ route('seller.products.index') }}"
           class="{{ $linkBase }} {{ $is('seller.products.*') ? $activePrimary : $idlePrimary }}">
            <x-icon-dashboard name="products" class="mr-3 h-5 w-5 {{ $is('seller.products.*') ? $activeIcon : $idleIcon }}" />
            Products
        </a>

        {{-- Image Gallery --}}
        <a href="{{ route('seller.images.index') }}"
           class="{{ $linkBase }} {{ $is('seller.images.*') ? $activePrimary : $idlePrimary }}">
            <x-icon-dashboard name="images" class="mr-3 h-5 w-5 {{ $is('seller.images.*') ? $activeIcon : $idleIcon }}" />
            Image Gallery
        </a>

        {{-- Orders --}}
        <a href="{{ route('seller.orders.index') }}"
           class="{{ $linkBase }} {{ $is('seller.orders.*') ? $activePrimary : $idlePrimary }}">
            <x-icon-dashboard name="orders" class="mr-3 h-5 w-5 {{ $is('seller.orders.*') ? $activeIcon : $idleIcon }}" />
            Orders
        </a>

        {{-- Reviews (new) --}}
        <a href="{{ route('seller.reviews.index') }}"
           class="{{ $linkBase }} {{ $is('seller.reviews.*') ? $activePrimary : $idlePrimary }}">
            <x-icon-dashboard name="reviews" class="mr-3 h-5 w-5 {{ $is('seller.reviews.*') ? $activeIcon : $idleIcon }}" />
            Reviews
        </a>

        {{-- Settings --}}
        <a href="{{ route('seller.settings.edit') }}"
           class="{{ $linkBase }} {{ $is('seller.settings.edit') ? $activePrimary : $idlePrimary }}">
            <x-icon-dashboard name="settings" class="mr-3 h-5 w-5 {{ $is('seller.settings.edit') ? $activeIcon : $idleIcon }}" />
            Settings
        </a>
        <a href="{{ route('home') }}"
           class="{{ $linkBase }} text-gray-300 dark:text-gray-200 hover:bg-gray-700 dark:hover:bg-[#23263a] hover:text-white flex items-center px-4 py-2 text-sm font-medium rounded-md mt-8 transition-colors">
            <x-icon-nav name="back" class="mr-3 h-5 w-5 text-gray-300 dark:text-gray-200" />
            Visit Store
        </a>
    </nav>

    <div class="mt-auto px-4 py-4 border-t border-gray-700">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center px-3 py-2 rounded-lg bg-red-900 text-red-200 font-medium hover:bg-red-700 transition">
                <x-icon-nav name="signout" class="h-5 w-5 text-red-200 mr-2" />
                Logout
            </button>
        </form>
    </div>
</aside>