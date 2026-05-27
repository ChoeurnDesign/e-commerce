<div class="flex items-center gap-6 ml-4">
    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" 
        class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white flex items-center gap-2 text-sm font-semibold transition-colors border-b-2 {{ request()->routeIs('home') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent' }}">
        <x-icon-dashboard name="home" class="w-4 h-4 {{ request()->routeIs('home') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400' }}"/>
        Home
    </x-nav-link>

    <x-nav-link :href="route('stores.index')" :active="request()->routeIs('stores.index')" 
        class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white flex items-center gap-2 text-sm font-semibold transition-colors border-b-2 {{ request()->routeIs('stores.index') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent' }}">
        <x-icon-dashboard name="store" class="w-4 h-4 {{ request()->routeIs('stores.index') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400' }}"/>
        Store
    </x-nav-link>

    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" 
        class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white flex items-center gap-2 text-sm font-semibold transition-colors border-b-2 {{ request()->routeIs('products.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent' }}">
        <x-icon-dashboard name="products" class="w-4 h-4 {{ request()->routeIs('products.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400' }}"/>
        Products
    </x-nav-link>

    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" 
        class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white flex items-center gap-2 text-sm font-semibold transition-colors border-b-2 {{ request()->routeIs('categories.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent' }}">
        <x-icon-dashboard name="categories" class="w-4 h-4 {{ request()->routeIs('categories.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400' }}"/>
        Categories
    </x-nav-link>

    @auth
        <x-nav-link :href="route('orders.history')" :active="request()->routeIs('orders.*')" 
            class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white flex items-center gap-2 text-sm font-semibold transition-colors border-b-2 {{ request()->routeIs('orders.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent' }}">
            <x-icon-dashboard name="orders" class="w-4 h-4 {{ request()->routeIs('orders.*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-500 dark:text-gray-400' }}"/>
            Orders
        </x-nav-link>

        @if(auth()->user()->isAdmin())
            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" 
                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 flex items-center gap-2 text-sm font-bold transition-colors border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-indigo-500' : 'border-transparent' }}">
                <x-icon-dashboard name="dashboard" class="w-4 h-4 text-indigo-600 dark:text-indigo-400"/>
                Dashboard
            </x-nav-link>
        @elseif(auth()->user()->role === 'seller')
            <x-nav-link :href="route('seller.dashboard')" 
                class="text-indigo-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 flex items-center gap-2 text-sm font-bold transition-colors border-b-2 border-transparent">
                <x-icon-dashboard name="dashboard" class="w-4 h-4 text-indigo-600 dark:text-emerald-400" />
                Seller
            </x-nav-link>
        @endif
    @endauth
</div>