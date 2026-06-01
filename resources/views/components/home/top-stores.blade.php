{{-- Top Rated Stores — supports two layouts:
     :grid="false" (default) → compact sidebar list  (used in sidebars)
     :grid="true"            → 3-column card grid     (used on homepage)  --}}
@props([
    'topStores' => collect(),
    'grid'      => false,
])

@if($topStores && $topStores->count() > 0)

{{-- ═══ SHARED HEADER ════════════════════════════════════════════════ --}}
<div>
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-base sm:text-lg font-extrabold text-gray-800">
            {{ __('Top Rated Stores') }}
        </h2>
        <a href="{{ route('stores.index') }}"
           class="inline-flex items-center gap-1 text-sm font-semibold
                  text-pink-500 hover:text-pink-600 transition-colors">
            {{ __('View All') }}
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>

    @if($grid)
    {{-- ═══ GRID LAYOUT (homepage) — AliExpress / Lazada Mall style ═════ --}}
    <div class="grid grid-cols-2 gap-3">
        @foreach($topStores->take(4) as $store)
        @php
            $avgRating  = $store->receivedStoreReviews()->avg('rating') ?? 0;
            $reviewCnt  = $store->receivedStoreReviews()->count();
            $initial    = strtoupper(substr($store->store_name ?? 'S', 0, 1));
            $colors     = ['from-pink-400 to-rose-500','from-orange-400 to-pink-500','from-fuchsia-400 to-pink-500','from-rose-400 to-orange-500','from-pink-500 to-fuchsia-500','from-orange-500 to-rose-500'];
            $color      = $colors[($store->id ?? 0) % count($colors)];
            $logoSrc    = !empty($store->store_logo) && !filter_var($store->store_logo, FILTER_VALIDATE_URL)
                ? asset('storage/' . ltrim($store->store_logo, '/'))
                : ($store->store_logo ?? null);
            $topPreview = $store->products()
                ->where('is_active', true)
                ->latest()->limit(3)->get();
        @endphp
        <a href="{{ route('stores.show', $store->slug) }}"
           class="bg-white rounded-xl border border-pink-100 p-3
                  hover:shadow-md hover:border-pink-300 hover:-translate-y-0.5
                  transition-all duration-300 group flex flex-col">

            {{-- ── Top: Logo + name + rating ───────────────────────── --}}
            <div class="flex items-center gap-2.5">
                {{-- Logo --}}
                <div class="relative w-11 h-11 rounded-xl overflow-hidden flex-shrink-0 border border-pink-100">
                    <div class="absolute inset-0 flex items-center justify-center
                                bg-gradient-to-br {{ $color }} text-white font-extrabold text-base">
                        {{ $initial }}
                    </div>
                    @if($logoSrc)
                    <img src="{{ $logoSrc }}" alt="{{ $store->store_name }}"
                         class="relative w-full h-full object-cover"
                         onerror="this.style.display='none'">
                    @endif
                </div>

                {{-- Name + Mall badge + rating --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-1 min-w-0">
                        <p class="text-sm font-extrabold text-gray-800 truncate group-hover:text-pink-600 transition-colors">
                            {{ $store->store_name }}
                        </p>
                        @if($avgRating >= 4.5)
                        <span class="flex-shrink-0 inline-block px-1 py-0.5 rounded
                                     bg-rose-500 text-white text-[8px] font-extrabold leading-none">{{ __('MALL') }}</span>
                        @endif
                    </div>
                    @if($avgRating > 0)
                    <div class="flex items-center gap-1 mt-0.5">
                        <svg class="w-3 h-3 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-[11px] font-bold text-gray-700">{{ number_format($avgRating, 1) }}</span>
                        <span class="text-[10px] text-gray-400">|</span>
                        <span class="text-[10px] text-gray-500">{{ number_format($store->products_count ?? 0) }} {{ __('items') }}</span>
                    </div>
                    @else
                    <p class="text-[10px] text-gray-400 mt-0.5">
                        {{ number_format($store->products_count ?? 0) }} {{ __('items') }} · {{ __('New store') }}
                    </p>
                    @endif
                </div>
            </div>

            {{-- ── Middle: 3 product preview thumbnails ─────────────── --}}
            <div class="grid grid-cols-3 gap-1.5 mt-3">
                @forelse($topPreview as $prev)
                    @php
                        $isOnSale = $prev->on_sale && $prev->sale_price && $prev->price > 0 && $prev->sale_price < $prev->price;
                        $prevDisc = $isOnSale ? (int)round(100 - ($prev->sale_price / $prev->price * 100)) : 0;
                    @endphp
                    <div class="relative aspect-square rounded-lg overflow-hidden bg-rose-50 border border-pink-100">
                        <img src="{{ $prev->image_url }}" alt="{{ $prev->name }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy"
                             onerror="this.style.display='none'">
                        @if($prevDisc > 0)
                        <span class="absolute top-0.5 left-0.5 px-1 py-0 rounded
                                     bg-rose-500 text-white text-[8px] font-extrabold leading-tight">
                            -{{ $prevDisc }}%
                        </span>
                        @endif
                    </div>
                @empty
                    @for($i = 0; $i < 3; $i++)
                    <div class="aspect-square rounded-lg bg-rose-50 border border-pink-100"></div>
                    @endfor
                @endforelse
            </div>

            {{-- ── Bottom: Visit Store CTA ─────────────────────────── --}}
            <div class="mt-3 inline-flex items-center justify-center gap-1 py-1.5 rounded-lg
                        bg-pink-50 text-pink-600 text-[11px] font-bold
                        group-hover:bg-gradient-to-r group-hover:from-pink-500 group-hover:to-rose-500
                        group-hover:text-white transition-all">
                {{ __('Visit Store') }}
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </a>
        @endforeach
    </div>

    @else
    {{-- ═══ SIDEBAR LIST LAYOUT (default) ════════════════════════════ --}}
    <div class="bg-white rounded-xl border border-rose-100 overflow-hidden divide-y divide-rose-50">
        @foreach($topStores->take(6) as $store)
        @php
            $avgRating  = $store->receivedStoreReviews()->avg('rating') ?? 0;
            $ratingDisp = number_format($avgRating, 1);
        @endphp
        <a href="{{ route('stores.show', $store->slug) }}"
           class="flex items-center gap-3 px-4 py-3 hover:bg-rose-50/60 transition-colors group">

            {{-- Logo --}}
            @php
                $initial = strtoupper(substr($store->store_name ?? 'S', 0, 1));
                $colors  = ['from-pink-400 to-rose-500','from-orange-400 to-pink-500','from-fuchsia-400 to-pink-500','from-rose-400 to-orange-500','from-pink-500 to-fuchsia-500','from-orange-500 to-rose-500'];
                $color   = $colors[($store->id ?? 0) % count($colors)];
                $logoSrc = !empty($store->store_logo) && !filter_var($store->store_logo, FILTER_VALIDATE_URL)
                    ? asset('storage/' . ltrim($store->store_logo, '/'))
                    : ($store->store_logo ?? null);
            @endphp
            <div class="relative w-10 h-10 rounded-xl overflow-hidden flex-shrink-0 border border-rose-100">
                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br {{ $color }} text-white font-bold text-sm">
                    {{ $initial }}
                </div>
                @if($logoSrc)
                <img src="{{ $logoSrc }}"
                     alt="{{ $store->store_name }}"
                     class="relative w-full h-full object-cover"
                     onerror="this.style.display='none'">
                @endif
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate group-hover:text-pink-500 transition-colors">
                    {{ $store->store_name }}
                </p>
                @if($store->relationLoaded('categories') && $store->categories->isNotEmpty())
                <p class="text-[11px] text-gray-400 truncate">
                    {{ $store->categories->first()->name }}
                </p>
                @elseif(($store->products_count ?? 0) > 0)
                <p class="text-[11px] text-gray-400">
                    {{ number_format($store->products_count) }} {{ __('products') }}
                </p>
                @endif
            </div>

            {{-- Rating --}}
            @if($avgRating > 0)
            <div class="flex items-center gap-0.5 flex-shrink-0">
                <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-xs font-bold text-gray-700">{{ $ratingDisp }}</span>
            </div>
            @endif

        </a>
        @endforeach
    </div>
    @endif

</div>
@endif
