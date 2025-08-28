<x-nav-link :href="route('home')" :active="request()->routeIs('home')"
    class="text-gray-300 font-medium">
    <x-icon-nav name="home"/>
    home
</x-nav-link>

<x-nav-link :href="route('stores.index')" :active="request()->routeIs('stores.index')"
    class="text-gray-300 font-medium">
    <x-icon-nav name="store"/>
    store
</x-nav-link>

<x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')"
    class="text-gray-300 font-medium">
    <x-icon-nav name="products"/>
    products
</x-nav-link>

<x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')"
    class="text-gray-300 font-medium">
    <x-icon-nav name="categories"/>
    categories
</x-nav-link>

@auth
<x-nav-link :href="route('orders.history')" :active="request()->routeIs('orders.*')"
    class="text-gray-300 font-medium">
    <x-icon-nav name="orders"/>
    orders
</x-nav-link>
@endauth

<x-nav-link :href="route('about')" :active="request()->routeIs('about')"
    class="text-gray-300 font-medium">
    <x-icon-nav name="about"/>
    about
</x-nav-link>

<x-nav-link :href="route('contact')" :active="request()->routeIs('contact')"
    class="text-gray-300 font-medium">
    <x-icon-nav name="contact"/>
    contact
</x-nav-link>

@auth
    @if(auth()->user() && auth()->user()->role === 'admin')
        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
            class="text-gray-300 font-medium">
            <x-icon-nav name="dashboard"/>
            <span>dashboard</span>
        </x-nav-link>
    @endif

    @if(auth()->user()->role === 'seller')
        <x-nav-link :href="route('seller.dashboard')"
            class="text-gray-300 hover:text-gray-200 flex items-center font-medium">
            <x-icon-nav name="dashboard" class="w-5 h-5 mr-2" />
            Seller Dashboard
        </x-nav-link>
    @endif
@endauth
