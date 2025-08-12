<x-nav-link :href="route('home')" :active="request()->routeIs('home')"
    class="text-sky-600 dark:text-white font-medium">
    <x-icon-nav name="home" class="w-5 h-5 mr-1" />
    {{ __('navigation.home') }}
</x-nav-link>

<x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')"
    class="text-sky-600 dark:text-white font-medium">
    <x-icon-nav name="products" class="w-5 h-5 mr-1" />
    {{ __('navigation.products') }}
</x-nav-link>

<x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')"
    class="text-sky-600 dark:text-white font-medium">
    <x-icon-nav name="categories" class="w-5 h-5 mr-1" />
    {{ __('navigation.categories') }}
</x-nav-link>

@auth
<x-nav-link :href="route('orders.history')" :active="request()->routeIs('orders.*')"
    class="text-sky-600 dark:text-white font-medium">
    <x-icon-nav name="orders" class="w-5 h-5 mr-1" />
    {{ __('navigation.orders') }}
</x-nav-link>
@endauth

<x-nav-link :href="route('about')" :active="request()->routeIs('about')"
    class="text-sky-600 dark:text-pink-300 font-medium">
    <x-icon-nav name="about" class="w-5 h-5 mr-1" />
    {{ __('navigation.about') }}
</x-nav-link>

<x-nav-link :href="route('contact')" :active="request()->routeIs('contact')"
    class="text-sky-600 dark:text-white font-medium">
    <x-icon-nav name="contact" class="w-5 h-5 mr-1" />
    {{ __('navigation.contact') }}
</x-nav-link>

@auth
    @if(auth()->user() && auth()->user()->role === 'admin')
        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
            <x-icon-nav name="dashboard" class="w-5 h-5 mr-1" />
            <span>{{ __('navigation.dashboard') }}</span>
        </x-nav-link>
    @endif
@endauth
