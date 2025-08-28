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
@endphp

<form method="GET" action="{{ $action }}"
      class="flex flex-wrap gap-4 items-center justify-center">

    {{-- Search --}}
    <div class="relative flex-1 min-w-70 max-w-full">
        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 21l-6-6m2-5a7 7 0 10-14 0 7 7 0 0014 0z"/>
            </svg>
        </span>
        <input type="text"
               name="search"
               value="{{ $search }}"
               placeholder="Search products..."
               autocomplete="off"
               class="w-full pl-10 pr-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm" />
    </div>

    {{-- Category --}}
    <select name="category"
            class="px-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-700 dark:text-gray-200 min-w-40 text-sm">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->slug }}" @selected($category == $cat->slug)>{{ $cat->name }}</option>
        @endforeach
    </select>

    {{-- Price range --}}
    <input type="number" name="min_price" value="{{ $minPrice }}" placeholder="Min $"
           class="w-20 px-3 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 text-center transition-all text-gray-700 dark:text-gray-200 text-sm placeholder-gray-500 dark:placeholder-gray-400" />

    <input type="number" name="max_price" value="{{ $maxPrice }}" placeholder="Max $"
           class="w-20 px-3 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 text-center transition-all text-gray-700 dark:text-gray-200 text-sm placeholder-gray-500 dark:placeholder-gray-400" />

    {{-- Advanced filters --}}
    @if($showAdvanced)
        <select name="min_rating"
                class="px-6 py-2 pr-8 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 text-sm text-gray-700 dark:text-gray-200">
            <option value="">Min ★</option>
            @for($r=5;$r>=1;$r--)
                <option value="{{ $r }}" @selected($minRating == (string)$r)>{{ $r }}★ & Up</option>
            @endfor
        </select>

        <label class="flex items-center gap-1 px-3 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full bg-white dark:bg-gray-900 text-sm text-gray-700 dark:text-gray-200 cursor-pointer">
            <input type="checkbox" name="on_sale" value="1"
                   class="rounded text-indigo-600 focus:ring-indigo-500"
                   @checked($onSale === '1')>
            <span>On Sale</span>
        </label>
    @endif

    {{-- Sort --}}
    <select name="sort"
            class="px-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-700 dark:text-gray-200 min-w-32 text-sm">
        <option value="latest"     @selected($sort=='latest')>Latest</option>
        <option value="price_low"  @selected($sort=='price_low')>Price ↑</option>
        <option value="price_high" @selected($sort=='price_high')>Price ↓</option>
        <option value="name"       @selected($sort=='name')>A-Z</option>
        <option value="rating"     @selected($sort=='rating')>Top Rated</option>
    </select>

    {{-- Actions --}}
    <button type="submit"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-full font-medium transition-all shadow-md hover:shadow-lg text-sm">
        Apply
    </button>
    <a href="{{ $action }}"
       class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-5 py-2 border-2 border-gray-400 rounded-full font-medium transition-all text-sm">
        Clear
    </a>
</form>