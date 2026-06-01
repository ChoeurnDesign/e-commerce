<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16">

            {{-- ── Store Profile Card ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">

                {{-- Banner + centered logo --}}
                {{--
                    logoClass  = w-32 h-32  (8rem)
                    bannerClass = h-44       (11rem)
                    logoOffset  = -bottom-14 (logo hangs 3.5rem below banner)
                    → content needs pt-16 (4rem) to fully clear the logo
                --}}
                <x-store.banner-header
                    :seller="$seller"
                    logoClass="w-32 h-32"
                    bannerClass="h-44"
                    bannerFontClass="text-3xl"
                    logoOffset="-bottom-14"
                />

                {{-- Content below the banner/logo --}}
                <div class="px-6 sm:px-8 pb-8 pt-16">

                    @php $followersCount = $seller->followers_count ?? 0; @endphp

                    {{-- Store name + action buttons row --}}
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-5">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">
                                {{ $seller->store_name ?? $seller->name }}
                            </h1>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $followersCount }} {{ \Illuminate\Support\Str::plural('follower', $followersCount) }}
                            </p>
                        </div>

                        <div class="flex items-center gap-2 flex-shrink-0">
                            @include('stores.partials.follow-button', [
                                'seller'      => $seller,
                                'isFollowing' => $isFollowing ?? null,
                            ])
                            @include('stores.partials.chat-button', ['seller' => $seller])
                        </div>
                    </div>

                    {{-- Info badges --}}
                    <div class="flex flex-wrap items-center gap-2.5 mb-5">
                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full text-xs font-medium border border-gray-200">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            {{ $seller->products_count ?? $seller->products()->count() }} Products
                        </span>

                        <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-600 px-3 py-1.5 rounded-full text-xs font-medium border border-gray-200">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Since {{ $seller->created_at->format('M Y') }}
                        </span>

                        @auth
                            @php $hasReviewed = auth()->user()->hasReviewedStore($seller->id); @endphp
                            @if(!$hasReviewed)
                                <button onclick="document.dispatchEvent(new CustomEvent('show-store-review'))"
                                    class="inline-flex items-center gap-1.5 bg-pink-500 hover:bg-pink-600 text-white px-3 py-1.5 rounded-full text-xs font-semibold transition shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    Write a Review
                                </button>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-500 px-3 py-1.5 rounded-full text-xs font-medium border border-gray-200">
                                    <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Reviewed
                                </span>
                            @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center gap-1.5 bg-pink-500 hover:bg-pink-600 text-white px-3 py-1.5 rounded-full text-xs font-semibold transition shadow-sm">
                                Write a Review
                            </a>
                        @endauth
                    </div>

                    {{-- Description --}}
                    @if($seller->description)
                        <p class="text-gray-600 text-sm leading-relaxed max-w-2xl">
                            {{ $seller->description }}
                        </p>
                    @endif

                    {{-- Contact info --}}
                    @include('stores.partials.contact-info')
                </div>
            </div>

            {{-- ── Review Modal ── --}}
            @auth
                @if(!(auth()->user()->hasReviewedStore($seller->id) ?? false))
                    <div id="review-form-container"
                         x-data="{ show: false, rating: 0 }"
                         x-init="document.addEventListener('show-store-review', () => show = true)"
                         x-show="show"
                         style="display: none;"
                         role="dialog"
                         class="fixed inset-0 z-50 flex items-center justify-center p-4">
                        <div class="absolute inset-0 bg-black/60" @click="show = false"></div>
                        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                                <h3 class="text-base font-semibold text-gray-900">Add a Review</h3>
                                <button type="button" @click="show = false"
                                        class="text-gray-400 hover:text-gray-600 transition">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-6">
                                <form action="{{ route('seller.store-reviews.store', $seller) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rating" :value="rating">
                                    <p class="text-sm text-gray-500 mb-3">Your rating</p>
                                    <div class="flex gap-1.5 mb-5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button"
                                                    @click="rating = {{ $i }}"
                                                    :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'"
                                                    class="text-3xl leading-none hover:scale-110 transition-transform">★</button>
                                        @endfor
                                    </div>
                                    <textarea name="comment" rows="4" required
                                              class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl p-3 text-sm mb-4 focus:ring-2 focus:ring-pink-400 focus:border-pink-500 outline-none resize-none"
                                              placeholder="Share your experience with this store..."></textarea>
                                    <div class="flex gap-2">
                                        <button type="submit"
                                                class="flex-1 bg-pink-500 hover:bg-pink-600 text-white py-2.5 rounded-full text-sm font-semibold transition shadow-sm">
                                            Submit Review
                                        </button>
                                        <button type="button" @click="show = false"
                                                class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-full text-sm font-medium transition">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

            {{-- ── Products Section ── --}}
            <div class="mb-8">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Products
                        <span class="ml-1.5 text-sm font-normal text-gray-500">({{ $products->total() }})</span>
                    </h2>
                </div>

                @if($products->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-6">
                        @foreach($products as $product)
                            <x-products.product-card :product="$product" />
                        @endforeach
                    </div>
                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-14 bg-white rounded-2xl border border-gray-200">
                        <div class="flex items-center justify-center w-14 h-14 rounded-2xl bg-gray-100 mx-auto mb-3">
                            <svg class="w-7 h-7 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">No Products Available</h3>
                        <p class="text-xs text-gray-400 mt-1">This store hasn't listed any products yet.</p>
                    </div>
                @endif
            </div>

            {{-- ── Reviews Section ── --}}
            <div>
                <x-store.reviews-grid :seller="$seller" :reviews="$reviews" />
            </div>

        </div>
    </div>
</x-app-layout>

