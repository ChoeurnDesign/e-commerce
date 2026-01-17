<div x-show="mobileMenuOpen" 
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 transform -translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform -translate-y-2"
     @click.stop
     x-cloak
     class="lg:hidden fixed top-0 left-0 w-full h-full bg-gray-800 dark:bg-gray-900 z-40 pt-20">
    
    <!-- Close button overlay -->
    <div @click="mobileMenuOpen = false" class="absolute inset-0 bg-black bg-opacity-50"></div>
    
    <!-- Menu content -->
    <div class="relative bg-gray-800 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg">
        <div class="px-2 py-3 space-y-2">
            <!-- Mobile Navigation Links -->
            <x-responsive-nav-link :href="route('home')" 
                                  :active="request()->routeIs('home')" 
                                  @click="mobileMenuOpen = false"
                                  class="text-gray-300 font-medium block">
                <x-icon-nav name="home" />
                Home
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('products.index')" 
                                  :active="request()->routeIs('products.*')" 
                                  @click="mobileMenuOpen = false"
                                  class="text-gray-300 font-medium block">
                <x-icon-nav name="products" />
                Products
            </x-responsive-nav-link>
            
            <x-responsive-nav-link :href="route('categories.index')" 
                                  :active="request()->routeIs('categories.*')" 
                                  @click="mobileMenuOpen = false"
                                  class="text-gray-300 font-medium block">
                <x-icon-nav name="categories" />
                Categories
            </x-responsive-nav-link>
            
            @auth
                <x-responsive-nav-link :href="route('orders.history')" 
                                      @click="mobileMenuOpen = false"
                                      class="text-gray-300 font-medium block">
                    <x-icon-nav name="orders" />
                    Orders
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('about')" 
                                      @click="mobileMenuOpen = false"
                                      class="text-gray-300 font-medium block">
                    <x-icon-nav name="about" />
                    About
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('contact')" 
                                      @click="mobileMenuOpen = false"
                                      class="text-gray-300 font-medium block">
                    <x-icon-nav name="contact" />
                    Contact
                </x-responsive-nav-link>
                
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" 
                                          @click="mobileMenuOpen = false"
                                          class="text-gray-300 font-medium block">
                        <x-icon-nav name="admin" />
                        Admin
                    </x-responsive-nav-link>
                @endif
                
                <hr class="my-2 border-gray-200 dark:border-gray-700">
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" 
                                          @click="event.preventDefault(); this.closest('form').submit(); mobileMenuOpen = false;" 
                                          class="text-gray-300 flex font-medium">
                        <x-icon-nav name="signout" />
                        Sign Out
                    </x-responsive-nav-link>
                </form>
            @else
                <x-responsive-nav-link :href="route('orders.history')" 
                                      @click="mobileMenuOpen = false"
                                      class="text-gray-300 font-medium block">
                    <x-icon-nav name="orders" />
                    Orders
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('about')" 
                                      @click="mobileMenuOpen = false"
                                      class="text-gray-300 font-medium block">
                    <x-icon-nav name="about" />
                    About
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('contact')" 
                                      @click="mobileMenuOpen = false"
                                      class="text-gray-300 font-medium block">
                    <x-icon-nav name="contact" />
                    Contact
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('login')" 
                                      @click="mobileMenuOpen = false"
                                      class="text-gray-300 font-medium block">
                    <x-icon-nav name="login" />
                    Sign In
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('register')" 
                                      @click="mobileMenuOpen = false"
                                      class="text-gray-300 font-medium block">
                    <x-icon-nav name="register" />
                    Get Started
                </x-responsive-nav-link>
            @endauth
        </div>
    </div>
</div>