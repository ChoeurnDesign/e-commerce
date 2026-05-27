<div x-show="mobileMenuOpen"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="translate-x-full"
     x-transition:enter-end="translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="translate-x-0"
     x-transition:leave-end="translate-x-full"
     @keydown.window.escape="mobileMenuOpen = false"
     x-cloak
     class="lg:hidden fixed inset-0 z-[100] flex justify-end">

    {{-- Backdrop --}}
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false"
         class="fixed inset-0 bg-black/60 dark:bg-black/80 backdrop-blur-sm"></div>

    <div class="relative bg-white dark:bg-gray-900 w-full max-w-xs h-full shadow-2xl flex flex-col border-l border-gray-200 dark:border-gray-800">

        {{-- Header --}}
        <div class="p-4 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center">
            <div class="flex items-center">
                @include('layouts.partials.nav-logo')
            </div>
            <button @click="mobileMenuOpen = false"
                    class="p-2 text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        {{-- User info strip (authenticated only) --}}
        @auth
        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-800/60 border-b border-gray-200 dark:border-gray-800 flex items-center gap-3">
            @php $mobileUser = Auth::user(); @endphp
            @if($mobileUser->profile_image && file_exists(public_path('storage/' . $mobileUser->profile_image)))
                <img src="{{ asset('storage/' . $mobileUser->profile_image) }}"
                     class="w-10 h-10 rounded-full object-cover border-2 border-indigo-400 flex-shrink-0" />
            @else
                <span class="w-10 h-10 rounded-full bg-indigo-600 text-white text-base font-semibold flex items-center justify-center flex-shrink-0 border-2 border-indigo-400">
                    {{ strtoupper(substr($mobileUser->name ?? 'U', 0, 1)) }}
                </span>
            @endif
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $mobileUser->name }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $mobileUser->email }}</p>
            </div>
        </div>
        @endauth

        {{-- Scrollable links --}}
        <div class="flex-1 overflow-y-auto py-3">
            <div class="px-3 space-y-0.5">

                {{-- Main navigation --}}
                <p class="px-3 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Browse</p>

                <a href="{{ route('home') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('home') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <x-icon-dashboard name="home" class="w-5 h-5 flex-shrink-0" />
                    <span>Home</span>
                </a>

                <a href="{{ route('products.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('products.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <x-icon-nav name="products" class="w-5 h-5 flex-shrink-0" />
                    <span>Products</span>
                </a>

                <a href="{{ route('categories.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('categories.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <x-icon-nav name="categories" class="w-5 h-5 flex-shrink-0" />
                    <span>Categories</span>
                </a>

                <a href="{{ route('stores.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('stores.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <x-icon-dashboard name="store" class="w-5 h-5 flex-shrink-0" />
                    <span>Stores</span>
                </a>

                @auth
                {{-- Account links --}}
                <div class="mt-3 pt-2 border-t border-gray-100 dark:border-gray-800">
                    <p class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Account</p>
                </div>

                <a href="{{ route('orders.history') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('orders.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                    <x-icon-dashboard name="orders" class="w-5 h-5 flex-shrink-0" />
                    <span class="flex-1">Orders</span>
                </a>

                <a href="{{ route('cart.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <x-icon-dashboard name="cart" class="w-5 h-5 flex-shrink-0" />
                    <span class="flex-1">Cart</span>
                    @if(($cartCount ?? 0) > 0)
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5">{{ $cartCount }}</span>
                    @endif
                </a>

                <a href="{{ route('wishlist.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <x-icon-dashboard name="wishlist" class="w-5 h-5 flex-shrink-0" />
                    <span class="flex-1">Wishlist</span>
                    @if(($wishlistCount ?? 0) > 0)
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5">{{ $wishlistCount }}</span>
                    @endif
                </a>

                <a href="{{ route('chat.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <x-icon-dashboard name="chat" class="w-5 h-5 flex-shrink-0" />
                    <span class="flex-1">Messages</span>
                    @if(($unreadUserChats ?? 0) > 0)
                    <span class="bg-indigo-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5">{{ $unreadUserChats }}</span>
                    @endif
                </a>

                <a href="{{ route('notifications.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <x-icon-dashboard name="notification" class="w-5 h-5 flex-shrink-0" />
                    <span class="flex-1">Notifications</span>
                    @php $mobileNotifCount = auth()->user()->unreadNotifications->count(); @endphp
                    @if($mobileNotifCount > 0)
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5">{{ $mobileNotifCount > 9 ? '9+' : $mobileNotifCount }}</span>
                    @endif
                </a>

                <a href="{{ route('profile.edit') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <x-icon-dashboard name="profile" class="w-5 h-5 flex-shrink-0" />
                    <span>Profile</span>
                </a>

                {{-- Seller Dashboard --}}
                @if(auth()->user()->role === 'seller')
                <a href="{{ route('seller.dashboard') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-semibold bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-all mt-1">
                    <x-icon-dashboard name="dashboard" class="w-5 h-5 flex-shrink-0" />
                    <span>Seller Dashboard</span>
                </a>
                @endif

                {{-- Admin Panel --}}
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-semibold bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400 hover:bg-purple-100 dark:hover:bg-purple-900/40 transition-all mt-1">
                    <x-icon-nav name="admin" class="w-5 h-5 flex-shrink-0" />
                    <span>Admin Panel</span>
                </a>
                @endif

                {{-- More links --}}
                <div class="mt-3 pt-2 border-t border-gray-100 dark:border-gray-800">
                    <p class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">More</p>
                </div>

                <a href="{{ route('about') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <x-icon-dashboard name="about" class="w-5 h-5 flex-shrink-0" />
                    <span>About Us</span>
                </a>

                <a href="{{ route('contact') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <x-icon-dashboard name="contact" class="w-5 h-5 flex-shrink-0" />
                    <span>Contact</span>
                </a>

                <a href="{{ route('faq') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>FAQ</span>
                </a>

                <a href="{{ route('help') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Help Center</span>
                </a>

                @else
                {{-- Guest browse links --}}
                {{-- Sell on ShopExpress --}}
                @if(!auth()->user() || auth()->user()->role !== 'seller')
                <a href="{{ route('seller.landing') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-semibold bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Sell on {{ setting('store_name', 'ShopExpress') }}</span>
                </a>
                @endif

                <a href="{{ route('about') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <x-icon-dashboard name="about" class="w-5 h-5 flex-shrink-0" />
                    <span>About Us</span>
                </a>
                <a href="{{ route('contact') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <x-icon-dashboard name="contact" class="w-5 h-5 flex-shrink-0" />
                    <span>Contact</span>
                </a>
                <a href="{{ route('faq') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>FAQ</span>
                </a>
                <a href="{{ route('help') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Help Center</span>
                </a>
                @endauth

            </div>
        </div>

        {{-- Footer action --}}
        <div class="p-4 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/50">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center justify-center gap-3 w-full px-4 py-3 text-red-600 dark:text-red-400 font-semibold bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-xl transition-all text-sm">
                        <x-icon-nav name="signout" class="w-5 h-5 flex-shrink-0" />
                        <span>Sign Out</span>
                    </button>
                </form>
            @else
                <div class="flex flex-col gap-2">
                    <a href="{{ route('login') }}"
                       @click="mobileMenuOpen = false"
                       class="w-full py-3 px-4 text-center rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white font-medium text-sm hover:bg-gray-200 dark:hover:bg-gray-700 transition-all">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       @click="mobileMenuOpen = false"
                       class="w-full py-3 px-4 text-center rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow transition-all">
                        Get Started Free
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
