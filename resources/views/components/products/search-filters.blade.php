@props([
    'action' => route('products.index'),
    'categories' => collect(),
    'showAdvanced' => true,
])

@php
    $search    = request('search', '');
    $category  = request('category', '');
    $minPrice  = request('min_price', '');
    $maxPrice  = request('max_price', '');
    $sort      = request('sort', 'latest');
    $minRating = request('min_rating', '');
    $onSale    = request('on_sale', '');
    $hasFilters = $search || $category || $minPrice || $maxPrice || $minRating || $onSale === '1';
@endphp

{{-- ══ MOBILE FILTERS (< lg) ══ --}}
<div class="lg:hidden" x-data="{ filtersOpen: false }">
    <form method="GET" action="{{ $action }}" class="space-y-3">

        {{-- Search bar --}}
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 10-14 0 7 7 0 0014 0z"/>
            </svg>
            <input type="text" name="search" value="{{ $search }}" placeholder="Search products..."
                   class="w-full pl-10 pr-20 py-3 border border-gray-200 rounded-xl bg-white text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:border-pink-400 shadow-sm">
            <button type="submit"
                    class="absolute right-1.5 top-1/2 -translate-y-1/2 bg-orange-500 hover:bg-orange-600 text-white px-4 py-1.5 rounded-lg text-sm font-semibold transition-colors">
                Search
            </button>
        </div>

        {{-- Filter toggle --}}
        <div class="flex items-center gap-2">
            <button type="button" @click="filtersOpen = !filtersOpen"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl border text-sm font-medium transition-all
                           {{ $hasFilters ? 'border-pink-300 bg-pink-50 text-pink-700' : 'border-gray-200 bg-white text-gray-600' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filters
                @if($hasFilters)
                    <span class="w-2 h-2 rounded-full bg-pink-500"></span>
                @endif
            </button>

            {{-- Sort pill --}}
            <select name="sort"
                    class="flex-1 px-3 py-2 border border-gray-200 rounded-xl bg-white text-sm text-gray-700 focus:ring-2 focus:ring-pink-300 focus:border-pink-400">
                <option value="latest"     @selected($sort=='latest')>Latest</option>
                <option value="price_low"  @selected($sort=='price_low')>Price: Low → High</option>
                <option value="price_high" @selected($sort=='price_high')>Price: High → Low</option>
                <option value="name"       @selected($sort=='name')>A → Z</option>
                <option value="rating"     @selected($sort=='rating')>Top Rated</option>
            </select>
        </div>

        {{-- Collapsible filters --}}
        <div x-show="filtersOpen" x-collapse x-cloak class="space-y-3 pt-1">

            {{-- Category --}}
            <select name="category"
                    class="w-full px-3 py-2.5 border border-gray-200 rounded-xl bg-white text-sm text-gray-700 focus:ring-2 focus:ring-pink-300">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" @selected($category == $cat->slug)>{{ $cat->name }}</option>
                @endforeach
            </select>

            {{-- Price range --}}
            <div class="grid grid-cols-2 gap-2">
                <input type="number" name="min_price" value="{{ $minPrice }}" placeholder="Min price"
                       class="px-3 py-2.5 border border-gray-200 rounded-xl bg-white text-sm text-gray-700 focus:ring-2 focus:ring-pink-300">
                <input type="number" name="max_price" value="{{ $maxPrice }}" placeholder="Max price"
                       class="px-3 py-2.5 border border-gray-200 rounded-xl bg-white text-sm text-gray-700 focus:ring-2 focus:ring-pink-300">
            </div>

            @if($showAdvanced)
            <div class="grid grid-cols-2 gap-2">
                {{-- Rating --}}
                <select name="min_rating"
                        class="px-3 py-2.5 border border-gray-200 rounded-xl bg-white text-sm text-gray-700 focus:ring-2 focus:ring-pink-300">
                    <option value="">Min Rating</option>
                    @for($r=5;$r>=1;$r--)
                        <option value="{{ $r }}" @selected($minRating == (string)$r)>{{ $r }}★ & Up</option>
                    @endfor
                </select>

                {{-- On sale --}}
                <label class="flex items-center justify-center gap-2 px-3 py-2.5 border border-gray-200 rounded-xl bg-white text-sm text-gray-700 cursor-pointer">
                    <input type="checkbox" name="on_sale" value="1"
                           class="rounded text-pink-600 focus:ring-pink-400 w-4 h-4"
                           @checked($onSale === '1')>
                    On Sale Only
                </label>
            </div>
            @endif

            {{-- Apply + Clear --}}
            <div class="flex gap-2">
                <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-2.5 rounded-xl font-semibold text-sm transition-colors shadow-sm">
                    Apply Filters
                </button>
                <a href="{{ $action }}"
                   class="px-5 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                    Clear
                </a>
            </div>
        </div>
    </form>
</div>

{{-- ══ DESKTOP FILTERS (lg+) ══ --}}
<form method="GET" action="{{ $action }}"
      class="hidden lg:flex flex-wrap gap-3 items-center justify-center">

    {{-- Search --}}
    <div class="relative flex-1 min-w-[200px] max-w-md">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 10-14 0 7 7 0 0014 0z"/>
        </svg>
        <input type="text" name="search" value="{{ $search }}" placeholder="Search products..." autocomplete="off"
               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 bg-white text-sm text-gray-900 placeholder-gray-400 shadow-sm">
    </div>

    {{-- Category --}}
    <select name="category"
            class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 bg-white text-sm text-gray-700 min-w-[140px] shadow-sm">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->slug }}" @selected($category == $cat->slug)>{{ $cat->name }}</option>
        @endforeach
    </select>

    {{-- Price range --}}
    <input type="number" name="min_price" value="{{ $minPrice }}" placeholder="Min $"
           class="w-24 px-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-300 bg-white text-center text-sm shadow-sm">
    <input type="number" name="max_price" value="{{ $maxPrice }}" placeholder="Max $"
           class="w-24 px-3 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-300 bg-white text-center text-sm shadow-sm">

    @if($showAdvanced)
        <select name="min_rating"
                class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-300 bg-white text-sm text-gray-700 shadow-sm">
            <option value="">Min ★</option>
            @for($r=5;$r>=1;$r--)
                <option value="{{ $r }}" @selected($minRating == (string)$r)>{{ $r }}★ & Up</option>
            @endfor
        </select>

        <label class="flex items-center gap-2 px-4 py-2.5 border border-gray-200 rounded-xl bg-white text-sm text-gray-700 cursor-pointer shadow-sm hover:border-pink-300 transition-colors">
            <input type="checkbox" name="on_sale" value="1"
                   class="rounded text-pink-600 focus:ring-pink-400"
                   @checked($onSale === '1')>
            On Sale
        </label>
    @endif

    {{-- Sort --}}
    <select name="sort"
            class="px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-300 bg-white text-sm text-gray-700 min-w-[120px] shadow-sm">
        <option value="latest"     @selected($sort=='latest')>Latest</option>
        <option value="price_low"  @selected($sort=='price_low')>Price ↑</option>
        <option value="price_high" @selected($sort=='price_high')>Price ↓</option>
        <option value="name"       @selected($sort=='name')>A-Z</option>
        <option value="rating"     @selected($sort=='rating')>Top Rated</option>
    </select>

    {{-- Actions --}}
    <button type="submit"
            class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-colors shadow-sm">
        Apply
    </button>
    <a href="{{ $action }}"
       class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
        Clear
    </a>
</form>
