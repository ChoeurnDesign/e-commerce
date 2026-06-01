<x-app-layout>

    {{-- ══════════════════════════════════════════════════════════════
         1. HERO — sidebar | banner + tiles | flash deals
    ══════════════════════════════════════════════════════════════ --}}
    <x-home.hero-layout
        :banners="$banners"
        :storefront-title="$storefrontTitle"
        :welcome-message="$welcomeMessage"
        :categories="$categories"
        :sale-products="$saleProducts"
        :new-arrivals="$newArrivals"
        :top-stores="$topStores"
    />

    {{-- ══════════════════════════════════════════════════════════════
         2. DASHBOARD ROW — 4 compact panels
         Top Stores · Hot Categories · New Arrivals · Just For You
    ══════════════════════════════════════════════════════════════ --}}
    <section>
        <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16 py-5 sm:py-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-stretch">

                {{-- ① TOP STORES — with "Popular" badges ────────────────── --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm flex flex-col">
                    <div class="flex items-center justify-between mb-4 flex-shrink-0">
                        <h3 class="text-sm font-extrabold text-gray-800 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            {{ __('Top Stores') }}
                        </h3>
                        <a href="{{ route('stores.index') }}" class="text-[11px] font-semibold text-pink-500 hover:text-pink-600">
                            {{ __('View All') }} ›
                        </a>
                    </div>
                    <div class="space-y-3 flex-1">
                        @foreach($topStores->take(5) as $idx => $store)
                            @php
                                $sInitial = strtoupper(substr($store->store_name ?? 'S', 0, 1));
                                $sRating = $store->receivedStoreReviews()->avg('rating') ?? 0;
                                $sSales = \App\Models\VendorOrder::where('seller_id', $store->id)
                                    ->where('status', 'completed')->count();
                                $sLogo = !empty($store->store_logo) && !filter_var($store->store_logo, FILTER_VALIDATE_URL)
                                    ? asset('storage/' . ltrim($store->store_logo, '/'))
                                    : ($store->store_logo ?? null);
                            @endphp
                            <a href="{{ route('stores.show', $store->slug) }}"
                               class="flex items-center gap-2.5 group">
                                {{-- Rank badge --}}
                                <span class="w-6 h-6 rounded-md flex items-center justify-center flex-shrink-0 text-[11px] font-extrabold
                                    {{ $idx === 0 ? 'bg-gradient-to-br from-amber-400 to-orange-500 text-white' : '' }}
                                    {{ $idx === 1 ? 'bg-gradient-to-br from-gray-300 to-gray-400 text-white' : '' }}
                                    {{ $idx === 2 ? 'bg-gradient-to-br from-amber-600 to-amber-700 text-white' : '' }}
                                    {{ $idx >= 3 ? 'bg-gray-100 text-gray-500' : '' }}">
                                    {{ $idx + 1 }}
                                </span>
                                {{-- Logo --}}
                                <div class="relative w-9 h-9 rounded-full overflow-hidden flex-shrink-0 bg-gradient-to-br from-pink-400 to-rose-500 flex items-center justify-center text-white font-bold text-sm">
                                    {{ $sInitial }}
                                    @if($sLogo)
                                    <img src="{{ $sLogo }}" alt="" class="absolute inset-0 w-full h-full object-cover" onerror="this.style.display='none'">
                                    @endif
                                </div>
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-gray-800 truncate group-hover:text-pink-600 transition-colors">
                                        {{ $store->store_name }}
                                    </p>
                                    <div class="flex items-center gap-1 mt-0.5">
                                        @if($sRating > 0)
                                        <svg class="w-3 h-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-[10px] font-bold text-gray-700">{{ number_format($sRating, 1) }}</span>
                                        <span class="text-[10px] text-gray-300">·</span>
                                        @endif
                                        <svg class="w-2.5 h-2.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                        <span class="text-[10px] text-gray-500">
                                            @if($sSales > 0)
                                                {{ number_format($sSales) }} {{ __('Sales') }}
                                            @else
                                                {{ number_format($store->products_count ?? 0) }} {{ __('items') }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                {{-- Status badge — only when meaningful --}}
                                @if($sRating >= 4.5)
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex-shrink-0">{{ __('Top Rated') }}</span>
                                @elseif($sSales >= 50)
                                    <span class="px-2.5 py-1 rounded-full bg-pink-50 text-pink-600 text-[10px] font-bold flex-shrink-0">{{ __('Popular') }}</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold flex-shrink-0">{{ __('New') }}</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ② HOT CATEGORIES — big colorful pastel tiles ────────── --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm flex flex-col">
                    <div class="flex items-center justify-between mb-4 flex-shrink-0">
                        <h3 class="text-sm font-extrabold text-gray-800 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-pink-500"></span>
                            {{ __('Hot Categories') }}
                        </h3>
                        <a href="{{ route('categories.index') }}" class="text-[11px] font-semibold text-pink-500 hover:text-pink-600">
                            {{ __('View All') }} ›
                        </a>
                    </div>
                    @php
                        $catTiles = [
                            ['bg' => '#DBEAFE', 'fg' => '#3B82F6', 'icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25'],
                            ['bg' => '#FCE7F3', 'fg' => '#EC4899', 'icon' => 'M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75h1.5m9 0h-9'],
                            ['bg' => '#D1FAE5', 'fg' => '#10B981', 'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'],
                            ['bg' => '#FEE2E2', 'fg' => '#EF4444', 'icon' => 'M21 11.25v8.25a1.5 1.5 0 01-1.5 1.5H5.25a1.5 1.5 0 01-1.5-1.5v-8.25M12 4.875A2.625 2.625 0 109.375 7.5H12m0-2.625V7.5m0-2.625A2.625 2.625 0 1114.625 7.5H12m0 0V21m-8.625-9.75h18c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125h-18c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z'],
                            ['bg' => '#DBEAFE', 'fg' => '#3B82F6', 'icon' => 'M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z'],
                            ['bg' => '#FEF3C7', 'fg' => '#D97706', 'icon' => 'M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25'],
                        ];
                    @endphp
                    <div class="grid grid-cols-3 gap-2 flex-1 content-start">
                        @foreach($categories->take(6) as $i => $cat)
                            @php
                                $c = $catTiles[$i % count($catTiles)];
                                $catImg = $cat->image
                                    ? (filter_var($cat->image, FILTER_VALIDATE_URL) ? $cat->image : asset('storage/' . ltrim($cat->image, '/')))
                                    : null;
                            @endphp
                            <a href="{{ route('category.show', $cat->slug) }}"
                               class="rounded-2xl p-3 flex flex-col items-center justify-center hover:scale-105 hover:shadow-md transition-all duration-200 group min-h-[90px]"
                               style="background:{{ $c['bg'] }}">
                                <div class="w-9 h-9 rounded-xl bg-white/70 flex items-center justify-center overflow-hidden mb-1.5">
                                    @if($catImg)
                                    <img src="{{ $catImg }}" alt="" class="w-full h-full object-cover" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                                    <svg class="w-5 h-5" style="color:{{ $c['fg'] }};display:none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}"/>
                                    </svg>
                                    @else
                                    <svg class="w-5 h-5" style="color:{{ $c['fg'] }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}"/>
                                    </svg>
                                    @endif
                                </div>
                                <p class="text-[11px] font-bold text-center line-clamp-1 w-full" style="color:{{ $c['fg'] }}">
                                    {{ $cat->name }}
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- ③ NEW ARRIVALS — list with cart icon ────────────────── --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm flex flex-col">
                    <div class="flex items-center justify-between mb-4 flex-shrink-0">
                        <h3 class="text-sm font-extrabold text-gray-800 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                            {{ __('New Arrivals') }}
                        </h3>
                        <a href="{{ route('products.index', ['sort' => 'latest']) }}" class="text-[11px] font-semibold text-pink-500 hover:text-pink-600">
                            {{ __('View All') }} ›
                        </a>
                    </div>
                    <div class="space-y-3 flex-1">
                        @foreach(collect($newArrivals)->take(3) as $product)
                            @php
                                $newHasSale = $product->on_sale && $product->sale_price && $product->price > 0 && $product->sale_price < $product->price;
                                $newPrice = $newHasSale ? $product->sale_price : $product->price;
                            @endphp
                            <div class="flex items-center gap-2.5 group">
                                <a href="{{ route('products.show', $product->slug) }}" class="relative w-12 h-12 rounded-xl overflow-hidden bg-rose-50 border border-gray-100 flex-shrink-0">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                         loading="lazy"
                                         onerror="this.style.display='none'">
                                </a>
                                <a href="{{ route('products.show', $product->slug) }}" class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-gray-800 line-clamp-1 leading-tight group-hover:text-pink-600 transition-colors">
                                        {{ $product->name }}
                                    </p>
                                    <p class="text-xs font-extrabold text-orange-600 mt-0.5">
                                        {{ \App\Helpers\CurrencyHelper::format($newPrice) }}
                                    </p>
                                    <span class="inline-flex items-center text-[10px] font-semibold text-pink-500 mt-0.5">
                                        {{ __('Shop Now') }}
                                        <svg class="w-2.5 h-2.5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </span>
                                </a>
                                <button type="button"
                                        onclick="addToCart({{ $product->id }}, this)"
                                        title="{{ __('Add to cart') }}"
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-pink-50 hover:bg-pink-500 hover:text-white text-pink-500 flex items-center justify-center transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ④ JUST FOR YOU — list with "Recommended" badge ──────── --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-4 shadow-sm flex flex-col">
                    <div class="flex items-center justify-between mb-4 flex-shrink-0">
                        <h3 class="text-sm font-extrabold text-gray-800 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-violet-500"></span>
                            {{ __('Just For You') }}
                        </h3>
                        <a href="{{ route('products.index') }}" class="text-[11px] font-semibold text-pink-500 hover:text-pink-600">
                            {{ __('View All') }} ›
                        </a>
                    </div>
                    <div class="space-y-3 flex-1">
                        @forelse($featuredProducts->take(3) as $product)
                            @php
                                $jfyHasSale = $product->on_sale && $product->price > 0 && $product->sale_price && $product->sale_price < $product->price;
                                $jfyPrice = $jfyHasSale ? $product->sale_price : $product->price;
                            @endphp
                            <div class="flex items-center gap-2.5 group">
                                <a href="{{ route('products.show', $product->slug) }}" class="relative w-12 h-12 rounded-xl overflow-hidden bg-rose-50 border border-gray-100 flex-shrink-0">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                         loading="lazy"
                                         onerror="this.style.display='none'">
                                </a>
                                <a href="{{ route('products.show', $product->slug) }}" class="flex-1 min-w-0">
                                    <p class="text-xs font-bold text-gray-800 line-clamp-1 leading-tight group-hover:text-pink-600 transition-colors">
                                        {{ $product->name }}
                                    </p>
                                    <div class="flex items-baseline gap-1 mt-0.5">
                                        <span class="text-xs font-extrabold text-orange-600">
                                            {{ \App\Helpers\CurrencyHelper::format($jfyPrice) }}
                                        </span>
                                        @if($jfyHasSale)
                                        <span class="text-[9px] text-gray-400 line-through">
                                            {{ \App\Helpers\CurrencyHelper::format($product->price) }}
                                        </span>
                                        @endif
                                    </div>
                                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-bold">
                                        {{ __('Recommended') }}
                                    </span>
                                </a>
                                <button type="button"
                                        onclick="addToCart({{ $product->id }}, this)"
                                        title="{{ __('Add to cart') }}"
                                        class="flex-shrink-0 w-8 h-8 rounded-full bg-pink-50 hover:bg-pink-500 hover:text-white text-pink-500 flex items-center justify-center transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </button>
                            </div>
                        @empty
                            <div class="py-6 text-center text-xs text-gray-400">{{ __('No products') }}</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         BECOME A SELLER BANNER
    ══════════════════════════════════════════════════════════════ --}}
    <section>
        <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16 pb-5">
            <div class="relative rounded-2xl overflow-hidden shadow-sm"
                 style="background:linear-gradient(135deg,#CFFAFE 0%,#A5F3FC 50%,#67E8F9 100%)">
                <div class="grid grid-cols-1 lg:grid-cols-5 items-center gap-4 px-6 py-5">
                    {{-- Left: title + tagline --}}
                    <div class="lg:col-span-2 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-white/70 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-extrabold text-gray-900">{{ __('Become a Seller Today!') }}</h3>
                            <p class="text-xs text-gray-600">{{ __('Join thousands of sellers earning better with ShopExpress') }}</p>
                        </div>
                    </div>

                    {{-- Features --}}
                    <div class="lg:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div class="flex items-center gap-2.5 bg-white/40 rounded-xl px-3 py-2">
                            <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375M3.75 18.75v-.625c0-.621.504-1.125 1.125-1.125h.375m1.5 1.5v-.75a.75.75 0 01.75-.75h.75M12 6.75v10.5"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-gray-900 leading-tight">{{ __('Zero Setup Fee') }}</p>
                                <p class="text-[10px] text-gray-600 leading-tight">{{ __('Start your business for free') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 bg-white/40 rounded-xl px-3 py-2">
                            <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-gray-900 leading-tight">{{ __('Global Reach') }}</p>
                                <p class="text-[10px] text-gray-600 leading-tight">{{ __('Reach millions of customers') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 bg-white/40 rounded-xl px-3 py-2">
                            <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-extrabold text-gray-900 leading-tight">{{ __('Dedicated Support') }}</p>
                                <p class="text-[10px] text-gray-600 leading-tight">{{ __('We\'re here to help you grow') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Decorative right edge --}}
                <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden xl:block opacity-30 pointer-events-none">
                    <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         3. RECOMMENDED FOR YOU — 6-column product grid
    ══════════════════════════════════════════════════════════════ --}}
    <section>
        <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16 py-6 sm:py-8">

            <div class="flex items-end justify-between mb-5">
                <div>
                    <span class="text-xs font-bold text-pink-500 uppercase tracking-widest">
                        {{ __('Trending Now') }}
                    </span>
                    <h2 class="text-base sm:text-xl font-extrabold text-gray-800 mt-0.5">
                        {{ __('Recommended For You') }}
                    </h2>
                </div>
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center gap-1 text-sm font-semibold
                          text-orange-500 hover:text-orange-600 transition-colors">
                    {{ __('View All') }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3 sm:gap-4">
                @foreach($featuredProducts->take(18) as $product)
                    <x-products.product-card :product="$product" :compact="true" />
                @endforeach
            </div>
            @else
            <div class="flex flex-col items-center py-16 text-center">
                <div class="w-16 h-16 rounded-full bg-pink-50 flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-pink-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-400">{{ __('No products yet') }}</p>
            </div>
            @endif

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         4. CUSTOMER SUPPORT CHATBOT
    ══════════════════════════════════════════════════════════════ --}}
    <x-chatbot />

</x-app-layout>
