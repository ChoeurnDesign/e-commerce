<x-app-layout>
    <div class="py-8 bg-gray-200 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">All Stores</h1>
                <p class="text-gray-600 dark:text-gray-300">Browse all our featured stores and sellers</p>
            </div>

            {{-- Filter/Search Bar --}}
            <x-store.search-filters />

            {{-- Results Info --}}
            <div class="mb-6 text-gray-600 dark:text-gray-400">
                <span class="font-semibold">{{ number_format($sellers->total()) }}</span> stores found
                @if(request('search'))
                    for "<span class="italic text-sky-600 dark:text-sky-400">{{ request('search') }}</span>"
                @endif
            </div>

            {{-- Stores Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @forelse($sellers as $seller)
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:-translate-y-1 hover:scale-105 transition-transform duration-200 group relative overflow-hidden pb-6 flex flex-col">
                        {{-- Featured badge --}}
                        @if($seller->is_featured ?? false)
                            <span class="absolute top-3 left-3 bg-gradient-to-r from-pink-500 to-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Featured</span>
                        @endif

                        <x-store.banner-header 
                            :seller="$seller"
                            logoClass="w-24 h-24"
                            bannerClass="h-28"
                            bannerFontClass="text-xl"
                            logoOffset="-bottom-14"
                        />

                        <div class="px-4 pb-4 pt-6 text-center flex-1 flex flex-col">
                            <h2 class="text-lg truncate mt-10 mb-1 text-gray-900 dark:text-gray-100">{{ $seller->store_name ?? $seller->name }}</h2>
                            
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate mb-2">@ {{ $seller->slug }}</p>
                            
                            {{-- Product thumbnails (show up to 3) --}}
                            @if($seller->products && $seller->products->count())
                                <div class="flex justify-center gap-1 mb-3">
                                    @foreach($seller->products->take(3) as $product)
                                        <img src="{{ $product->image_url ?? asset('images/product-placeholder.png') }}"
                                             alt="{{ $product->name }}"
                                             class="w-8 h-8 rounded object-cover border border-gray-200 dark:border-gray-700">
                                    @endforeach
                                </div>
                            @endif

                            <div class="flex justify-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4">
                                <span>
                                    <i class="fas fa-box"></i>
                                    {{ $seller->products_count ?? $seller->products()->count() }} Products
                                </span>
                                <span class="text-sm text-gray-400">
                                    {{-- use preloaded follower count --}}
                                    {{ $seller->followers_count ?? 0 }} followers
                                </span>
                            </div>

                            <div class="mt-auto flex items-center gap-2 w-full justify-between">
                                {{-- Star rating (dynamic) using preloaded withAvg/withCount --}}
                                @php
                                    $avg = round($seller->storeReviews()->avg('rating'), 1);
                                    $count = $seller->storeReviews()->count();
                                @endphp
                                <div class="flex items-center">
                                    @if($count > 0)
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($avg >= $i)
                                                <span class="text-yellow-400 text-sm">&#9733;</span>
                                            @elseif ($avg > $i - 1)
                                                <span class="text-yellow-400 text-sm">&#9733;</span>
                                            @else
                                                <span class="text-gray-300 dark:text-gray-700 text-sm">&#9733;</span>
                                            @endif
                                        @endfor
                                        <span class="ml-1 text-xs text-gray-400 dark:text-gray-500">
                                            ({{ $avg }}) / {{ $count }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-600 text-xs">No ratings</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('stores.show', $seller) }}"
                                       class="bg-sky-600 dark:bg-sky-700 text-white px-4 py-2 rounded-full font-semibold shadow hover:bg-sky-700 dark:hover:bg-sky-800 transition text-sm">
                                        View Store
                                    </a>

                                    {{-- Follow button: pass precomputed isFollowing if available --}}
                                    @php
                                        $isFollowing = isset($followedSellerIds) ? in_array($seller->id, $followedSellerIds) : (auth()->check() ? auth()->user()->isFollowingSeller($seller) : false);
                                    @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-gray-500 dark:text-gray-400">No stores found.</div>
                @endforelse
            </div>
            <div class="mt-10 flex justify-center">
                {{ $sellers->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</x-app-layout>