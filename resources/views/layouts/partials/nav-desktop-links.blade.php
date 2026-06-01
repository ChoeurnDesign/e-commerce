<div class="flex items-center gap-6 ml-4">
    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" 
        class="text-gray-600 hover:text-gray-900 flex items-center gap-2 text-sm font-semibold transition-colors border-b-2 {{ request()->routeIs('home') ? 'border-pink-500 text-gray-900' : 'border-transparent' }}">
        <x-icon-dashboard name="home" class="w-4 h-4 {{ request()->routeIs('home') ? 'text-pink-600' : 'text-gray-500' }}"/>
        Home
    </x-nav-link>

    <x-nav-link :href="route('stores.index')" :active="request()->routeIs('stores.index')" 
        class="text-gray-600 hover:text-gray-900 flex items-center gap-2 text-sm font-semibold transition-colors border-b-2 {{ request()->routeIs('stores.index') ? 'border-pink-500 text-gray-900' : 'border-transparent' }}">
        <x-icon-dashboard name="store" class="w-4 h-4 {{ request()->routeIs('stores.index') ? 'text-pink-600' : 'text-gray-500' }}"/>
        Store
    </x-nav-link>

    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" 
        class="text-gray-600 hover:text-gray-900 flex items-center gap-2 text-sm font-semibold transition-colors border-b-2 {{ request()->routeIs('products.*') ? 'border-pink-500 text-gray-900' : 'border-transparent' }}">
        <x-icon-dashboard name="products" class="w-4 h-4 {{ request()->routeIs('products.*') ? 'text-pink-600' : 'text-gray-500' }}"/>
        Products
    </x-nav-link>

    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')"
        class="text-gray-600 hover:text-gray-900 flex items-center gap-2 text-sm font-semibold transition-colors border-b-2 {{ request()->routeIs('categories.*') ? 'border-pink-500 text-gray-900' : 'border-transparent' }}">
        <x-icon-dashboard name="categories" class="w-4 h-4 {{ request()->routeIs('categories.*') ? 'text-pink-600' : 'text-gray-500' }}"/>
        Categories
    </x-nav-link>

    <a href="{{ route('products.shops_on_sale') }}"
       class="inline-flex items-center gap-1.5 px-1 pt-1 border-b-2 text-sm font-bold leading-5 transition duration-150 ease-in-out focus:outline-none
              {{ request()->routeIs('products.shops_on_sale')
                  ? 'text-rose-600 border-rose-500'
                  : 'text-rose-500 border-transparent hover:text-rose-600 hover:border-rose-300' }}">
        <x-icon-dashboard name="sale" class="w-4 h-4" />
        Sale
    </a>

    @auth
        <x-nav-link :href="route('orders.history')" :active="request()->routeIs('orders.*')" 
            class="text-gray-600 hover:text-gray-900 flex items-center gap-2 text-sm font-semibold transition-colors border-b-2 {{ request()->routeIs('orders.*') ? 'border-pink-500 text-gray-900' : 'border-transparent' }}">
            <x-icon-dashboard name="orders" class="w-4 h-4 {{ request()->routeIs('orders.*') ? 'text-pink-600' : 'text-gray-500' }}"/>
            Orders
        </x-nav-link>

        @if(auth()->user()->isAdmin())
            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" 
                class="text-pink-600 hover:text-pink-700 flex items-center gap-2 text-sm font-bold transition-colors border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-pink-500' : 'border-transparent' }}">
                <x-icon-dashboard name="dashboard" class="w-4 h-4 text-pink-600"/>
                Dashboard
            </x-nav-link>
        @elseif(auth()->user()->seller?->status === 'approved')
            <x-nav-link :href="route('seller.dashboard')"
                class="text-pink-600 hover:text-emerald-700 flex items-center gap-2 text-sm font-bold transition-colors border-b-2 border-transparent">
                <x-icon-dashboard name="dashboard" class="w-4 h-4 text-pink-600" />
                Seller
            </x-nav-link>
        @endif
    @endauth
</div>
