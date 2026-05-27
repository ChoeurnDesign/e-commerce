<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <section class="relative bg-white dark:bg-gradient-to-b dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 shadow-2xl overflow-hidden rounded-2xl">
                
                {{-- Banner Area --}}
                <div class="relative">
                    <x-store.banner-header 
                        :seller="$seller" 
                        logoClass="w-44 h-44" 
                        bannerClass="h-48" {{-- Restored height to prevent layout collapse --}}
                        bannerFontClass="text-4xl" 
                        logoOffset="-bottom-24" 
                    />
                </div>

                {{-- Content Area: Restored your px-8 and pt-6 --}}
                <div class="px-8 pb-12 pt-16 md:pt-6"> {{-- pt-16 added for mobile safety --}}
                    <div class="flex flex-col md:flex-row md:items-end md:gap-8">
                        {{-- Left spacer restored --}}
                        <div class="w-8"></div>

                        <div class="flex-1">
                            @php $followersCount = $seller->followers_count ?? 0; @endphp

                            {{-- Restored your exact follow/chat row with ml-36 --}}
                            <div class="w-full mt-4 flex justify-between">
                                <div class="flex ml-36 items-center"> 
                                    <span class="inline-flex items-center gap-2 mr-3 text-emerald-500 dark:text-emerald-300 text-lg font-semibold leading-none">
                                        {{ $followersCount }} {{ \Illuminate\Support\Str::plural('follower', $followersCount) }}
                                    </span>

                                    @include('stores.partials.follow-button', [
                                        'seller' => $seller,
                                        'isFollowing' => $isFollowing ?? null,
                                    ])
                                </div>

                                <div class="flex">
                                    @include('stores.partials.chat-button', ['seller' => $seller])
                                </div>
                            </div>

                            {{-- Store Title - Restored mt-8 and styling --}}
                            <h1 class="text-4xl mt-8 md:text-5xl font-extrabold text-cyan-700 dark:text-cyan-400 tracking-wide">
                                {{ $seller->store_name ?? $seller->name }}
                            </h1>

                            {{-- Badges row restored --}}
                            <div class="mt-6 flex flex-wrap items-center gap-4">
                                <span class="inline-flex items-center gap-3 bg-indigo-500 dark:bg-indigo-800 text-gray-100 px-4 py-2 rounded-full shadow-sm text-sm font-semibold">
                                    <x-heroicon-o-inbox class="w-6 h-6 text-blue-300" />
                                    Products: {{ $seller->products_count ?? $seller->products()->count() }}
                                </span>

                                @auth
                                    @php $hasReviewed = auth()->user()->hasReviewedStore($seller->id); @endphp
                                    @if (!$hasReviewed)
                                        <button onclick="document.dispatchEvent(new CustomEvent('show-store-review'))"
                                            class="inline-flex items-center gap-2 bg-sky-600 text-white dark:bg-blue-600 px-4 py-2 rounded-full shadow-sm hover:bg-sky-700 transition text-sm font-semibold">
                                            <x-heroicon-o-star class="w-6 h-6 text-blue-300" />
                                            Add Review
                                        </button>
                                    @else
                                        <span class="inline-flex items-center gap-2 bg-blue-600 dark:bg-blue-800 text-gray-100 px-4 py-2 rounded-full shadow-sm text-sm font-semibold">
                                            <x-heroicon-o-star class="w-6 h-6 text-blue-300" />
                                            Reviewed
                                        </span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-sky-600 text-white px-4 py-2 rounded-full shadow-sm hover:bg-sky-700 transition text-sm font-semibold">
                                        Add Review
                                    </a>
                                @endauth

                                <span class="inline-flex items-center gap-3 bg-green-500 text-gray-100 dark:bg-green-700 px-4 py-2 rounded-full shadow-sm text-sm font-semibold">
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

                    {{-- Contact info restored --}}
                    @include('stores.partials.contact-info')
                </div>
            </section>

            {{-- Review Modal logic kept intact --}}
            @auth
                @if (!(auth()->user()->hasReviewedStore($seller->id) ?? false))
                    <div id="review-form-container" x-data="{ show: false, rating: 0 }" x-init="document.addEventListener('show-store-review', () => show = true)" x-show="show"
                        style="display: none;" role="dialog" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                        <div class="absolute inset-0 bg-black bg-opacity-50" @click="show = false"></div>
                        <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-xl relative">
                             {{-- ... (Internal modal content) ... --}}
                             <div class="bg-gray-700 px-6 py-4 rounded-t-lg flex items-center justify-between">
                                <div class="text-white">
                                    <h3 class="text-lg">Add Review</h3>
                                </div>
                                <button type="button" @click="show = false" class="text-white text-xl">✕</button>
                             </div>
                             <div class="p-6">
                                <form action="{{ route('seller.store-reviews.store', $seller) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="rating" :value="rating">
                                    <div class="flex gap-1 mb-4">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" @click="rating = {{ $i }}" :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-500'" class="text-3xl">★</button>
                                        @endfor
                                    </div>
                                    <textarea name="comment" rows="4" required class="w-full bg-gray-700 text-white rounded p-3 mb-4" placeholder="Share your experience..."></textarea>
                                    <div class="flex gap-3">
                                        <button type="submit" class="flex-1 bg-sky-600 text-white py-2 rounded-full">Submit Review</button>
                                        <button type="button" @click="show = false" class="px-6 py-2 bg-gray-600 text-white rounded-full">Cancel</button>
                                    </div>
                                </form>
                             </div>
                        </div>
                    </div>
                @endif
            @endauth

            {{-- Products Section --}}
            <div class="mt-10">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-slate-700 dark:text-slate-300 font-medium">
                        <span class="text-emerald-600 dark:text-emerald-400">{{ $products->total() }}</span> products found
                    </p>
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
                    <div class="text-center py-16 bg-white/60 dark:bg-slate-800/40 rounded-2xl border border-slate-200/60 dark:border-slate-700/40">
                        <div class="text-6xl mb-4 text-slate-500">📦</div>
                        <h3 class="text-xl text-slate-700 dark:text-slate-300">No Available Products Found</h3>
                    </div>
                @endif
            </div>

            {{-- Reviews Section --}}
            <div class="mt-10">
                <x-store.reviews-grid :seller="$seller" :reviews="$reviews" />
            </div>

        </div>
    </div>
</x-app-layout>