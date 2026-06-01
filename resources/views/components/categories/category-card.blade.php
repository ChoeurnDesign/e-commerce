@props(['parentCategories' => null, 'title' => 'Categories'])

@php
    use Illuminate\Support\Str;

    $categories = collect($parentCategories ?? [])->map(function($c){
        $imageUrl = null;
        if (!empty($c->image)) {
            $imageUrl = (str_starts_with($c->image, 'http') || filter_var($c->image, FILTER_VALIDATE_URL))
                ? $c->image
                : asset('storage/' . $c->image);
        }
        if (!$imageUrl) {
            $imageUrl = \App\Helpers\PlaceholderAvatar::svgDataUri($c->name ?? 'Category');
        }
        return (object)[
            'id' => $c->id ?? null,
            'name' => $c->name ?? 'Untitled Category',
            'slug' => $c->slug ?? null,
            'description' => $c->description ?? '',
            'image' => $imageUrl,
            'productsCount' => $c->total_products_count ?? $c->products_count ?? 0,
            'children' => $c->children ?? collect(),
        ];
    });

    /* Sort: categories with products first, by product count desc */
    $categories = $categories->sortByDesc('productsCount')->values();
@endphp

<div>
    {{-- Section heading --}}
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900 flex items-center gap-2">
                <span class="w-1.5 h-6 rounded-full bg-gradient-to-b from-pink-500 to-rose-500"></span>
                {{ __($title) }}
            </h2>
            <p class="text-xs text-gray-500 mt-1 ml-3.5">
                {{ $categories->count() }} {{ __('curated collections') }} · {{ __('updated daily') }}
            </p>
        </div>
        <div class="text-xs text-gray-500 hidden sm:flex items-center gap-1.5">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            {{ __('Live inventory') }}
        </div>
    </div>

    @if($categories->isNotEmpty())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach($categories as $idx => $category)
            @php
                $accents = [
                    ['bg' => 'from-pink-500/90 to-rose-500/90',     'tag' => 'bg-pink-50 text-pink-600'],
                    ['bg' => 'from-orange-500/90 to-amber-500/90',  'tag' => 'bg-orange-50 text-orange-600'],
                    ['bg' => 'from-violet-500/90 to-fuchsia-500/90','tag' => 'bg-violet-50 text-violet-600'],
                    ['bg' => 'from-emerald-500/90 to-teal-500/90',  'tag' => 'bg-emerald-50 text-emerald-600'],
                    ['bg' => 'from-rose-500/90 to-orange-500/90',   'tag' => 'bg-rose-50 text-rose-600'],
                    ['bg' => 'from-cyan-500/90 to-blue-500/90',     'tag' => 'bg-cyan-50 text-cyan-600'],
                ];
                $a = $accents[$idx % count($accents)];
                $hasProducts = $category->productsCount > 0;
            @endphp
            <a @if($category->slug) href="{{ route('category.show', $category->slug) }}" @endif
               class="group block bg-white rounded-2xl border border-pink-100 overflow-hidden
                      hover:border-pink-300 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">

                {{-- Image with gradient overlay --}}
                <div class="relative aspect-[5/3] overflow-hidden bg-gray-100">
                    <img src="{{ $category->image }}" alt="{{ $category->name }}"
                         loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x240/fdf2f8/f9a8d4?text={{ urlencode(substr($category->name, 0, 1)) }}'">

                    {{-- Clean dark fade overlay (only on hover, full image) --}}
                    <div class="absolute inset-0 bg-black/35 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    {{-- Top badges --}}
                    <div class="absolute top-2.5 left-2.5 flex gap-1.5">
                        @if($hasProducts)
                            <span class="px-2.5 py-1 rounded-full bg-white/95 backdrop-blur-sm text-[10px] font-extrabold {{ $a['tag'] }} shadow-sm">
                                {{ $category->productsCount }} {{ Str::plural('item', $category->productsCount) }}
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-full bg-white/95 backdrop-blur-sm text-[10px] font-bold text-gray-500 shadow-sm">
                                {{ __('Coming soon') }}
                            </span>
                        @endif
                    </div>

                    {{-- "Trending" badge on top 3 most popular --}}
                    @if($idx < 3 && $hasProducts)
                    <div class="absolute top-2.5 right-2.5">
                        <span class="flex items-center gap-1 px-2 py-1 rounded-full bg-rose-500 text-white text-[10px] font-extrabold shadow-md">
                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A3 3 0 0112.12 15.12z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('TRENDING') }}
                        </span>
                    </div>
                    @endif

                    {{-- Hover "Explore" overlay button --}}
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 pointer-events-none">
                        <span class="px-4 py-2 rounded-full bg-white text-pink-600 font-extrabold text-xs shadow-lg flex items-center gap-1.5">
                            {{ __('Explore') }}
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Body --}}
                <div class="p-4">
                    <h3 class="text-base font-extrabold text-gray-900 truncate group-hover:text-pink-600 transition-colors">
                        {{ $category->name }}
                    </h3>
                    @if($category->description)
                        <p class="mt-1 text-xs text-gray-500 line-clamp-2 leading-relaxed min-h-[32px]">{{ $category->description }}</p>
                    @else
                        <p class="mt-1 text-xs text-gray-400 italic min-h-[32px]">{{ __('Explore the collection') }}</p>
                    @endif

                    {{-- Subcategory chips --}}
                    @if($category->children && $category->children->count() > 0)
                    <div class="mt-3 flex flex-wrap gap-1.5">
                        @foreach($category->children->slice(0, 3) as $sub)
                            @php $sCount = $sub->total_products_count ?? $sub->products_count ?? 0; @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-pink-50 text-[10px] font-semibold text-pink-600">
                                {{ Str::limit($sub->name ?? 'Sub', 14) }}
                                @if($sCount > 0)
                                    <span class="text-pink-400">({{ $sCount }})</span>
                                @endif
                            </span>
                        @endforeach
                        @if($category->children->count() > 3)
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-semibold text-gray-500">
                                +{{ $category->children->count() - 3 }}
                            </span>
                        @endif
                    </div>
                    @endif

                    {{-- Footer --}}
                    <div class="mt-3 pt-3 border-t border-pink-50 flex items-center justify-between text-[11px]">
                        <span class="text-gray-400 font-medium flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('Updated daily') }}
                        </span>
                        @if($category->slug)
                        <span class="inline-flex items-center gap-1 text-pink-500 font-bold group-hover:text-pink-700 transition-colors">
                            {{ __('View') }}
                            <svg class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    @else
        {{-- Empty state --}}
        <div class="py-16 text-center bg-white rounded-2xl border border-pink-100">
            <div class="mx-auto w-20 h-20 rounded-full bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-pink-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <h3 class="text-lg font-extrabold text-gray-800 mb-1">{{ __('No categories yet') }}</h3>
            <p class="text-sm text-gray-500 mb-5">{{ __('Categories will appear here once they are added') }}</p>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold py-2.5 px-6 rounded-full text-sm shadow-md transition-all">
                {{ __('Browse all products') }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    @endif
</div>
