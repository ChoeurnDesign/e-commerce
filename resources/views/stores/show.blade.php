<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- NEW Card container that matches the provided design --}}
            <section
                class="relative bg-white dark:bg-gradient-to-b dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 shadow-2xl overflow-hidden">
                {{-- Banner + overlapping logo --}}
                <div class="">
                    <x-store.banner-header :seller="$seller" logoClass="w-44 h-44" bannerClass="h-54"
                        bannerFontClass="text-2xl" logoOffset="-bottom-24" />
                </div>

                {{-- Card content --}}
                <div class="px-8 pb-12 pt-6">
                    <div class="flex flex-col md:flex-row md:items-end md:gap-8">
                        {{-- Left spacer to leave room for logo visual --}}
                        <div class="w-8"></div>

                        <div class="flex-1">
                            @php $followersCount = $seller->followers_count ?? 0; @endphp

                            <div class="w-full mt-4 flex justify-between">
                                <div class="flex ml-36 items-center">
                                    {{-- Follower count (plain text, no background) --}}
                                    <span class="inline-flex items-center gap-2 mr-3 text-emerald-500 dark:text-emerald-300 text-lg font-semibold leading-none">
                                        {{ $followersCount }} {{ \Illuminate\Support\Str::plural('follower', $followersCount) }}
                                    </span>

                                    {{-- Follow / Following button (simple text style, no background) --}}
                                    @include('stores.partials.follow-button', [
                                        'seller' => $seller,
                                        'isFollowing' => $isFollowing ?? null,
                                    ])
                                </div>

                                <div class="flex">
                                    {{-- Message Seller Button --}}
                                    @include('stores.partials.chat-button', ['seller' => $seller])
                                </div>
                            </div>

                            <h1
                                class="text-4xl mt-8 md:text-5xl font-extrabold text-cyan-700 dark:text-cyan-400 tracking-wide">
                                {{ $seller->store_name ?? $seller->name }}
                            </h1>

                            {{-- badges / actions row --}}
                            <div class="mt-6 flex flex-wrap items-center gap-4">
                                <span
                                    class="inline-flex items-center gap-3
                                            bg-indigo-500 dark:bg-indigo-800 text-gray-100
                                            px-4 py-2 rounded-full shadow-sm text-sm font-semibold">
                                    <x-heroicon-o-inbox class="w-6 h-6 text-blue-300" />
                                    Products: {{ $seller->products_count ?? $seller->products()->count() }}
                                </span>

                                @auth
                                    @php
                                        $hasReviewed = auth()->check() && auth()->user()->hasReviewedStore($seller->id);
                                    @endphp

                                    @if (!$hasReviewed)
                                        <button
                                            @click.prevent="document.dispatchEvent(new CustomEvent('show-store-review'))"
                                            class="inline-flex items-center gap-2
                                                bg-sky-600 text-white
                                                dark:bg-blue-600 dark:text-white text-gray-100
                                                px-4 py-2 rounded-full shadow-sm hover:bg-sky-700 transition text-sm font-semibold">
                                            <x-heroicon-o-star class="w-6 h-6 text-blue-300" />
                                            Add Review
                                        </button>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-2
                                                    bg-blue-600 dark:bg-blue-800 text-gray-100
                                                    px-4 py-2 rounded-full shadow-sm text-sm font-semibold">
                                            <x-heroicon-o-star class="w-6 h-6 text-blue-300" />
                                            Reviewed
                                        </span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}"
                                        class="inline-flex items-center gap-2 bg-sky-600 text-white dark:text-white px-4 py-2 rounded-full shadow-sm hover:bg-sky-700 dark:hover:bg-blue-600 transition text-sm font-semibold">
                                        Add Review
                                    </a>
                                @endauth

                                <span
                                    class="inline-flex items-center gap-3
                                            bg-green-500 text-gray-100 dark:bg-green-700 
                                            px-4 py-2 rounded-full shadow-sm text-sm font-semibold">
                                    <x-heroicon-o-calendar-days class="w-6 h-6 text-blue-300" />
                                    Opened: {{ $seller->created_at->format('Y-m-d') }}
                                </span>
                            </div>

                            {{-- Description --}}
                            <div class="mt-6 text-slate-700 dark:text-slate-300 prose prose-invert max-w-none">
                                <p class="mt-2 text-green-700 dark:text-green-300 text-sm md:text-base">
                                    {{ $seller->description ?? 'No description provided.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Contact info bottom bar (rounded panel) --}}
                    @include('stores.partials.contact-info')
                </div>
            </section>

            {{-- Review Form Modal - Only show if not reviewed --}}
            @auth
                @if (!(auth()->user()->hasReviewedStore($seller->id) ?? false))
                    <div id="review-form-container" x-data="{ show: false, rating: 0 }" x-init="document.addEventListener('show-store-review', () => show = true)" x-show="show"
                        style="display: none;" role="dialog" aria-modal="true" aria-labelledby="review-modal-title"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4">
                        <div class="absolute inset-0 bg-black bg-opacity-50" @click="show = false" aria-hidden="true"></div>

                        <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-xl relative"
                            @keydown.escape.window="show = false">
                            <!-- Header -->
                            <div class="bg-gray-700 px-6 py-4 rounded-t-lg flex items-center justify-between">
                                <div class="text-white">
                                    <h3 id="review-modal-title" class="text-lg">Add Review</h3>
                                    <p class="text-sm text-gray-300">To "{{ $seller->store_name ?? $seller->name }}"</p>
                                </div>
                                <button type="button" @click="show = false" class="text-white text-xl hover:text-gray-300"
                                    aria-label="Close modal">✕</button>
                            </div>

                            <!-- Form -->
                            <div class="p-6">
                                <form action="{{ route('seller.store-reviews.store', $seller) }}" method="POST" novalidate>
                                    @csrf
                                    <div class="mb-4">
                                        <label for="rating" class="block text-gray-300 text-sm mb-3">How would you rate this store?</label>

                                        <div class="flex items-center gap-1 mb-2" role="radiogroup" aria-labelledby="rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <button type="button" @click="rating = {{ $i }}"
                                                    :aria-checked="rating === {{ $i }}" role="radio"
                                                    tabindex="{{ $i === 1 ? '0' : '-1' }}"
                                                    class="text-2xl transition-colors"
                                                    :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-500'">
                                                    <template x-if="rating >= {{ $i }}">
                                                        <x-icon-nav name="star-empty" class="h-8 w-8" />
                                                    </template>
                                                    <template x-if="rating < {{ $i }}">
                                                        <x-icon-nav name="star-filled" class="h-8 w-8" />
                                                    </template>
                                                </button>
                                            @endfor
                                        </div>

                                        <input type="hidden" name="rating" :value="rating" required>

                                        <div x-show="rating === 0" class="text-red-400 text-sm mb-3" role="alert">
                                            Please select a rating
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label for="comment" class="block text-gray-300 text-sm mb-2">Share your experience</label>
                                        <textarea id="comment" name="comment" rows="4" required
                                            placeholder="Tell others about your experience with this store..."
                                            class="w-full bg-gray-700 text-gray-300 px-4 py-3 rounded border-0 resize-none focus:bg-gray-600 transition-colors"></textarea>
                                    </div>

                                    <div class="flex gap-3">
                                        <button type="submit" :disabled="rating === 0"
                                            :class="rating === 0 ? 'bg-gray-600 cursor-not-allowed' : 'bg-gray-600 hover:bg-gray-500'"
                                            class="flex-1 text-white py-2 rounded-full transition-colors">
                                            Submit Review
                                        </button>
                                        <button type="button" @click="show = false"
                                            class="px-6 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-full transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

            {{-- Products Section --}}
            <div class="mt-10">
                <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                    <p class="text-slate-700 dark:text-slate-300 font-medium">
                        <span class="text-emerald-600 dark:text-emerald-400">
                            {{ $products->total() }}
                        </span>
                        products found in this store
                    </p>
                    <div
                        class="text-sm text-slate-600 dark:text-slate-400 bg-white/60 dark:bg-slate-800/40 px-4 py-2 rounded-full border border-slate-200/60 dark:border-slate-700/40">
                        Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                    </div>
                </div>

                @if ($products->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                        @foreach ($products as $product)
                            <x-products.product-card :product="$product" />
                        @endforeach
                    </div>
                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div
                        class="text-center py-16 bg-white/60 dark:bg-slate-800/40 rounded-2xl shadow-md border border-slate-200/60 dark:border-slate-700/40">
                        <div class="text-6xl mb-4 text-slate-500 dark:text-slate-400" aria-hidden="true">📦</div>
                        <h3 class="text-xl text-slate-700 dark:text-slate-300 mb-4">
                            No Available Products Found
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-6">
                            Try adjusting your filters or check back later.
                        </p>
                        <a href="{{ route('stores.index') }}"
                            class="bg-sky-600 hover:bg-sky-700 text-white px-8 py-3 rounded-full font-medium transition-all shadow-md hover:shadow-lg">
                            View All Stores
                        </a>
                    </div>
                @endif
            </div>

            {{-- Store Ratings & Reviews --}}
            <div class="mt-10">
                <x-store.reviews-grid :seller="$seller" :reviews="$reviews" />
            </div>

        </div>
    </div>
</x-app-layout>
