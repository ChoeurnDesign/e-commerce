{{-- resources/views/stores/index.blade.php --}}
<x-app-layout>
    <div class="py-8 min-h-screen">
        <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16">

            {{-- Header --}}
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">All Stores</h1>
                <p class="text-gray-500 text-sm">Browse our verified sellers and find your favourites</p>
            </div>

            {{-- Filter/Search Bar --}}
            <x-store.search-filters />

            {{-- Results Info --}}
            <div class="mb-6 text-sm text-gray-500">
                <span class="font-semibold text-gray-700">{{ number_format($sellers->total()) }}</span> stores found
                @if(request('search'))
                    for "<span class="italic text-pink-600">{{ request('search') }}</span>"
                @endif
            </div>

            {{-- Stores Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($sellers as $seller)
                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm
                                hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group relative overflow-hidden flex flex-col">

                        {{-- Featured badge --}}
                        @if($seller->is_featured ?? false)
                            <span class="absolute top-3 left-3 z-10 bg-gradient-to-r from-pink-500 to-yellow-500 text-white text-xs font-bold px-2.5 py-0.5 rounded-full shadow">
                                Featured
                            </span>
                        @endif

                        {{-- Banner + logo --}}
                        <x-store.banner-header
                            :seller="$seller"
                            logoClass="w-24 h-24"
                            bannerClass="h-28"
                            bannerFontClass="text-xl"
                            logoOffset="-bottom-14"
                        />

                        <div class="px-4 pb-4 pt-6 text-center flex-1 flex flex-col">
                            <h2 class="text-base font-semibold text-gray-900 truncate mt-10 mb-0.5">
                                {{ $seller->store_name ?? $seller->name }}
                            </h2>
                            <p class="text-xs text-gray-400 truncate mb-3">@{{ $seller->slug }}</p>

                            {{-- Product thumbnails (up to 3) --}}
                            @if($seller->products && $seller->products->count())
                                <div class="flex justify-center gap-1 mb-3">
                                    @foreach($seller->products->take(3) as $product)
                                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200">
                                            <img src="{{ $product->image_url }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-full h-full object-cover"
                                                 onerror="this.onerror=null;this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            {{-- Fallback icon (hidden by default) --}}
                                            <span style="display:none" class="w-full h-full items-center justify-center">
                                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Stats row --}}
                            <div class="flex justify-center gap-4 text-xs text-gray-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    {{ $seller->products_count ?? 0 }} Products
                                </span>
                                <span>{{ $seller->followers_count ?? 0 }} followers</span>
                            </div>

                            <div class="mt-auto flex items-center gap-2 w-full justify-between">

                                {{-- Star rating --}}
                                @php
                                    $sellerRevColl = $seller->storeReviews;
                                    $revCount = $sellerRevColl->count();
                                    $revAvg   = $revCount > 0 ? round($sellerRevColl->avg('rating'), 1) : 0;
                                @endphp
                                <div class="flex items-center gap-0.5">
                                    @if($revCount > 0)
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($revAvg >= $i)
                                                <x-icon-dashboard name="star-filled" class="w-3.5 h-3.5 text-yellow-400" />
                                            @else
                                                <x-icon-dashboard name="star-empty" class="w-3.5 h-3.5 text-gray-300" />
                                            @endif
                                        @endfor
                                        <span class="ml-1 text-xs text-gray-400">{{ $revAvg }}</span>
                                    @else
                                        <span class="text-xs text-gray-400">No ratings</span>
                                    @endif
                                </div>

                                <a href="{{ route('stores.show', $seller) }}"
                                   class="bg-pink-500 text-white px-3.5 py-1.5 rounded-full font-semibold shadow-sm hover:bg-pink-600 transition text-xs">
                                    View Store
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-16 text-gray-400">No stores found.</div>
                @endforelse
            </div>

            <div class="mt-10 flex justify-center">
                {{ $sellers->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

