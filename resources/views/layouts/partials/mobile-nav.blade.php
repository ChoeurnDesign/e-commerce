<div x-show="mobileMenuOpen" x-transition class="md:hidden fixed w-full bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg">
    <div class="px-2 py-3 space-y-2">
        <!-- Mobile Navigation Links -->
        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')" class="text-indigo-600 dark:text-indigo-300 hover:text-indigo-700 dark:hover:text-indigo-400">
            <x-icon-nav name="home" class="w-5 h-5 mr-2" />
            Home
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')" class="text-blue-600 dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-400">
            <x-icon-nav name="products" class="w-5 h-5 mr-2" />
            Products
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" class="text-yellow-600 dark:text-yellow-300 hover:text-yellow-700 dark:hover:text-yellow-400">
            <x-icon-nav name="categories" class="w-5 h-5 mr-2" />
            Categories
        </x-responsive-nav-link>
        @auth
            <x-responsive-nav-link :href="route('orders.history')" class="text-amber-700 dark:text-amber-300 hover:text-amber-800 dark:hover:text-amber-400">
                <x-icon-nav name="orders" class="w-5 h-5 mr-2" />
                Orders
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" class="text-blue-600 dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-400">
                <x-icon-nav name="about" class="w-5 h-5 mr-2" />
                About
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" class="text-cyan-600 dark:text-cyan-300 hover:text-cyan-700 dark:hover:text-cyan-400">
                <x-icon-nav name="contact" class="w-5 h-5 mr-2" />
                Contact
            </x-responsive-nav-link>
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" class="text-indigo-600 dark:text-indigo-300 hover:text-indigo-700 dark:hover:text-indigo-400">
                    <x-icon-nav name="admin" class="w-5 h-5 mr-2" />
                    Admin
                </x-responsive-nav-link>
            @endif
            <hr class="my-2 border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 dark:text-red-400 hover:text-orange-600 dark:hover:text-orange-400">
                    <x-icon-nav name="signout" class="w-5 h-5 mr-2" />
                    Sign Out
                </x-responsive-nav-link>
            </form>
        @else
            <x-responsive-nav-link :href="route('orders.history')" class="text-amber-700 dark:text-amber-300 hover:text-amber-800 dark:hover:text-amber-400">
                <x-icon-nav name="orders" class="w-5 h-5 mr-2" />
                Orders
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('about')" class="text-blue-600 dark:text-blue-300 hover:text-blue-700 dark:hover:text-blue-400">
                <x-icon-nav name="about" class="w-5 h-5 mr-2" />
                About
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contact')" class="text-cyan-600 dark:text-cyan-300 hover:text-cyan-700 dark:hover:text-cyan-400">
                <x-icon-nav name="contact" class="w-5 h-5 mr-2" />
                Contact
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('login')" class="text-indigo-600 dark:text-indigo-300 hover:text-indigo-700 dark:hover:text-indigo-400">
                <x-icon-nav name="login" class="w-5 h-5 mr-2" />
                Sign In
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('register')" class="text-purple-600 dark:text-purple-300 hover:text-purple-700 dark:hover:text-purple-400">
                <x-icon-nav name="register" class="w-5 h-5 mr-2" />
                Get Started
            </x-responsive-nav-link>
        @endauth
    </div>
</div>
