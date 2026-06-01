@props([
    'banners'       => null,
    'storefrontTitle' => '',
    'welcomeMessage'  => '',
    'categories'      => collect(),
    'saleProducts'    => collect(),
    'newArrivals'     => collect(),
])

@php
    $highlights = collect($saleProducts)
        ->filter(fn($p) => $p->on_sale && $p->sale_price && $p->sale_price < $p->price)
        ->take(3);

    /* Cohesive color palette — rotates by category index for clean visual rhythm */
    $catColors = [
        ['bg' => '#FFE4E6', 'fg' => '#E11D48'], // rose
        ['bg' => '#FFEDD5', 'fg' => '#EA580C'], // orange
        ['bg' => '#FCE7F3', 'fg' => '#DB2777'], // pink
        ['bg' => '#FEF3C7', 'fg' => '#D97706'], // amber
        ['bg' => '#FAE8FF', 'fg' => '#C026D3'], // fuchsia
        ['bg' => '#DCFCE7', 'fg' => '#16A34A'], // green
        ['bg' => '#DBEAFE', 'fg' => '#2563EB'], // blue
        ['bg' => '#EDE9FE', 'fg' => '#7C3AED'], // violet
    ];
@endphp

<div class="bg-transparent">
    <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16 pt-2 pb-0">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 items-start h-auto">

            {{-- ═══ LEFT: Category Sidebar ════════════════════════════════ --}}
            <div class="hidden lg:flex lg:col-span-2 h-[320px]">
                <div class="w-full bg-white border border-pink-100 rounded-2xl overflow-hidden flex flex-col shadow-sm">

                    {{-- Header --}}
                    <div class="flex items-center gap-2 px-4 py-3 border-b border-pink-50 flex-shrink-0
                                bg-gradient-to-r from-pink-50/70 to-rose-50/50">
                        <div class="w-6 h-6 rounded-2xl bg-pink-500 flex items-center justify-center shadow-sm">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </div>
                        <span class="text-sm font-extrabold text-gray-800">{{ __('Categories') }}</span>
                    </div>

                    {{-- List --}}
                    <div class="flex-1 min-h-0 overflow-y-auto scrollbar-hide py-1">
                        @foreach($categories->take(10) as $idx => $category)
                            @php
                                $clr = $catColors[$idx % count($catColors)];
                                $imgUrl = $category->image
                                    ? (filter_var($category->image, FILTER_VALIDATE_URL) ? $category->image : asset('storage/' . ltrim($category->image, '/')))
                                    : null;
                                $initial = strtoupper(mb_substr($category->name, 0, 1));
                            @endphp
                        <a href="{{ route('category.show', $category->slug) }}"
                           class="group flex items-center gap-2.5 px-3 py-1.5 hover:bg-pink-50/60 transition-colors">

                            {{-- Icon: image OR colored initial --}}
                            <div class="relative w-7 h-7 rounded-2xl overflow-hidden flex-shrink-0 flex items-center justify-center"
                                 style="background:{{ $clr['bg'] }};">
                                <span class="text-[11px] font-extrabold" style="color:{{ $clr['fg'] }}">{{ $initial }}</span>
                                @if($imgUrl)
                                <img src="{{ $imgUrl }}"
                                     alt="{{ $category->name }}"
                                     class="absolute inset-0 w-full h-full object-cover"
                                     onerror="this.style.display='none'">
                                @endif
                            </div>

                            <span class="text-xs font-medium text-gray-700 truncate flex-1 group-hover:text-pink-600 group-hover:font-semibold transition-colors">
                                {{ $category->name }}
                            </span>

                            <svg class="w-3 h-3 text-gray-300 group-hover:text-pink-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @endforeach
                    </div>

                    {{-- Footer --}}
                    <a href="{{ route('categories.index') }}"
                       class="flex items-center justify-center gap-1 px-4 py-2.5 border-t border-pink-50
                              text-xs font-bold text-pink-600 hover:text-white hover:bg-pink-500 transition-colors">
                        {{ __('View All') }}
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- ═══ CENTER: Banner Slider ══════════════════════════════════ --}}
            {{-- Banner + 2 Mini Promo Tiles --}}
            <div class="lg:col-span-7 h-[260px] sm:h-[300px] lg:h-[320px] flex gap-3">

                {{-- Banner --}}
                <div class="flex-1 min-w-0 h-full">
                    <x-home.banner-slider :banners="$banners" :storefront-title="$storefrontTitle" :welcome-message="$welcomeMessage" :compact="true" />
                </div>

                {{-- 2 Stacked Mini Promo Tiles — desktop only --}}
                @php
                    $trendingPick = collect($newArrivals)->first() ?? collect($saleProducts)->skip(1)->first();
                    $salePick     = collect($saleProducts)->first();
                @endphp
                <div class="hidden lg:flex flex-col gap-3 w-36 flex-shrink-0 h-full">

                    {{-- ═══ Tile 1: Trending Now ═══════════════════════════ --}}
                    <a href="{{ route('products.index', ['sort' => 'latest']) }}"
                       class="flex-1 relative rounded-2xl overflow-hidden shadow-sm
                              hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group">

                        {{-- Full background product image --}}
                        @if($trendingPick)
                            <img src="{{ $trendingPick->image_url }}"
                                 alt="{{ $trendingPick->name }}"
                                 class="absolute inset-0 w-full h-full object-cover
                                        group-hover:scale-110 transition-transform duration-500"
                                 onerror="this.style.display='none'">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center
                                        bg-gradient-to-br from-orange-100 to-amber-50">
                                <svg class="w-10 h-10 text-orange-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A3 3 0 0112.12 15.12z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Soft top-to-bottom gradient overlay --}}
                        <div class="absolute inset-0 z-[1]"
                             style="background:linear-gradient(180deg,rgba(255,138,76,0.55) 0%,rgba(255,160,112,0.18) 38%,rgba(255,255,255,0) 60%,rgba(0,0,0,0) 100%)"></div>

                        {{-- Header overlay (top) --}}
                        <div class="absolute top-0 left-0 right-0 z-10 px-3 pt-2.5 pb-2">
                            <div class="flex items-center gap-1 mb-0.5">
                                <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-white/90 shadow-sm">
                                    <svg class="w-2.5 h-2.5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A3 3 0 0112.12 15.12z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                                <span class="text-[9px] font-extrabold uppercase tracking-wider text-white drop-shadow">{{ __('Trending') }}</span>
                            </div>
                            <h3 class="text-[13px] font-extrabold text-white leading-tight drop-shadow">
                                {{ __('Hot Picks') }}
                            </h3>
                        </div>

                        {{-- CTA pill (bottom-right) --}}
                        <div class="absolute bottom-1.5 right-1.5 z-10 px-2 py-1 rounded-full bg-white/95 backdrop-blur-sm shadow-sm
                                    flex items-center gap-0.5 group-hover:bg-orange-500 transition-colors">
                            <span class="text-[9px] font-bold text-orange-600 group-hover:text-white">{{ __('Shop') }}</span>
                            <svg class="w-2.5 h-2.5 text-orange-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    {{-- ═══ Tile 2: Seasonal Deals ═════════════════════════ --}}
                    <a href="{{ route('products.shops_on_sale') }}"
                       class="flex-1 relative rounded-2xl overflow-hidden shadow-sm
                              hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 group">

                        {{-- Full background product image --}}
                        @if($salePick)
                            <img src="{{ $salePick->image_url }}"
                                 alt="{{ $salePick->name }}"
                                 class="absolute inset-0 w-full h-full object-cover
                                        group-hover:scale-110 transition-transform duration-500"
                                 onerror="this.style.display='none'">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center
                                        bg-gradient-to-br from-pink-100 to-rose-50">
                                <svg class="w-10 h-10 text-pink-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z"/>
                                    <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Soft top-to-bottom gradient overlay --}}
                        <div class="absolute inset-0 z-[1]"
                             style="background:linear-gradient(180deg,rgba(236,72,153,0.55) 0%,rgba(244,114,182,0.18) 38%,rgba(255,255,255,0) 60%,rgba(0,0,0,0) 100%)"></div>

                        {{-- Header overlay (top) --}}
                        <div class="absolute top-0 left-0 right-0 z-10 px-3 pt-2.5 pb-2">
                            <div class="flex items-center gap-1 mb-0.5">
                                <span class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-white/90 shadow-sm">
                                    <svg class="w-2.5 h-2.5 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M5 5a3 3 0 015-2.236A3 3 0 0114.83 6H16a2 2 0 110 4h-5V9a1 1 0 10-2 0v1H4a2 2 0 110-4h1.17C5.06 5.687 5 5.35 5 5zm4 1V5a1 1 0 10-1 1h1zm3 0a1 1 0 10-1-1v1h1z"/>
                                        <path d="M9 11H3v5a2 2 0 002 2h4v-7zM11 18h4a2 2 0 002-2v-5h-6v7z"/>
                                    </svg>
                                </span>
                                <span class="text-[9px] font-extrabold uppercase tracking-wider text-white drop-shadow">{{ __('Sale') }}</span>
                            </div>
                            <h3 class="text-[13px] font-extrabold text-white leading-tight drop-shadow">
                                {{ __('Mega Deals') }}
                            </h3>
                        </div>

                        {{-- Discount badge --}}
                        @if($salePick && $salePick->price > 0)
                            @php $tileDisc = (int)round(100 - ($salePick->sale_price / $salePick->price * 100)); @endphp
                            @if($tileDisc > 0)
                            <span class="absolute top-1.5 right-1.5 z-10 px-1.5 py-0.5 rounded
                                         bg-rose-500 text-white text-[9px] font-extrabold shadow-sm">
                                -{{ $tileDisc }}%
                            </span>
                            @endif
                        @endif

                        {{-- CTA pill (bottom-right) --}}
                        <div class="absolute bottom-1.5 right-1.5 z-10 px-2 py-1 rounded-full bg-white/95 backdrop-blur-sm shadow-sm
                                    flex items-center gap-0.5 group-hover:bg-pink-500 transition-colors">
                            <span class="text-[9px] font-bold text-pink-600 group-hover:text-white">{{ __('Grab') }}</span>
                            <svg class="w-2.5 h-2.5 text-pink-600 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                </div>
            </div>

            {{-- ═══ RIGHT: Flash Deals ═════════════════════════════════════ --}}
            <div class="hidden lg:flex lg:col-span-3 h-[320px]">
                <div class="w-full bg-white border border-pink-100 rounded-2xl overflow-hidden flex flex-col shadow-sm"
                     x-data="{
                        t: { d:'07', h:'00', m:'00', s:'00' },
                        init() {
                            let end = Date.now() + (7*86400)*1000;
                            setInterval(() => {
                                let r = Math.max(0, (end - Date.now()) / 1000);
                                this.t = {
                                    d: String(Math.floor(r / 86400)).padStart(2, '0'),
                                    h: String(Math.floor((r % 86400) / 3600)).padStart(2, '0'),
                                    m: String(Math.floor((r % 3600) / 60)).padStart(2, '0'),
                                    s: String(Math.floor(r % 60)).padStart(2, '0')
                                };
                            }, 1000);
                        }
                     }">

                    {{-- Header — vivid red→orange gradient like real flash sales --}}
                    <div class="px-4 py-2.5 border-b border-pink-100 flex-shrink-0 relative overflow-hidden"
                         style="background:linear-gradient(135deg,#F43F5E 0%,#FB7185 60%,#FB923C 100%)">
                        <div class="relative z-10 flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm font-extrabold text-white drop-shadow">{{ __('Flash Deals') }}</span>
                            </div>
                            <a href="{{ route('products.shops_on_sale') }}"
                               class="text-[10px] font-bold text-white/95 hover:text-white flex items-center gap-0.5">
                                {{ __('View All') }}
                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    {{-- Countdown Timer — refined --}}
                    <div class="flex items-center justify-center gap-1.5 px-4 py-2 flex-shrink-0
                                bg-gradient-to-r from-rose-50/70 via-orange-50/40 to-rose-50/70">
                        <span class="text-[10px] font-bold text-rose-600 uppercase tracking-wider mr-1">{{ __('Ends in') }}</span>
                        @foreach([['d','D'],['h','H'],['m','M'],['s','S']] as [$k,$lbl])
                        <div class="flex flex-col items-center">
                            <span class="bg-gradient-to-br from-gray-800 to-gray-900 text-white text-[11px] font-extrabold
                                         px-1.5 py-0.5 rounded min-w-[22px] text-center tabular-nums shadow-sm"
                                  x-text="t.{{ $k }}">00</span>
                        </div>
                        @if(!$loop->last)
                        <span class="text-rose-500 font-bold text-xs">:</span>
                        @endif
                        @endforeach
                    </div>

                    {{-- Products list --}}
                    <div class="flex-1 overflow-y-auto p-2.5 space-y-2">
                        @foreach($highlights as $deal)
                            @php
                                $disc = (int)round(100 - ($deal->sale_price / $deal->price * 100));
                                $sold = ($deal->id * 13 + 27) % 200;
                                $barW = min(90, max(25, $disc + 20));
                            @endphp
                            <a href="{{ route('products.show', $deal->slug) }}"
                               class="flex items-center gap-2.5 p-1.5 rounded-2xl hover:bg-rose-50/60 transition-colors group">
                                <div class="relative w-14 h-14 rounded-2xl overflow-hidden bg-rose-50 border border-pink-100 flex-shrink-0">
                                    <img src="{{ $deal->image_url }}" alt="{{ $deal->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                         onerror="this.src='https://placehold.co/56x56/fdf2f8/f9a8d4?text=?'">
                                    @if($disc > 0)
                                    <span class="absolute top-0 left-0 text-[9px] font-extrabold text-white
                                                 bg-gradient-to-br from-rose-500 to-rose-600 px-1 py-0.5 rounded-br-md leading-none">
                                        -{{ $disc }}%
                                    </span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[11px] font-medium text-gray-700 line-clamp-1 group-hover:text-pink-600 transition-colors">
                                        {{ $deal->name }}
                                    </p>
                                    <div class="flex items-baseline gap-1.5 mt-0.5">
                                        <span class="text-sm font-extrabold text-rose-600">
                                            {{ \App\Helpers\CurrencyHelper::format($deal->sale_price) }}
                                        </span>
                                        <span class="text-[9px] text-gray-400 line-through">
                                            {{ \App\Helpers\CurrencyHelper::format($deal->price) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <div class="flex-1 bg-rose-100 rounded-full h-1 overflow-hidden">
                                            <div class="h-1 rounded-full" style="width:{{ $barW }}%;background:linear-gradient(to right,#F97316,#F43F5E)"></div>
                                        </div>
                                        <span class="inline-flex items-center gap-0.5 text-[9px] font-semibold text-rose-500 flex-shrink-0">
                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A3 3 0 0112.12 15.12z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $sold }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>