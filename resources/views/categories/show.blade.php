<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-300">
                    <li><a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-indigo-300">Home</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('categories.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-300">Categories</a></li>
                    @foreach($breadcrumb as $crumb)
                        <li><span class="mx-2">/</span></li>
                        @if($loop->last)
                            <li class="text-gray-900 dark:text-gray-100 font-medium">{{ $crumb->name }}</li>
                        @else
                            <li><a href="{{ route('category.show', $crumb->slug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-300">{{ $crumb->name }}</a></li>
                        @endif
                    @endforeach
                </ol>
            </nav>

            <!-- Category Header -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl p-8 mb-8">
                <div class="flex items-center space-x-6">
                    <img src="{{ $category->image ? asset($category->image) : asset('/img/default-category.png') }}"
                         alt="{{ $category->name }}"
                         class="w-40 h-40 object-cover rounded-full border-2 border-green-500 dark:border-blue-900">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">{{ $category->name }}</h1>
                        <p class="text-indigo-100 text-lg mb-4">{{ $category->description }}</p>
                        <div class="flex items-center space-x-4">
                            <span class="bg-white dark:bg-white/20 bg-opacity-20 px-4 py-2 rounded-full">
                                {{ $products->total() }} Products
                            </span>
                            @if($subcategories->count() > 0)
                                <span class="bg-white dark:bg-white/20 bg-opacity-20 px-4 py-2 rounded-full">
                                    {{ $subcategories->count() }} Subcategories
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Search & Filters Bar -->
            <div class="mb-8">
                <form method="GET" action="{{ route('category.show', $category->slug) }}" class="flex flex-wrap gap-4 items-center justify-center">
                    @if(request('subcategory'))
                        <input type="hidden" name="subcategory" value="{{ request('subcategory') }}">
                    @endif

                    <div class="relative flex-1 min-w-80 max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search products in {{ $category->name }}..."
                               autocomplete="off"
                               class="w-full pl-10 pr-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm">
                    </div>

                    <!-- Optional: Category dropdown for jumping between categories -->
                    @isset($allCategories)
                    <select name="category" class="px-4 py-2 border-2 border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-900 transition-all text-gray-700 dark:text-gray-200 min-w-40 text-sm">
                        <option value="">All Categories</option>
                        @foreach($allCategories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @endisset

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
                        <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>

                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-full font-medium transition-all shadow-md hover:shadow-lg text-sm">
                        Apply
                    </button>
                    <a href="{{ route('category.show', $category->slug) }}" class="bg-gray-300 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-5 py-2 rounded-full font-medium transition-all text-sm">
                        Clear
                    </a>
                </form>
            </div>

            <!-- Subcategories (if any) -->
            @if($subcategories->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Subcategories</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                        <a href="{{ route('category.show', $category->slug) }}"
                           class="group bg-white dark:bg-gray-900 border-2 {{ !request('subcategory') ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950' : 'border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-500' }} rounded-lg p-4 text-center transition duration-300">
                            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-900 dark:text-gray-100 text-sm">All Products</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $category->total_products_count }}</p>
                        </a>
                        @foreach($subcategories as $subcategory)
                            <a href="{{ route('category.show', $category->slug) }}?subcategory={{ $subcategory->slug }}"
                               class="group bg-white dark:bg-gray-900 border-2 {{ request('subcategory') == $subcategory->slug ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-950' : 'border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-500' }} rounded-lg p-4 text-center transition duration-300">
                                <img src="{{ $subcategory->image }}"
                                     alt="{{ $subcategory->name }}"
                                     class="w-12 h-12 object-cover rounded-full mx-auto mb-3 bg-gray-300 dark:bg-gray-800">
                                <h4 class="font-medium text-gray-900 dark:text-gray-100 text-sm">{{ $subcategory->name }}</h4>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $subcategory->total_products_count }} items</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Products Grid -->
            <div>
                <div class="flex justify-between items-center mb-6">
                    <div class="text-gray-600 dark:text-gray-300">
                        Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                        @if(request('subcategory'))
                            in {{ $subcategories->where('slug', request('subcategory'))->first()->name ?? 'Subcategory' }}
                        @endif
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 mb-8">
                        @foreach($products as $product)
                            <x-products.product-card :product="$product" />
                        @endforeach
                    </div>
                    <div class="flex justify-center">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="text-gray-400 dark:text-gray-500 text-6xl mb-6">📦</div>
                        <h3 class="text-2xl font-semibold text-gray-600 dark:text-gray-300 mb-4">No Products Found</h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8">
                            @if(request()->hasAny(['search', 'min_price', 'max_price', 'subcategory']))
                                Try adjusting your filters or search terms.
                            @else
                                Products will be added to this category soon.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'min_price', 'max_price', 'subcategory']))
                            <a href="{{ route('category.show', $category->slug) }}"
                               class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                                Clear All Filters
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
