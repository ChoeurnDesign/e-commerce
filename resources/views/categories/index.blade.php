<x-app-layout>

    @php
        /* Trust strip numbers — real counts */
        $totalCategories = collect($parentCategories ?? [])->count();
        $totalProducts   = \App\Models\Product::where('is_active', true)->count();
        $totalSellers    = \App\Models\Seller::where('status', 'approved')->count();
    @endphp

    {{-- ═══ HERO ═════════════════════════════════════════════════════ --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0" style="background:linear-gradient(135deg,#FFB3CC 0%,#FFCCE0 45%,#FFE0EE 100%)"></div>
        <div class="absolute -top-10 -right-10 w-60 h-60 rounded-full bg-white/20 blur-2xl"></div>
        <div class="absolute -bottom-20 -left-10 w-80 h-80 rounded-full bg-white/15 blur-3xl"></div>

        <div class="relative max-w-full mx-auto px-6 sm:px-10 lg:px-16 py-10 sm:py-14">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-1.5 text-xs text-pink-800/70 mb-3">
                <a href="{{ route('home') }}" class="hover:text-pink-900 font-medium">{{ __('Home') }}</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-pink-900 font-bold">{{ __('Categories') }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-center">
                <div class="lg:col-span-3">
                    <span class="inline-block px-3 py-1 bg-white/70 backdrop-blur-sm text-pink-700 text-[10px] font-extrabold uppercase tracking-wider rounded-full mb-3">
                        {{ __('Discover what you love') }}
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 leading-tight">
                        {{ __('Browse by Category') }}
                    </h1>
                    <p class="mt-2 text-sm sm:text-base text-gray-700 max-w-xl">
                        {{ __('Hand-curated collections from trusted sellers — find exactly what you need across all our verified categories.') }}
                    </p>

                    {{-- Quick popular shortcuts --}}
                    <div class="mt-5 flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold text-gray-700">{{ __('Popular') }}:</span>
                        @php
                            $popularCats = collect($parentCategories ?? [])
                                ->sortByDesc(fn($c) => $c->total_products_count ?? $c->products_count ?? 0)
                                ->take(5);
                        @endphp
                        @foreach($popularCats as $pc)
                            <a href="{{ route('category.show', $pc->slug) }}"
                               class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full bg-white/80 hover:bg-white text-pink-700 text-xs font-semibold shadow-sm hover:shadow transition-all">
                                {{ $pc->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Stats card --}}
                <div class="lg:col-span-2 bg-white/80 backdrop-blur-sm rounded-2xl p-5 border border-white/40 shadow-lg">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-3 text-center">{{ __('Platform at a glance') }}</p>
                    <div class="grid grid-cols-3 gap-3 text-center">
                        <div>
                            <div class="text-2xl font-extrabold text-pink-600">{{ $totalCategories }}</div>
                            <div class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-0.5">{{ __('Categories') }}</div>
                        </div>
                        <div class="border-l border-r border-pink-100">
                            <div class="text-2xl font-extrabold text-orange-600">{{ number_format($totalProducts) }}</div>
                            <div class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-0.5">{{ __('Products') }}</div>
                        </div>
                        <div>
                            <div class="text-2xl font-extrabold text-emerald-600">{{ $totalSellers }}</div>
                            <div class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mt-0.5">{{ __('Sellers') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ TRUST STRIP ══════════════════════════════════════════════ --}}
    <section class="bg-white border-y border-pink-100">
        <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16 py-3">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    ['icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'color' => 'emerald', 'title' => __('Verified Sellers'), 'sub' => __('Every seller is vetted')],
                    ['icon' => 'M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'orange', 'title' => __('Fast Delivery'), 'sub' => __('From any category')],
                    ['icon' => 'M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001z M9 12l2 2 4-4', 'color' => 'pink', 'title' => __('Buyer Protection'), 'sub' => __('100% safe purchases')],
                    ['icon' => 'M21 12a9 9 0 11-18 0 9 9 0 0118 0zM7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-4 4z', 'color' => 'violet', 'title' => __('24/7 Support'), 'sub' => __('We are here to help')],
                ] as $t)
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-{{ $t['color'] }}-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-{{ $t['color'] }}-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $t['icon'] }}"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-extrabold text-gray-900 leading-tight">{{ $t['title'] }}</p>
                        <p class="text-[11px] text-gray-500 leading-tight mt-0.5">{{ $t['sub'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ CATEGORY GRID ════════════════════════════════════════════ --}}
    <section class="max-w-full mx-auto px-6 sm:px-10 lg:px-16 py-8">
        <x-categories.category-card :parentCategories="$parentCategories" />
    </section>

    {{-- ═══ BOTTOM CTA ═══════════════════════════════════════════════ --}}
    <section class="max-w-full mx-auto px-6 sm:px-10 lg:px-16 pb-10">
        <div class="relative overflow-hidden rounded-2xl px-6 sm:px-10 py-8 sm:py-10"
             style="background:linear-gradient(135deg,#FFF1F2 0%,#FFE4E6 100%)">
            <div class="absolute -right-6 -bottom-6 w-40 h-40 rounded-full bg-white/40"></div>
            <div class="absolute right-20 -top-6 w-20 h-20 rounded-full bg-white/30"></div>

            <div class="relative grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                <div class="md:col-span-2">
                    <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900 mb-1">
                        {{ __("Can't find what you're looking for?") }}
                    </h2>
                    <p class="text-sm text-gray-600">
                        {{ __('Browse all products or search by name. Our entire catalog is just one click away.') }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2 md:justify-end">
                    <a href="{{ route('products.index') }}"
                       class="flex items-center justify-center gap-2 bg-white border border-pink-200 text-pink-600 hover:bg-pink-50 px-5 py-2.5 rounded-full font-bold text-sm transition-colors">
                        {{ __('Browse All') }}
                    </a>
                    <a href="{{ route('products.shops_on_sale') }}"
                       class="flex items-center justify-center gap-2 bg-gradient-to-r from-orange-500 to-rose-500 hover:from-orange-600 hover:to-rose-600 text-white px-5 py-2.5 rounded-full font-bold text-sm shadow-md transition-all">
                        {{ __('See Today\'s Deals') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
