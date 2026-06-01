@php
    $navSearchCats = \App\Models\Category::active()->orderBy('name')->get(['id','name','slug']);
@endphp

{{-- ══════════════════════════════════════════════════════════════
     SINGLE ROW NAV — Logo · Search · Actions
     Height: h-16 = 64px  (quick-nav uses sticky top: 64px)
══════════════════════════════════════════════════════════════ --}}
<div class="flex items-center h-14 px-6 sm:px-10 lg:px-16 gap-4">

    {{-- Logo --}}
    @include('layouts.partials.nav-logo')

    {{-- ── Search bar (desktop) ─────────────────────────────── --}}
    <form method="GET" action="{{ route('products.index') }}"
          class="hidden lg:flex flex-1 max-w-2xl mx-4 items-stretch h-10
                 bg-white rounded-full overflow-hidden
                 border border-gray-300 shadow-sm
                 focus-within:border-orange-400 focus-within:shadow-md
                 transition-all duration-200">

        {{-- Category select --}}
        <select name="category"
                class="bg-transparent text-gray-600 text-sm px-3
                       border-0 border-r border-gray-200
                       outline-none focus:outline-none focus:ring-0 cursor-pointer shrink-0 max-w-[148px]">
            <option value="">All Categories</option>
            @foreach($navSearchCats as $nc)
                <option value="{{ $nc->slug }}" {{ request('category') === $nc->slug ? 'selected' : '' }}>
                    {{ $nc->name }}
                </option>
            @endforeach
        </select>

        {{-- Text input --}}
        <input type="text" name="search"
               value="{{ request('search') }}"
               placeholder="{{ __('Search products, brands or stores...') }}"
               class="flex-1 px-4 text-sm text-gray-900
                      bg-transparent placeholder-gray-400
                      border-0 outline-none focus:outline-none focus:ring-0 min-w-0" />

        {{-- Orange Search button --}}
        <button type="submit"
                class="px-5 h-10 flex items-center gap-2 font-semibold text-white text-sm
                       bg-orange-500 hover:bg-orange-600 transition-colors flex-shrink-0
                       rounded-r-full">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            {{ __('Search') }}
        </button>
    </form>

    {{-- ── Mobile: search toggle + cart + menu ──────────────── --}}
    <div class="flex items-center gap-1 ml-auto lg:hidden">
        <button @click="openSearch = !openSearch"
                class="p-2 rounded-lg text-gray-500
                       hover:bg-gray-100 transition-colors">
            <svg x-show="!openSearch" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <svg x-show="openSearch" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <a href="{{ route('cart.index') }}"
           class="relative p-2 text-gray-500 hover:text-orange-500 rounded-lg
                  hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            @auth @if(($cartCount ?? 0) > 0)
            <span class="absolute -top-0.5 -right-0.5 bg-orange-500 text-white text-[10px] font-bold
                         rounded-full min-w-[16px] h-4 flex items-center justify-center px-1 leading-none">
                {{ ($cartCount ?? 0) > 9 ? '9+' : ($cartCount ?? 0) }}
            </span>
            @endif @endauth
        </a>
        <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="p-2 rounded-lg text-gray-500
                       hover:bg-gray-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- ── Desktop right actions ──────────────────────────────── --}}
    @php $isSeller = auth()->check() && auth()->user()->isSeller(); @endphp
    <div class="hidden lg:flex items-center gap-0.5 ml-auto shrink-0">

        {{-- Seller Dashboard (if seller) OR Become a Seller (if not) --}}
        @if($isSeller)
            <x-nav-icon-link :href="route('seller.dashboard')" :label="__('Dashboard')" icon="dashboard" />
        @else
            <x-nav-icon-link :href="route('seller.landing')" :label="__('Become a Seller')" icon="seller" />
        @endif

        @auth
            <x-nav-icon-link :href="route('chat.index')" :label="__('Messages')" icon="chat" :count="$unreadUserChats ?? 0" />
            <x-nav-icon-link :href="route('orders.history')" :label="__('Orders')" icon="orders" />
            <x-nav-icon-link :href="route('wishlist.index')" :label="__('Wishlist')" icon="wishlist" :count="$wishlistCount ?? 0" />
        @endauth

        <x-nav-icon-link :href="route('cart.index')" :label="__('Cart')" icon="cart" :count="$cartCount ?? 0" />

        {{-- Currency switcher --}}
        @include('layouts.partials.nav-language-currency')

        {{-- Notifications --}}
        @include('layouts.partials.nav-notification')

        {{-- Account dropdown --}}
        <x-dropdown align="right" width="72" contentClasses="py-0 overflow-hidden">
            @include('layouts.partials.nav-user-dropdown')
        </x-dropdown>

    </div>{{-- end desktop right --}}

</div>{{-- end single row --}}

{{-- ── Mobile search bar (slides in below nav) ───────────── --}}
<div :class="openSearch ? 'block' : 'hidden'"
     class="lg:hidden px-3 py-2.5 bg-white border-b border-gray-100">
    <form method="GET" action="{{ route('products.index') }}"
          class="relative flex items-center w-full">
        <svg class="absolute left-3 w-4 h-4 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" name="search"
               value="{{ request('search') }}"
               placeholder="{{ __('Search products, brands or stores...') }}"
               autofocus
               class="w-full pl-10 pr-20 py-2.5 text-sm text-gray-900
                      bg-gray-50 border border-gray-300 rounded-xl
                      placeholder-gray-400
                      focus:outline-none focus:ring-2 focus:ring-orange-300 focus:border-orange-400
                      transition-all" />
        <button type="submit"
                class="absolute right-1.5 bg-orange-500 hover:bg-orange-600 text-white
                       px-4 py-1.5 rounded-lg text-sm font-semibold transition-colors">
            {{ __('Search') }}
        </button>
    </form>
</div>

