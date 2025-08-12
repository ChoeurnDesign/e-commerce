<x-app-layout>
    <!-- Banner Slider -->
    <div x-data="{ active: 0, count: {{ count($banners) }} }" class="relative overflow-hidden">
        @foreach($banners as $i => $banner)
            <div x-show="active === {{ $i }}" class="relative bg-cover bg-center min-h-[400px] transition-all duration-500"
                style="background-image: url('{{ asset('storage/'.$banner->image_path) }}');">
                <div class="absolute inset-0 bg-black opacity-40 dark:opacity-70" aria-hidden="true"></div>
                <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center z-10">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6 drop-shadow-lg">
                        {{ $storefrontTitle ?? "Welcome to Our Store" }}
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                        {{ $welcomeMessage ?? __('Discover amazing products at unbeatable prices. Your one-stop shop for everything you need.') }}
                    </p>
                    @if($banner->title || $banner->subtitle)
                    <div class="mb-8">
                        @if($banner->title)
                            <div class="text-3xl font-semibold mb-2">{{ $banner->title }}</div>
                        @endif
                        @if($banner->subtitle)
                            <div class="text-lg mb-2">{{ $banner->subtitle }}</div>
                        @endif
                    </div>
                    @endif
                    <div class="flex flex-col items-center gap-0 mt-6">
                        <div class="flex flex-row gap-4 mb-4">
                            <a href="#categories" class="inline-block bg-white text-indigo-600 hover:bg-indigo-50 font-bold py-2 px-6 rounded-full text-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white dark:bg-gray-900 dark:text-purple-200 dark:hover:bg-gray-800 dark:focus:ring-gray-900">
                                {{ __('Browse Categories') }}
                            </a>
                            <a href="#featured-products" class="inline-block border-2 border-white text-white hover:bg-white hover:text-indigo-600 font-bold py-2 px-6 rounded-full text-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white dark:border-purple-200 dark:hover:bg-gray-900 dark:hover:text-purple-200 dark:focus:ring-gray-900">
                                {{ __('Shop Featured') }}
                            </a>
                        </div>
                        <a href="{{ route('products.shops_on_sale', ['on_sale' => 1]) }}"
                        class="inline-block bg-pink-600 text-white font-bold py-2 px-6 rounded-full text-lg transition duration-300 shadow hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-pink-300 dark:bg-pink-700 dark:hover:bg-pink-800 dark:focus:ring-pink-900">
                            {{ __('Shop On Sale') }}
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        @if(count($banners) > 1)
        <button @click="active = (active - 1 + count) % count" class="absolute left-4 top-1/2 -translate-y-1/2 p-2 bg-black/40 rounded-full text-white">&lt;</button>
        <button @click="active = (active + 1) % count" class="absolute right-4 top-1/2 -translate-y-1/2 p-2 bg-black/40 rounded-full text-white">&gt;</button>
        @endif
    </div>

    <!-- Categories Preview Section -->
    <div id="categories" class="py-16 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Shop by Category') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-300 text-lg">
                    {{ __('Explore our wide range of product categories') }}
                </p>
            </div>
            <x-categories.category-card :parentCategories="$parentCategories" />
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('categories.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-purple-700 dark:hover:bg-purple-600 dark:focus:ring-purple-400">
                {{ __('View All Categories') }}
            </a>
        </div>
    </div>

    <!-- Featured Products Section -->
    <div id="featured-products" class="py-16 bg-gray-300 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('Featured Products') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-300 text-lg">
                    {{ __('Check out our handpicked selection of amazing products') }}
                </p>
            </div>
            @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <x-products.product-card :product="$product" :minimal="true"/>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('products.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-purple-700 dark:hover:bg-purple-600 dark:focus:ring-purple-400">
                    {{ __('View All Products') }}
                </a>
            </div>
            @else
            <div class="text-center py-12" role="status">
                <div class="text-gray-400 dark:text-gray-600 text-6xl mb-4" aria-hidden="true">🛍️</div>
                <h3 class="text-xl text-gray-600 dark:text-gray-300 mb-2">{{ __('No Products Yet') }}</h3>
                <p class="text-gray-500 dark:text-gray-400">{{ __('Featured products will appear here once they are added.') }}</p>
            </div>
            @endif
        </div>
    </div>

   <!-- Features / Trust Section -->
<div class="py-16 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('Free Shipping') }}</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ __('Free shipping on orders over $:amount', ['amount' => 50]) }}</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('Quality Guarantee') }}</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ __('30-day money back guarantee') }}</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-indigo-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('24/7 Support') }}</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ __('Round-the-clock customer support') }}</p>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
