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
         class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

    <div class="relative bg-white w-full max-w-xs h-full shadow-2xl flex flex-col border-l border-gray-200">

        {{-- Header --}}
        <div class="p-4 border-b border-gray-200 flex justify-between items-center">
            <div class="flex items-center">
                @include('layouts.partials.nav-logo')
            </div>
            <button @click="mobileMenuOpen = false"
                    class="p-2 text-gray-400 hover:text-gray-900 transition-colors rounded-full hover:bg-gray-100">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>

        {{-- User info strip (authenticated only) --}}
        @auth
        <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex items-center gap-3">
            @php $mobileUser = Auth::user(); @endphp
            @if($mobileUser->profile_image && file_exists(public_path('storage/' . $mobileUser->profile_image)))
                <img src="{{ asset('storage/' . $mobileUser->profile_image) }}"
                     class="w-10 h-10 rounded-full object-cover border-2 border-pink-400 flex-shrink-0" />
            @else
                <span class="w-10 h-10 rounded-full bg-pink-500 text-white text-base font-semibold flex items-center justify-center flex-shrink-0 border-2 border-pink-400">
                    {{ strtoupper(substr($mobileUser->name ?? 'U', 0, 1)) }}
                </span>
            @endif
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">{{ $mobileUser->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ $mobileUser->email }}</p>
            </div>
        </div>
        @endauth

        {{-- Scrollable links --}}
        <div class="flex-1 overflow-y-auto py-3">
            <div class="px-3 space-y-0.5">

                {{-- Main navigation --}}
                <p class="px-3 pt-2 pb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">Browse</p>

                <a href="{{ route('home') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('home') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <x-icon-dashboard name="home" class="w-5 h-5 flex-shrink-0" />
                    <span>Home</span>
                </a>

                <a href="{{ route('products.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('products.*') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <x-icon-nav name="products" class="w-5 h-5 flex-shrink-0" />
                    <span>Products</span>
                </a>

                <a href="{{ route('categories.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('categories.*') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <x-icon-nav name="categories" class="w-5 h-5 flex-shrink-0" />
                    <span>Categories</span>
                </a>

                <a href="{{ route('stores.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('stores.*') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <x-icon-dashboard name="store" class="w-5 h-5 flex-shrink-0" />
                    <span>Stores</span>
                </a>

                <a href="{{ route('products.shops_on_sale') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-bold transition-all
                          {{ request()->routeIs('products.shops_on_sale')
                              ? 'bg-rose-100 text-rose-600'
                              : 'bg-rose-50 text-rose-500 hover:bg-rose-100' }}">
                    <x-icon-dashboard name="sale" class="w-5 h-5 flex-shrink-0" />
                    <span>Sale — Hot Deals</span>
                    <span class="ml-auto text-[10px] font-extrabold bg-rose-500 text-white px-1.5 py-0.5 rounded-full uppercase tracking-wide">New</span>
                </a>

                @auth
                {{-- Account links --}}
                <div class="mt-3 pt-2 border-t border-gray-100">
                    <p class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">Account</p>
                </div>

                <a href="{{ route('orders.history') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium transition-all
                          {{ request()->routeIs('orders.*') ? 'bg-pink-50 text-pink-600' : 'text-gray-700 hover:bg-gray-100' }}">
                    <x-icon-dashboard name="orders" class="w-5 h-5 flex-shrink-0" />
                    <span class="flex-1">Orders</span>
                </a>

                <a href="{{ route('cart.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <x-icon-dashboard name="cart" class="w-5 h-5 flex-shrink-0" />
                    <span class="flex-1">Cart</span>
                    @if(($cartCount ?? 0) > 0)
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5">{{ $cartCount }}</span>
                    @endif
                </a>

                <a href="{{ route('wishlist.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <x-icon-dashboard name="wishlist" class="w-5 h-5 flex-shrink-0" />
                    <span class="flex-1">Wishlist</span>
                    @if(($wishlistCount ?? 0) > 0)
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5">{{ $wishlistCount }}</span>
                    @endif
                </a>

                <a href="{{ route('chat.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <x-icon-dashboard name="chat" class="w-5 h-5 flex-shrink-0" />
                    <span class="flex-1">Messages</span>
                    @if(($unreadUserChats ?? 0) > 0)
                    <span class="bg-pink-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5">{{ $unreadUserChats }}</span>
                    @endif
                </a>

                <a href="{{ route('notifications.index') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <x-icon-dashboard name="notification" class="w-5 h-5 flex-shrink-0" />
                    <span class="flex-1">Notifications</span>
                    @php $mobileNotifCount = auth()->user()->unreadNotifications->count(); @endphp
                    @if($mobileNotifCount > 0)
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5">{{ $mobileNotifCount > 9 ? '9+' : $mobileNotifCount }}</span>
                    @endif
                </a>

                <a href="{{ route('profile.edit') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <x-icon-dashboard name="profile" class="w-5 h-5 flex-shrink-0" />
                    <span>Profile</span>
                </a>

                {{-- Seller Dashboard / Application Status --}}
                @php $mobileSeller = auth()->user()->seller; @endphp
                @if($mobileSeller?->status === 'approved')
                <a href="{{ route('seller.dashboard') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-semibold bg-green-50 text-green-600 hover:bg-green-100 transition-all mt-1">
                    <x-icon-dashboard name="dashboard" class="w-5 h-5 flex-shrink-0" />
                    <span>Seller Dashboard</span>
                </a>
                @elseif($mobileSeller?->status === 'pending')
                <a href="{{ route('seller.register.form') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-semibold bg-amber-50 text-amber-600 hover:bg-amber-100 transition-all mt-1">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Application Pending</span>
                </a>
                @endif

                {{-- Admin Panel --}}
                @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}"
                   @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-semibold bg-purple-50 text-purple-600 hover:bg-purple-100 transition-all mt-1">
                    <x-icon-nav name="admin" class="w-5 h-5 flex-shrink-0" />
                    <span>Admin Panel</span>
                </a>
                @endif

                {{-- More links --}}
                <div class="mt-3 pt-2 border-t border-gray-100">
                    <p class="px-3 pb-1 text-[10px] font-bold uppercase tracking-wider text-gray-400">More</p>
                </div>

                <a href="{{ route('about') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <x-icon-dashboard name="about" class="w-5 h-5 flex-shrink-0" />
                    <span>About Us</span>
                </a>

                <a href="{{ route('contact') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <x-icon-dashboard name="contact" class="w-5 h-5 flex-shrink-0" />
                    <span>Contact</span>
                </a>

                <a href="{{ route('faq') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>FAQ</span>
                </a>

                <a href="{{ route('help') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Help Center</span>
                </a>

                @else
                {{-- Guest browse links --}}
                {{-- Sell on ShopExpress --}}
                <a href="{{ route('seller.landing') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-semibold bg-pink-50 text-pink-600 hover:bg-pink-100 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Sell on {{ setting('store_name', 'ShopExpress') }}</span>
                </a>

                <a href="{{ route('about') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <x-icon-dashboard name="about" class="w-5 h-5 flex-shrink-0" />
                    <span>About Us</span>
                </a>
                <a href="{{ route('contact') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <x-icon-dashboard name="contact" class="w-5 h-5 flex-shrink-0" />
                    <span>Contact</span>
                </a>
                <a href="{{ route('faq') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>FAQ</span>
                </a>
                <a href="{{ route('help') }}" @click="mobileMenuOpen = false"
                   class="flex items-center gap-3 py-2.5 px-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-100 transition-all">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Help Center</span>
                </a>
                @endauth

            </div>
        </div>

        {{-- Footer action --}}
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center justify-center gap-3 w-full px-4 py-3 text-red-600 font-semibold bg-red-50 hover:bg-red-100 rounded-xl transition-all text-sm">
                        <x-icon-nav name="signout" class="w-5 h-5 flex-shrink-0" />
                        <span>Sign Out</span>
                    </button>
                </form>
            @else
                <div class="flex flex-col gap-2">
                    <a href="{{ route('login') }}"
                       @click="mobileMenuOpen = false"
                       class="w-full py-3 px-4 text-center rounded-xl bg-gray-100 text-gray-900 font-medium text-sm hover:bg-gray-200 transition-all">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                       @click="mobileMenuOpen = false"
                       class="w-full py-3 px-4 text-center rounded-xl bg-pink-500 hover:bg-pink-600 text-white font-semibold text-sm shadow transition-all">
                        Get Started Free
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>

