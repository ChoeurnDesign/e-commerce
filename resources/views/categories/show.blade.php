<x-app-layout>
    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-6">
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

            @php
                $imageSrc = $category->image_url ?? asset('/img/default-category.png');
                $productsCount = $products->total() ?? (is_countable($products) ? count($products) : 0);
                $subCount = $subcategories->count() ?? 0;
                $altText = $category->image_alt ?? $category->name;
            @endphp

            <!-- Subtle header -->
            <div class="rounded-xl p-6 mb-6 bg-gray-300 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <img src="{{ $imageSrc }}" alt="{{ $altText }}" class="w-36 h-36 md:w-40 md:h-40 object-cover rounded-full border border-gray-100 dark:border-gray-700 shadow-sm" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('/img/default-category.png') }}'">
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $category->name }}</h1>
                        @if(!empty($category->description))
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 max-w-3xl">{{ $category->description }}</p>
                        @endif

                        <div class="mt-4 flex flex-wrap items-center gap-3">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-100">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-300" viewBox="0 0 20 20" fill="currentColor"><path d="M4 3a1 1 0 00-1 1v11a1 1 0 001 1h12a1 1 0 001-1V7.414A2 2 0 0016.586 6L13 2.414A2 2 0 0111.586 2H4z"/></svg>
                                {{ $productsCount }} {{ \Illuminate\Support\Str::plural('product', $productsCount) }}
                            </span>

                            @if($subCount > 0)
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-50 dark:bg-gray-800 text-sm text-gray-600 dark:text-gray-300">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"/></svg>
                                    {{ $subCount }} {{ \Illuminate\Support\Str::plural('subcategory', $subCount) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="mb-8 max-w-full mx-auto">
                <form method="GET" action="{{ route('category.show', $category->slug) }}" class="flex flex-wrap gap-4 items-center justify-center">
                    @if(request('subcategory')) <input type="hidden" name="subcategory" value="{{ request('subcategory') }}"> @endif

                    <div class="relative flex-1 min-w-80 max-w-full">
                        <x-text-input type="text" name="search" :value="request('search')" placeholder="Search products in {{ $category->name }}..." autocomplete="off"
                                      class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-700 rounded-full focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-900 text-sm"/>
                    </div>

                    @isset($allCategories)
                        <select name="category" class=" px-8 py-2 border border-gray-300 dark:border-gray-700 rounded-full bg-white dark:bg-gray-900 text-sm">
                            <option value="">All Categories</option>
                            @foreach($allCategories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    @endisset

                    <x-text-input type="number" name="min_price" :value="request('min_price')" placeholder="Min $" 
                                    class="w-20 px-3 py-2 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-sm rounded-full"/>

                    <x-text-input type="number" name="max_price" :value="request('max_price')" placeholder="Max $" 
                                    class="w-20 px-3 py-2 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-sm rounded-full"/>

                    <select name="sort" class="px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-full bg-white dark:bg-gray-900 text-sm">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>

                    <div class="flex items-center gap-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full text-sm">Apply</button>
                        <a href="{{ route('category.show', $category->slug) }}" class="px-4 py-2 rounded-full bg-gray-200 dark:bg-gray-700 text-sm">Clear</a>
                    </div>
                </form>
            </div>

            <!-- Subcategories -->
            @if($subcategories->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Subcategories</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-8">
                        @foreach($subcategories as $subcategory)
                            <a href="{{ route('category.show', $category->slug) }}?subcategory={{ $subcategory->slug }}" class="group bg-white dark:bg-gray-900 border rounded-lg p-4 text-center">
                                <img 
                                    src="{{ $subcategory->image ?? \App\Helpers\PlaceholderAvatar::svgDataUri($subcategory->name) }}" 
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
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
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
                        <p class="text-gray-500 dark:text-gray-400 mb-8">Try adjusting your filters or search terms.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>