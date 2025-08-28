<div x-show="mobileMenuOpen" x-transition class="md:hidden fixed w-full bg-[#181f31] dark:bg-[#181f31] border-t border-gray-200 dark:border-gray-700 shadow-lg">
    <div class="px-2 py-3 space-y-2">
        <!-- Mobile Navigation Links -->
        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-gray-300 font-medium">
            <x-icon-nav name="home" />
            Home
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-gray-300 font-medium">
            <x-icon-nav name="products" />
            Products
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="text-gray-300 font-medium">
            <x-icon-nav name="categories" />
            Categories
        </x-responsive-nav-link>
        @auth
            <x-responsive-nav-link :href="route('orders.history')" class="text-gray-300 font-medium">
                <x-icon-nav name="orders" />
                Orders
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" class="text-gray-300 font-medium">
                <x-icon-nav name="about" />
                About
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" class="text-gray-300 font-medium">
                <x-icon-nav name="contact" />
                Contact
            </x-responsive-nav-link>
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" class="text-gray-300 font-medium">
                    <x-icon-nav name="admin" />
                    Admin
                </x-responsive-nav-link>
            @endif
            <hr class="my-2 border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-300 flex font-medium">
                    <x-icon-nav name="signout" />
                    Sign Out
                </x-responsive-nav-link>
            </form>
        @else
            <x-responsive-nav-link :href="route('orders.history')" class="text-gray-300 font-medium">
                <x-icon-nav name="orders" />
                Orders
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" class="text-gray-300 font-medium">
                <x-icon-nav name="about" />
                About
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" class="text-gray-300 font-medium">
                <x-icon-nav name="contact" />
                Contact
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('login')" class="text-gray-300 font-medium">
                <x-icon-nav name="login" />
                Sign In
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')" class="text-gray-300 font-medium">
                <x-icon-nav name="register" />
                Get Started
            </x-responsive-nav-link>
        @endauth
    </div>
</div>
