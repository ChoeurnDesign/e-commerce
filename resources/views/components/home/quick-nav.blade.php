{{--
    Quick-nav bar — sits ABOVE "Top Categories" in page body.
    Uses CSS sticky so it pins just below the 64px navbar when scrolled.
--}}
@props(['statsProducts' => 0, 'statsSellers' => 0, 'statsCategories' => 0])

<div class="sticky z-40 bg-white" style="top: 64px">
    <div class="max-w-full mx-auto px-12 sm:px-16 lg:px-20">
        <div class="flex items-center h-11 gap-1 overflow-x-auto scrollbar-hide">

            {{-- Flash Sale --}}
            <a href="{{ route('products.shops_on_sale') }}"
               class="flex items-center gap-1.5 px-4 py-2 rounded-md text-sm font-semibold whitespace-nowrap transition-all duration-150 flex-shrink-0 
                      {{ request()->routeIs('products.shops_on_sale') ? 'bg-rose-500 text-white' : 'text-rose-600 hover:bg-rose-50' }}">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
                {{ __('Flash Sale') }}
            </a>

            <span class="h-4 w-px bg-gray-200 flex-shrink-0"></span>

            {{-- New Arrivals --}}
            <a href="{{ route('products.index', ['sort' => 'latest']) }}"
               class="flex items-center gap-1.5 px-4 py-2 rounded-md text-sm font-semibold whitespace-nowrap transition-all duration-150 flex-shrink-0 text-gray-700 hover:text-orange-500 hover:bg-orange-50">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
                {{ __('New Arrivals') }}
            </a>

            <span class="h-4 w-px bg-gray-200 flex-shrink-0"></span>

            {{-- Top Rated --}}
            <a href="{{ route('products.index', ['sort' => 'rating']) }}"
               class="flex items-center gap-1.5 px-4 py-2 rounded-md text-sm font-semibold whitespace-nowrap transition-all duration-150 flex-shrink-0 text-gray-700 hover:text-orange-500 hover:bg-orange-50">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                {{ __('Top Rated') }}
            </a>

            <span class="h-4 w-px bg-gray-200 flex-shrink-0"></span>

            {{-- Deals --}}
            <a href="{{ route('products.index', ['on_sale' => 1]) }}"
               class="flex items-center gap-1.5 px-4 py-2 rounded-md text-sm font-semibold whitespace-nowrap transition-all duration-150 flex-shrink-0 text-gray-700 hover:text-orange-500 hover:bg-orange-50">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                {{ __('Deals') }}
            </a>

            <span class="h-4 w-px bg-gray-200 flex-shrink-0"></span>

            {{-- Top Stores --}}
            <a href="{{ route('stores.index') }}"
               class="flex items-center gap-1.5 px-4 py-2 rounded-md text-sm font-semibold whitespace-nowrap transition-all duration-150 flex-shrink-0 text-gray-700 hover:text-orange-500 hover:bg-orange-50">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                {{ __('Top Stores') }}
            </a>

            {{-- Right: platform stats --}}
            <div class="hidden lg:flex items-center gap-5 ml-auto text-[11px] text-gray-400 flex-shrink-0">
                @if($statsProducts > 0)
                <span class="flex items-center gap-1"><span class="font-bold text-gray-600">{{ number_format($statsProducts) }}</span> {{ __('Products') }}</span>
                @endif
                @if($statsSellers > 0)
                <span class="flex items-center gap-1"><span class="font-bold text-gray-600">{{ number_format($statsSellers) }}</span> {{ __('Sellers') }}</span>
                @endif
                @if($statsCategories > 0)
                <span class="flex items-center gap-1"><span class="font-bold text-gray-600">{{ number_format($statsCategories) }}</span> {{ __('Categories') }}</span>
                @endif
            </div>
        </div>
    </div>
</div>