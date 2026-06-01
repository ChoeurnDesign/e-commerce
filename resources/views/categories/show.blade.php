<x-app-layout>

    @php
        $imageSrc = $category->image_url ?? asset('/img/default-category.png');
        $productsCount = $products->total() ?? (is_countable($products) ? count($products) : 0);
        $subCount = $subcategories->count() ?? 0;
        $altText = $category->image_alt ?? $category->name;

        /* Stats from the actual category data */
        $sellersInCat = \App\Models\Product::where('category_id', $category->id)
            ->where('is_active', true)->distinct('seller_id')->count('seller_id');
        $avgRating = $products->avg('average_rating') ?? 0;
    @endphp

    {{-- ═══ HERO BANNER ══════════════════════════════════════════════ --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0" style="background:linear-gradient(135deg,#FFB3CC 0%,#FFCCE0 50%,#FFE0EE 100%)"></div>
        <div class="absolute -top-12 -right-12 w-80 h-80 rounded-full bg-white/15 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-10 w-72 h-72 rounded-full bg-white/15 blur-3xl"></div>

        <div class="relative max-w-full mx-auto px-6 sm:px-10 lg:px-16 py-8 sm:py-10">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-pink-800/70 mb-4 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-pink-900 font-medium">{{ __('Home') }}</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('categories.index') }}" class="hover:text-pink-900 font-medium">{{ __('Categories') }}</a>
                @foreach($breadcrumb as $crumb)
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    @if($loop->last)
                        <span class="text-pink-900 font-bold">{{ $crumb->name }}</span>
                    @else
                        <a href="{{ route('category.show', $crumb->slug) }}" class="hover:text-pink-900 font-medium">{{ $crumb->name }}</a>
                    @endif
                @endforeach
            </nav>

            <div class="flex flex-col md:flex-row items-center gap-6">
                {{-- Big image card --}}
                <div class="relative w-32 h-32 sm:w-40 sm:h-40 rounded-2xl overflow-hidden bg-white shadow-lg border-4 border-white flex-shrink-0">
                    <img src="{{ $imageSrc }}" alt="{{ $altText }}"
                         class="w-full h-full object-cover"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='{{ asset('/img/default-category.png') }}'">
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0 text-center md:text-left">
                    <span class="inline-block px-3 py-1 bg-white/70 backdrop-blur-sm text-pink-700 text-[10px] font-extrabold uppercase tracking-wider rounded-full mb-2">
                        {{ __('Category') }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-900 leading-tight">
                        {{ $category->name }}
                    </h1>
                    @if(!empty($category->description))
                        <p class="mt-2 text-sm text-gray-700 max-w-2xl">{{ $category->description }}</p>
                    @else
                        <p class="mt-2 text-sm text-gray-600 max-w-2xl">{{ __('Explore our curated collection of') }} {{ strtolower($category->name) }}.</p>
                    @endif

                    {{-- Stats pills --}}
                    <div class="mt-4 flex flex-wrap items-center justify-center md:justify-start gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/90 backdrop-blur-sm text-xs font-bold text-gray-800 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            {{ $productsCount }} {{ __('products') }}
                        </span>
                        @if($subCount > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/90 backdrop-blur-sm text-xs font-bold text-gray-800 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                            </svg>
                            {{ $subCount }} {{ __('subcategories') }}
                        </span>
                        @endif
                        @if($sellersInCat > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/90 backdrop-blur-sm text-xs font-bold text-gray-800 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72l1.189-1.19A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72M6.75 18h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .414.336.75.75.75z"/>
                            </svg>
                            {{ $sellersInCat }} {{ __('sellers') }}
                        </span>
                        @endif
                        @if($avgRating > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/90 backdrop-blur-sm text-xs font-bold text-gray-800 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            {{ number_format($avgRating, 1) }} {{ __('avg rating') }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16 py-6">

        {{-- ═══ SUBCATEGORIES ═══════════════════════════════════════════ --}}
        @if($subcategories->count() > 0)
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base sm:text-lg font-extrabold text-gray-900 flex items-center gap-2">
                    <span class="w-1.5 h-5 rounded-full bg-gradient-to-b from-pink-500 to-rose-500"></span>
                    {{ __('Subcategories') }}
                </h2>
                <span class="text-xs text-gray-500 font-medium">{{ $subcategories->count() }} {{ __('available') }}</span>
            </div>

            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                @foreach($subcategories as $idx => $subcategory)
                    @php
                        $subImg = !empty($subcategory->image)
                            ? (filter_var($subcategory->image, FILTER_VALIDATE_URL) ? $subcategory->image : asset('storage/' . $subcategory->image))
                            : null;
                        $palettes = [
                            ['bg' => '#FFE4E6', 'fg' => '#E11D48'],
                            ['bg' => '#FFEDD5', 'fg' => '#EA580C'],
                            ['bg' => '#FCE7F3', 'fg' => '#DB2777'],
                            ['bg' => '#FEF3C7', 'fg' => '#D97706'],
                            ['bg' => '#DCFCE7', 'fg' => '#16A34A'],
                            ['bg' => '#DBEAFE', 'fg' => '#2563EB'],
                            ['bg' => '#FAE8FF', 'fg' => '#C026D3'],
                            ['bg' => '#EDE9FE', 'fg' => '#7C3AED'],
                        ];
                        $p = $palettes[$idx % count($palettes)];
                        $subInitial = strtoupper(mb_substr($subcategory->name, 0, 1));
                    @endphp
                    <a href="{{ route('category.show', $category->slug) }}?subcategory={{ $subcategory->slug }}"
                       class="group bg-white border border-pink-100 rounded-2xl p-3 text-center hover:border-pink-300 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="relative w-14 h-14 mx-auto rounded-xl overflow-hidden flex items-center justify-center mb-2"
                             style="background:{{ $p['bg'] }}">
                            <span class="text-xl font-extrabold" style="color:{{ $p['fg'] }}">{{ $subInitial }}</span>
                            @if($subImg)
                            <img src="{{ $subImg }}" alt="{{ $subcategory->name }}"
                                 class="absolute inset-0 w-full h-full object-cover"
                                 onerror="this.style.display='none'">
                            @endif
                        </div>
                        <p class="text-[11px] font-bold text-gray-800 line-clamp-1 group-hover:text-pink-600 transition-colors">
                            {{ $subcategory->name }}
                        </p>
                        <p class="text-[10px] text-gray-400 mt-0.5">
                            {{ $subcategory->total_products_count ?? 0 }} {{ __('items') }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ═══ FILTERS BAR ══════════════════════════════════════════════ --}}
        <div class="bg-white border border-pink-100 rounded-2xl p-3 mb-5 shadow-sm">
            <form method="GET" action="{{ route('category.show', $category->slug) }}"
                  class="flex flex-wrap gap-2 items-center">
                @if(request('subcategory'))<input type="hidden" name="subcategory" value="{{ request('subcategory') }}">@endif

                {{-- Search --}}
                <div class="relative flex-1 min-w-[200px]">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-pink-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="{{ __('Search in') }} {{ $category->name }}..."
                           class="w-full pl-9 pr-3 py-2 bg-rose-50/50 border border-pink-100 rounded-full text-sm
                                  focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-300 transition-all">
                </div>

                {{-- Min / Max --}}
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="{{ __('Min') }} $"
                       class="w-20 px-3 py-2 bg-rose-50/50 border border-pink-100 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-pink-200">
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="{{ __('Max') }} $"
                       class="w-20 px-3 py-2 bg-rose-50/50 border border-pink-100 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-pink-200">

                {{-- Sort --}}
                <select name="sort"
                        class="px-4 py-2 bg-rose-50/50 border border-pink-100 rounded-full text-sm font-medium focus:outline-none focus:ring-2 focus:ring-pink-200">
                    <option value="latest"     {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('Latest') }}</option>
                    <option value="featured"   {{ request('sort') == 'featured' ? 'selected' : '' }}>{{ __('Featured') }}</option>
                    <option value="name"       {{ request('sort') == 'name' ? 'selected' : '' }}>{{ __('Name A-Z') }}</option>
                    <option value="price_low"  {{ request('sort') == 'price_low' ? 'selected' : '' }}>{{ __('Price: Low → High') }}</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>{{ __('Price: High → Low') }}</option>
                </select>

                {{-- Buttons --}}
                <button type="submit"
                        class="px-5 py-2 bg-gradient-to-r from-orange-500 to-rose-500 hover:from-orange-600 hover:to-rose-600 text-white rounded-full text-sm font-bold shadow-sm transition-all">
                    {{ __('Apply') }}
                </button>
                @if(request()->hasAny(['search','min_price','max_price','sort','subcategory']))
                <a href="{{ route('category.show', $category->slug) }}"
                   class="px-4 py-2 bg-white border border-pink-200 text-pink-600 hover:bg-pink-50 rounded-full text-sm font-bold transition-colors">
                    {{ __('Clear') }}
                </a>
                @endif
            </form>
        </div>

        {{-- ═══ RESULTS BAR ══════════════════════════════════════════════ --}}
        <div class="flex items-center justify-between mb-4">
            <p class="text-xs text-gray-600">
                {{ __('Showing') }}
                <span class="font-bold text-gray-900">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</span>
                {{ __('of') }}
                <span class="font-bold text-pink-600">{{ $products->total() }}</span>
                {{ __('results') }}
            </p>
            @if(request('search'))
            <p class="text-xs text-gray-500 italic">
                {{ __('Matching') }} "<span class="font-bold text-pink-600">{{ request('search') }}</span>"
            </p>
            @endif
        </div>

        {{-- ═══ PRODUCTS GRID ═══════════════════════════════════════════ --}}
        @if($products->count() > 0)
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-3 sm:gap-4 mb-8">
                @foreach($products as $product)
                    <x-products.product-card :product="$product" :compact="true" />
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
        @else
            <div class="bg-white border border-pink-100 rounded-2xl py-16 px-6 text-center">
                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-pink-100 to-rose-100 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-extrabold text-gray-800 mb-1">{{ __('No products found') }}</h3>
                <p class="text-sm text-gray-500 mb-5 max-w-md mx-auto">
                    {{ __('Try adjusting your filters or browse all products in this category.') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-2 justify-center">
                    <a href="{{ route('category.show', $category->slug) }}"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white border border-pink-200 text-pink-600 rounded-full text-sm font-bold hover:bg-pink-50 transition-colors">
                        {{ __('Clear filters') }}
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-full text-sm font-bold shadow-md hover:shadow-lg transition-all">
                        {{ __('Browse all products') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        @endif
    </div>

</x-app-layout>
