<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>

    <div class="py-4 sm:py-8 min-h-screen">
        <div class="max-w-full mx-auto px-3 sm:px-6 lg:px-16">

            @php
                // ── Detect which themed landing we're on ────────────────────────
                $ctxSort   = request('sort');
                $ctxOnSale = request('on_sale') == 1;
                $ctxSearch = request('search');

                if ($ctxSearch) {
                    $hero = [
                        'eyebrow' => 'Search Results',
                        'title'   => '"' . $ctxSearch . '"',
                        'subtitle'=> 'Showing products that match your search.',
                        'grad'    => 'from-slate-700 via-slate-600 to-slate-500',
                        'icon'    => 'M21 21l-6-6m2-5a7 7 0 10-14 0 7 7 0 0014 0z',
                    ];
                } elseif ($ctxOnSale) {
                    $hero = [
                        'eyebrow' => 'Limited-Time Offers',
                        'title'   => 'Hot Deals',
                        'subtitle'=> 'Grab the biggest discounts before they are gone.',
                        'grad'    => 'from-rose-600 via-red-500 to-orange-500',
                        'icon'    => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                    ];
                } elseif ($ctxSort === 'rating') {
                    $hero = [
                        'eyebrow' => 'Customer Favourites',
                        'title'   => 'Top Rated',
                        'subtitle'=> 'The highest-rated products loved by our shoppers.',
                        'grad'    => 'from-amber-500 via-yellow-500 to-orange-400',
                        'icon'    => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z',
                    ];
                } elseif ($ctxSort === 'latest') {
                    $hero = [
                        'eyebrow' => 'Just Landed',
                        'title'   => 'New Arrivals',
                        'subtitle'=> 'Fresh products added to the marketplace.',
                        'grad'    => 'from-emerald-600 via-teal-500 to-cyan-500',
                        'icon'    => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
                    ];
                } else {
                    $hero = [
                        'eyebrow' => 'Marketplace',
                        'title'   => 'All Products',
                        'subtitle'=> 'Discover our amazing collection of products.',
                        'grad'    => 'from-pink-600 via-pink-500 to-rose-400',
                        'icon'    => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4',
                    ];
                }
            @endphp

            {{-- ══ THEMED HERO ══ --}}
            <div class="relative overflow-hidden rounded-2xl shadow-lg mb-5 sm:mb-7
                        bg-gradient-to-br {{ $hero['grad'] }} text-white
                        px-5 py-6 sm:px-8 sm:py-8">
                {{-- Decorative circles --}}
                <div class="absolute -top-10 -right-8 w-40 h-40 bg-white/10 rounded-full"></div>
                <div class="absolute -bottom-12 -left-10 w-44 h-44 bg-white/10 rounded-full"></div>

                <div class="relative z-10 flex items-center gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $hero['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] sm:text-xs font-semibold uppercase tracking-wider text-white/80">{{ $hero['eyebrow'] }}</p>
                        <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight truncate">{{ $hero['title'] }}</h1>
                        <p class="text-sm text-white/85 mt-0.5 hidden sm:block">{{ $hero['subtitle'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Filters --}}
            <div class="mb-4 sm:mb-8">
                <x-products.search-filters :categories="$categories" :show-advanced="true" />
            </div>

            {{-- Results count + page --}}
            <div class="flex justify-between items-center mb-4 sm:mb-6 gap-2">
                <p class="text-sm text-gray-600">
                    <span class="text-pink-600 font-bold">{{ $products->total() }}</span>
                    products
                    @if(request('search'))
                        for <span class="italic text-pink-600">"{{ request('search') }}"</span>
                    @endif
                </p>
                <span class="text-xs text-gray-400 bg-white border border-gray-200 px-3 py-1 rounded-full shrink-0">
                    {{ $products->currentPage() }} / {{ $products->lastPage() }}
                </span>
            </div>

            {{-- Product grid --}}
            @if($products->count())
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2.5 sm:gap-4 mb-8">
                    @foreach($products as $product)
                        <x-products.product-card :product="$product" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8 sm:mt-12 mb-6 sm:mb-10 border-t border-gray-200 pt-6 sm:pt-8">
                    {{ $products->links() }}
                </div>
            @else
                {{-- Empty state --}}
                <div class="text-center py-16">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 10-14 0 7 7 0 0014 0z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-600 mb-2">No products found</h3>
                    <p class="text-sm text-gray-400 mb-6">Try adjusting your filters or search terms</p>
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center gap-2 bg-pink-500 hover:bg-pink-600 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                        Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
