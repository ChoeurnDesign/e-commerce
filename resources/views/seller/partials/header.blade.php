@php
    $user = auth()->user();
    $seller = $user?->seller;
    $status = $seller?->status;
    $storeName = $seller?->store_name; 
    
    // Avatar logic: prefer user profile image, fallback to store logo, then initial
    $userAvatar = $user?->profile_image ? asset('storage/' . ltrim($user->profile_image,'/')) : null;
    $storeLogo = $seller?->store_logo_url;
    $displayAvatar = $userAvatar ?? $storeLogo;
    $initial = strtoupper(mb_substr($user?->name ?? 'U', 0, 1));
    
    // Logic for store name initials (e.g., "MyPhone Shop" -> "MPS")
    $storeInitials = 'S'; // Default value if no store name exists
    if ($storeName) {
        $words = explode(' ', $storeName);
        $initialsArray = array_map(function($word) {
            return mb_substr($word, 0, 1);
        }, $words);
        $storeInitials = strtoupper(implode('', $initialsArray));
    }

    $hasStorefront = $seller
        && $seller->slug
        && $status === 'approved'
        && Route::has('store.show');
@endphp

<header class="bg-gray-800 border-gray-700 shadow-sm flex items-center justify-between px-6 h-20 w-full z-20 relative">

    {{-- Left: Mobile toggle + welcome --}}
    <div class="flex items-center gap-3">
        <button id="mobileMenuButton"
                class="md:hidden p-2 rounded hover:bg-gray-700 transition focus:outline-none"
                aria-label="Toggle navigation">
            <svg class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8h16M4 16h16"/>
            </svg>
        </button>

        <div class="flex items-center gap-3">
            {{-- Store Logo / Placeholder Logic --}}
            @if($storeLogo)
                <img src="{{ $storeLogo }}"
                     alt="Store Logo"
                     class="w-10 h-10 rounded object-cover border border-indigo-500"
                     onerror="this.onerror=null;this.src='{{ asset('images/default-store.png') }}';">
            @else
                <div class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold text-sm border border-indigo-500">
                    {{ $storeInitials }}
                </div>
            @endif
            <span class="text-lg text-gray-100">
                Welcome, 
                @if($seller?->store_name)
                    {{ $seller->store_name }}
                @else
                    {{ $user->name }}
                @endif
                @if($seller && $status !== 'approved')
                    <span class="ml-2 text-xs px-2 py-0.5 rounded
                        @class([
                            'bg-amber-500/20 text-amber-400' => $status==='pending',
                            'bg-red-500/20 text-red-400'     => $status==='rejected',
                            'bg-gray-500/20 text-gray-300'   => !in_array($status,['pending','rejected','approved']),
                        ])">
                        {{ ucfirst($status) }}
                    </span>
                @endif
            </span>
        </div>
    </div>

    {{-- Right: Dark mode & seller-only dropdown --}}
    <div class="flex items-center gap-4">

        {{-- Chat Icon --}}
        <x-chat.chat-icon :route="route('seller.chat.index')" label="Seller Chat" :badge="$unreadSellerChats ?? 0" />
        
        {{-- Dark mode toggle (Alpine variable "dark") --}}
        <x-dark-mode-toggle />

        {{-- Seller Dropdown (NO general user links here) --}}
        <div x-data="{ open:false }" class="relative">
            <button @click="open=!open"
                    @keydown.escape.window="open=false"
                    class="flex items-center gap-2 focus:outline-none"
                    aria-haspopup="true"
                    :aria-expanded="open.toString()">

                @if($displayAvatar)
                    <img src="{{ $displayAvatar }}"
                         alt="Seller Avatar"
                         class="w-10 h-10 rounded-full border-2 border-indigo-400 object-cover"
                         onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';">
                @else
                    <span class="w-10 h-10 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">
                        {{ $initial }}
                    </span>
                @endif

                <svg class="w-4 h-4 text-gray-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <div x-cloak
                 x-show="open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.outside="open=false"
                 class="absolute right-0 mt-2 w-64 bg-gray-900 rounded-lg shadow-lg py-2 z-50 border border-gray-700"
                 style="display:none;">

                <div class="px-4 py-2 border-b border-gray-700 text-xs text-gray-400">
                    Seller Account<br>
                    <span class="text-gray-200 font-medium">{{ $user->email }}</span>
                </div>

                {{-- Seller-only navigation --}}
                <div class="py-1">
                    @if(Route::has('seller.dashboard'))
                        <x-dropdown-link :href="route('seller.dashboard')" class="flex items-center gap-2">
                            <x-icon-nav name="dashboard" class="w-5 h-5" />
                            Dashboard
                        </x-dropdown-link>
                    @endif

                    @if(Route::has('seller.products.index'))
                        <x-dropdown-link :href="route('seller.products.index')" class="flex items-center gap-2">
                            <x-icon-dashboard name="products" class="w-5 h-5" />
                            Products
                        </x-dropdown-link>
                    @endif

                    @if(Route::has('seller.orders.index'))
                        <x-dropdown-link :href="route('seller.orders.index')" class="flex items-center gap-2">
                            <x-icon-dashboard name="orders" class="w-5 h-5" />
                            Orders
                        </x-dropdown-link>
                    @endif

                    @if(Route::has('seller.customers.index'))
                        <x-dropdown-link :href="route('seller.customers.index')" class="flex items-center gap-2">
                            <x-icon-dashboard name="customers" class="w-5 h-5" />
                            Customers
                        </x-dropdown-link>
                    @endif

                    @if(Route::has('seller.analytics.index'))
                        <x-dropdown-link :href="route('seller.analytics.index')" class="flex items-center gap-2">
                            <x-icon-dashboard name="analytics" class="w-5 h-5" />
                            Analytics
                        </x-dropdown-link>
                    @endif

                    @if(Route::has('seller.settings.edit'))
                        <x-dropdown-link :href="route('seller.settings.edit')" class="flex items-center gap-2">
                            <x-icon-dashboard name="settings" class="w-5 h-5" />
                            Store Profile
                        </x-dropdown-link>
                    @endif

                    @if($hasStorefront)
                        <x-dropdown-link :href="route('store.show', $seller)" class="flex items-center gap-2">
                            <x-icon-dashboard name="store" class="w-5 h-5" />
                            View Storefront
                        </x-dropdown-link>
                    @endif
                </div>

                <div class="border-t border-gray-700 my-1"></div>

                {{-- Logout --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-800/40 flex items-center gap-2">
                        <x-icon-nav name="signout" class="w-5 h-5" />
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>