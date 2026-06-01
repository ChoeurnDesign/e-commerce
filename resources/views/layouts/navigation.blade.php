@php
    $isMinimalNav = request()->routeIs('chat.*', 'checkout.*');
@endphp

{{-- ① PROMO STRIP — outside nav, normal flow, scrolls away first --}}
@unless($isMinimalNav)
<div class="hidden lg:block">
    <div class="flex items-center justify-center gap-8 pt-5 pb-1 text-sm font-semibold">
        <span class="flex items-center gap-2 text-pink-800">
            <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
            </svg>
            <span>{{ __('Flash Sale — Up to 80% Off Today Only!') }}</span>
        </span>
        <span class="text-pink-300 text-lg">|</span>
        <span class="flex items-center gap-2 text-pink-800">
            <svg class="w-4 h-4 text-rose-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ __('100% Buyer Protection on Every Order') }}</span>
        </span>
        <span class="text-pink-300 text-lg">|</span>
        <a href="{{ route('products.shops_on_sale') }}"
           class="flex items-center gap-1.5 font-bold text-rose-600 hover:text-rose-700 underline-offset-2 hover:underline">
            {{ __('Shop Now') }}
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>
@endunless

{{-- ② + ③ NAV — sticky top-0, both bars always fixed once promo scrolls away --}}
<nav class="sticky top-0 z-50"
     style="will-change:background-color,box-shadow;"
     x-data="{
         mobileMenuOpen: false,
         openSearch: false,
         isMobile: window.innerWidth < 1024,
         p: 0,
         _target: 0,
         init() {
             const mq = window.matchMedia('(max-width: 1023px)');
             this.isMobile = mq.matches;
             mq.addEventListener('change', e => this.isMobile = e.matches);
             window.addEventListener('scroll', () => {
                 this._target = Math.min(1, Math.max(0, window.scrollY / 180));
             }, { passive: true });
             const tick = () => {
                 this.p += (this._target - this.p) * 0.10;
                 requestAnimationFrame(tick);
             };
             requestAnimationFrame(tick);
         }
     }"
     :style="`background-color:rgba(255,255,255,${ isMobile ? 1 : p });box-shadow:0 1px 12px rgba(0,0,0,${ isMobile ? 0.04 : p*0.06 });`">

    {{-- Main nav bar --}}
    <div class="w-full">
        @include('layouts.partials.desktop-nav')
    </div>

    {{-- Second nav bar --}}
    @unless($isMinimalNav)
    <div class="hidden lg:block">
        <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16">
            <div class="flex items-center h-7 gap-0">
                {{-- All Categories link --}}
                <a href="{{ route('categories.index') }}"
                   class="flex items-center gap-2 px-4 h-full font-semibold text-sm
                          text-gray-700 flex-shrink-0
                          hover:text-pink-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    {{ __('All Categories') }}
                </a>

                {{-- Quick links --}}
                <a href="{{ route('products.shops_on_sale') }}"
                   class="flex items-center gap-1.5 px-4 py-0 text-sm font-semibold whitespace-nowrap
                          text-rose-600 hover:text-rose-700 hover:bg-rose-50 transition-colors flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('Flash Sale') }}
                </a>

                <a href="{{ route('products.index', ['sort' => 'latest']) }}"
                   class="flex items-center gap-1.5 px-4 py-0 text-sm font-semibold whitespace-nowrap
                          text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-colors flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                    {{ __('New Arrivals') }}
                </a>

                <a href="{{ route('products.index', ['sort' => 'rating']) }}"
                   class="flex items-center gap-1.5 px-4 py-0 text-sm font-semibold whitespace-nowrap
                          text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-colors flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    {{ __('Top Rated') }}
                </a>

                <a href="{{ route('products.index', ['on_sale' => 1]) }}"
                   class="flex items-center gap-1.5 px-4 py-0 text-sm font-semibold whitespace-nowrap
                          text-gray-700 hover:text-orange-500 hover:bg-orange-50 transition-colors flex-shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    {{ __('Deals') }}
                </a>

                {{-- Right: trust badges --}}
                <div class="ml-auto flex items-center gap-5 text-xs text-gray-500 flex-shrink-0">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        <span class="font-semibold text-gray-700">{{ __('100% Authentic') }}</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        <span class="font-semibold text-gray-700">{{ __('Buyer Protection') }}</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <span class="font-semibold text-gray-700">{{ __('Secure Payment') }}</span>
                    </span>
                </div>

            </div>
        </div>
    </div>
    @endunless

    @include('layouts.partials.mobile-nav')
</nav>
