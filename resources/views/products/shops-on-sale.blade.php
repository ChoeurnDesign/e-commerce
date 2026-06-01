<x-app-layout>

{{-- ─────────────────────────────────────────────
     HERO BANNER
───────────────────────────────────────────── --}}
<div class="relative overflow-hidden">
    {{-- Soft pink background matching site theme --}}
    <div class="absolute inset-0" style="background:linear-gradient(135deg,#FFB3CC 0%,#FFCCE0 50%,#FFE0EE 100%)"></div>

    <div class="relative max-w-full mx-auto px-6 sm:px-10 lg:px-16 py-10 sm:py-14">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">

            <div>
                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-pink-700/70 text-xs mb-3">
                    <a href="{{ route('home') }}" class="hover:text-pink-800 transition-colors">{{ __('Home') }}</a>
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-pink-800 font-medium">{{ __('Sale') }}</span>
                </nav>

                {{-- Title --}}
                <div class="flex items-center gap-3 mb-2">
                    <div class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-white/70 backdrop-blur-sm flex-shrink-0 shadow-sm">
                        <x-icon-dashboard name="sale" class="w-5 h-5 sm:w-6 sm:h-6 text-rose-600" />
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-800 tracking-tight">
                        {{ __('Flash Sale') }}
                    </h1>
                </div>
                <p class="text-gray-600 text-sm sm:text-base ml-1">
                    {{ __('Limited-time deals — the best prices, hand-picked for you') }}
                </p>
            </div>

            {{-- Stats cards --}}
            <div class="flex gap-3 flex-shrink-0">
                <div class="bg-white/80 backdrop-blur-sm border border-pink-200 rounded-2xl px-4 py-3 text-center min-w-[90px] shadow-sm">
                    <div class="text-2xl sm:text-3xl font-extrabold text-rose-600">
                        {{ $saleProducts->total() }}
                    </div>
                    <div class="text-gray-500 text-xs font-medium mt-0.5">{{ __('Deals') }}</div>
                </div>
                <div class="bg-white/80 backdrop-blur-sm border border-pink-200 rounded-2xl px-4 py-3 text-center min-w-[90px] shadow-sm">
                    @php
                        $maxDiscount = $saleProducts->getCollection()->map(function($p) {
                            return $p->price > 0 ? round((($p->price - $p->sale_price) / $p->price) * 100) : 0;
                        })->max();
                    @endphp
                    <div class="text-2xl sm:text-3xl font-extrabold text-rose-600">
                        {{ $maxDiscount > 0 ? $maxDiscount . '%' : '—' }}
                    </div>
                    <div class="text-gray-500 text-xs font-medium mt-0.5">{{ __('Max Off') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- ─────────────────────────────────────────────
     SORT BAR  (sticky)
───────────────────────────────────────────── --}}
<div class="sticky top-[calc(theme(spacing.16)+theme(spacing.14))] z-30
            bg-white/90 backdrop-blur-md
            border-b border-gray-200 shadow-sm">
    <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16">
        <div class="flex items-center gap-3 py-3 overflow-x-auto no-scrollbar">

            {{-- Label --}}
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider whitespace-nowrap flex-shrink-0">
                {{ __('Sort') }}:
            </span>

            @php
                $currentSort = request('sort', 'discount');
                $sorts = [
                    'discount'   => ['label' => __('Best Discount'), 'icon' => 'percent'],
                    'price_low'  => ['label' => __('Price: Low → High'), 'icon' => null],
                    'price_high' => ['label' => __('Price: High → Low'), 'icon' => null],
                    'rating'     => ['label' => __('Top Rated'), 'icon' => null],
                    'latest'     => ['label' => __('Newest'), 'icon' => null],
                ];
            @endphp

            @foreach($sorts as $key => $meta)
            <a href="{{ request()->fullUrlWithQuery(['sort' => $key, 'page' => 1]) }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold whitespace-nowrap flex-shrink-0 transition-all duration-200
                      {{ $currentSort === $key
                          ? 'bg-rose-500 text-white shadow-sm shadow-rose-200'
                          : 'bg-gray-100 text-gray-600 hover:bg-rose-50 hover:text-rose-600' }}">
                @if($meta['icon'])
                    <x-icon-dashboard :name="$meta['icon']" class="w-3.5 h-3.5" />
                @endif
                {{ $meta['label'] }}
            </a>
            @endforeach

            {{-- Right: result count --}}
            <span class="ml-auto text-xs text-gray-400 whitespace-nowrap flex-shrink-0 hidden sm:block">
                {{ number_format($saleProducts->total()) }} {{ Str::plural('deal', $saleProducts->total()) }}
                &bull;
                {{ __('Page') }} {{ $saleProducts->currentPage() }} / {{ $saleProducts->lastPage() }}
            </span>
        </div>
    </div>
</div>


{{-- ─────────────────────────────────────────────
     PRODUCTS GRID
───────────────────────────────────────────── --}}
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16 py-8 sm:py-10">

        @if($saleProducts->count() > 0)

            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3 sm:gap-4">
                @foreach($saleProducts as $product)
                    @php
                        $discountPct = $product->price > 0
                            ? round((($product->price - $product->sale_price) / $product->price) * 100)
                            : 0;
                    @endphp

                    {{-- Wrapper: adds the discount ribbon on top of the existing card --}}
                    <div class="relative">
                        @if($discountPct > 0)
                        <div class="absolute top-2.5 left-2.5 z-10
                                     bg-rose-500 text-white text-[11px] font-extrabold
                                     px-2 py-0.5 rounded-full shadow leading-tight pointer-events-none">
                            −{{ $discountPct }}%
                        </div>
                        @endif
                        <x-products.product-card :product="$product" />
                    </div>
                @endforeach
            </div>

            {{-- ── Pagination ── --}}
            @if($saleProducts->hasPages())
            <div class="mt-10 sm:mt-14">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-gray-500">
                        {{ __('Showing') }}
                        <span class="font-semibold text-gray-700">{{ $saleProducts->firstItem() }}</span>
                        –
                        <span class="font-semibold text-gray-700">{{ $saleProducts->lastItem() }}</span>
                        {{ __('of') }}
                        <span class="font-semibold text-gray-700">{{ number_format($saleProducts->total()) }}</span>
                        {{ __('deals') }}
                    </p>
                </div>

                <nav class="flex flex-wrap items-center justify-center gap-1.5" aria-label="Pagination">
                    {{-- Prev --}}
                    @if($saleProducts->onFirstPage())
                        <span class="inline-flex items-center gap-1 px-4 py-2 rounded-xl text-sm font-medium
                                     bg-gray-100 text-gray-400 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            {{ __('Prev') }}
                        </span>
                    @else
                        <a href="{{ $saleProducts->previousPageUrl() }}"
                           class="inline-flex items-center gap-1 px-4 py-2 rounded-xl text-sm font-medium
                                  bg-white border border-gray-200
                                  text-gray-700
                                  hover:border-rose-400 hover:text-rose-600
                                  transition-all duration-200 shadow-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            {{ __('Prev') }}
                        </a>
                    @endif

                    {{-- Page numbers --}}
                    @foreach($saleProducts->getUrlRange(max(1, $saleProducts->currentPage()-2), min($saleProducts->lastPage(), $saleProducts->currentPage()+2)) as $page => $url)
                        @if($page == $saleProducts->currentPage())
                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-bold
                                         bg-rose-500 text-white shadow-sm shadow-rose-200">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-xl text-sm font-medium
                                      bg-white border border-gray-200
                                      text-gray-700
                                      hover:border-rose-400 hover:text-rose-600
                                      transition-all duration-200 shadow-sm">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($saleProducts->hasMorePages())
                        <a href="{{ $saleProducts->nextPageUrl() }}"
                           class="inline-flex items-center gap-1 px-4 py-2 rounded-xl text-sm font-medium
                                  bg-white border border-gray-200
                                  text-gray-700
                                  hover:border-rose-400 hover:text-rose-600
                                  transition-all duration-200 shadow-sm">
                            {{ __('Next') }}
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1 px-4 py-2 rounded-xl text-sm font-medium
                                     bg-gray-100 text-gray-400 cursor-not-allowed">
                            {{ __('Next') }}
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    @endif
                </nav>
            </div>
            @endif

        @else
        {{-- ── Empty state ── --}}
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-20 h-20 rounded-3xl bg-rose-100 flex items-center justify-center mb-5">
                <x-icon-dashboard name="sale" class="w-10 h-10 text-rose-400" />
            </div>
            <h2 class="text-xl font-bold text-gray-800 mb-2">
                {{ __('No Deals Right Now') }}
            </h2>
            <p class="text-gray-500 text-sm max-w-xs mb-6 leading-relaxed">
                {{ __('Our sellers are preparing new deals. Check back soon — sales go live every day!') }}
            </p>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 bg-rose-500 hover:bg-rose-600 text-white font-semibold
                      py-2.5 px-6 rounded-full transition-all duration-200 shadow-md hover:shadow-lg text-sm">
                {{ __('Browse All Products') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        @endif

    </div>
</div>

<style>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

</x-app-layout>
