<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>
    <div class="py-8 bg-gray-200 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">All Products</h1>
                <p class="text-gray-600 dark:text-gray-300">Discover our amazing collection of available products</p>
            </div>

            <div class="mb-8">
                <form method="GET" action="{{ route('products.index') }}" class="flex flex-wrap gap-4 items-center justify-center">
                    <div class="relative flex-1 min-w-80 max-w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search products..."
                               autocomplete="off"
                               class="w-full pl-10 pr-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm">
                    </div>

                    <select name="category" class="px-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-700 dark:text-gray-200 min-w-40 text-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="number"
                           name="min_price"
                           value="{{ request('min_price') }}"
                           placeholder="Min $"
                           class="w-20 px-3 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 text-center transition-all text-gray-700 dark:text-gray-200 text-sm placeholder-gray-500 dark:placeholder-gray-400">

                    <input type="number"
                           name="max_price"
                           value="{{ request('max_price') }}"
                           placeholder="Max $"
                           class="w-20 px-3 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 text-center transition-all text-gray-700 dark:text-gray-200 text-sm placeholder-gray-500 dark:placeholder-gray-400">

                    <select name="sort" class="px-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-700 dark:text-gray-200 min-w-32 text-sm">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price ↑</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price ↓</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>A-Z</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                    </select>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-full font-medium transition-all shadow-md hover:shadow-lg text-sm">
                        Apply
                    </button>
                    <a href="{{ route('products.index') }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-5 py-2 border-2 border-gray-400 rounded-full font-medium transition-all text-sm">
                        Clear
                    </a>
                </form>
            </div>

            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600 dark:text-gray-300 font-medium">
                    <span class="text-green-600 dark:text-green-400 font-semibold">{{ $products->total() }}</span>
                    available products found
                </p>
                <div class="text-sm text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-800 px-4 py-2 rounded-full border border-gray-200 dark:border-gray-700">
                    Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                </div>
            </div>

            @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                 @foreach($products as $product)
                    <x-products.product-card :product="$product" />
                @endforeach
            </div>
            <div class="flex justify-center">
                {{ $products->links() }}
            </div>
            @else
                <div class="text-center py-16 bg-white dark:bg-gray-900 rounded-2xl shadow-md border border-gray-300 dark:border-gray-700">
                    <div class="text-6xl mb-4 text-gray-400 dark:text-gray-600">📦</div>
                    <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-4">No Available Products Found</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">All products matching your criteria are currently out of stock or try adjusting your filters</p>
                    <a href="{{ route('products.index') }}"
                       class="bg-indigo-600 hover:bg-indigo-700 dark:bg-purple-700 dark:hover:bg-purple-600 text-white px-8 py-3 rounded-full font-medium transition-all shadow-md hover:shadow-lg">
                        View All Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
