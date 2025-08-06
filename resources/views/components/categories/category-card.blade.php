@props(['parentCategories'])

@if($parentCategories->count() > 0)
    <div class="space-y-16">
        @foreach($parentCategories as $category)
            <div class="relative overflow-hidden rounded-3xl shadow-xl border border-gray-300 dark:border-gray-700 mb-10 bg-gradient-to-tr from-indigo-50 via-white dark:from-gray-900 dark:via-gray-800 to-indigo-100 dark:to-gray-900 transition-shadow hover:shadow-2xl">
                <!-- Accent background shape -->
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-200 opacity-60 dark:bg-indigo-900 dark:opacity-30 rounded-full pointer-events-none"></div>
                <!-- Category Header -->
                <div class="flex flex-col md:flex-row items-center gap-8 px-8 py-10 relative z-10">
                    <img src="{{ $category->image }}"
                         alt="{{ $category->name }}"
                         class="w-32 h-32 object-cover rounded-full border-4 border-indigo-300 dark:border-indigo-600 shadow-lg bg-white dark:bg-gray-800 flex-shrink-0"
                         onerror="this.onerror=null;this.src='/img/default-category.png';">
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 dark:text-gray-100 mb-2">{{ $category->name }}</h2>
                        <p class="text-gray-500 dark:text-gray-300 mb-4">{{ $category->description }}</p>
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                            <span class="inline-flex items-center bg-indigo-600/10 text-indigo-700 dark:text-indigo-300 px-4 py-1 rounded-full font-medium text-sm">
                                <svg class="w-4 h-4 mr-2 text-indigo-400 dark:text-indigo-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 2a2 2 0 00-2 2v2H5a2 2 0 00-2 2v8a2 2 0 002 2h10a2 2 0 002-2v-8a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H8zm0 2h4v2H8V4z"/>
                                </svg>
                                {{ $category->total_products_count }} Products
                            </span>
                            <a href="{{ route('category.show', $category->slug) }}"
                                class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-full font-semibold shadow transition duration-200 dark:bg-indigo-700 dark:hover:bg-indigo-600">
                                View All →
                            </a>
                        </div>
                    </div>
                </div>
                @if($category->children->count() > 0)
                <!-- Subcategories -->
                <div class="bg-gray-300 dark:bg-gray-800/60 px-8 py-8 border-t border-gray-300 dark:border-gray-700">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                        @foreach($category->children as $subcategory)
                        <a href="{{ route('category.show', $subcategory->slug) }}"
                            class="group relative bg-white dark:bg-gray-900/90 border border-gray-300 dark:border-gray-700 rounded-2xl shadow hover:shadow-lg transition-all transform hover:-translate-y-1 p-5 flex flex-col items-center text-center cursor-pointer">
                            <!-- Glow hover effect -->
                            <div class="absolute inset-0 rounded-2xl opacity-0 group-hover:opacity-100 transition bg-indigo-50 dark:bg-indigo-800/20 pointer-events-none"></div>
                            <img src="{{ $subcategory->image }}"
                                 alt="{{ $subcategory->name }}"
                                 class="w-20 h-20 object-cover rounded-full border-2 border-indigo-200 dark:border-indigo-600 shadow mb-3 bg-gray-300 dark:bg-gray-700 group-hover:scale-110 transition-transform duration-300"
                                 onerror="this.onerror=null;this.src='/img/default-category.png';">
                            <div>
                                <h3 class="font-semibold text-gray-800 dark:text-gray-100 mb-1 group-hover:text-indigo-700 dark:group-hover:text-indigo-300 transition-colors">
                                    {{ $subcategory->name }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-300 mb-2">{{ $subcategory->description }}</p>
                                <span class="text-sm font-medium text-indigo-600 dark:text-indigo-300">{{ $subcategory->total_products_count }} items</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        @endforeach
    </div>
@else
    <!-- No Categories -->
    <div class="text-center py-20">
        <div class="text-7xl mb-6 text-indigo-200 dark:text-indigo-600">📂</div>
        <h3 class="text-2xl font-extrabold text-gray-600 dark:text-gray-300 mb-4">No Categories Available</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-7">Categories will appear here once they are added.</p>
        <a href="{{ route('products.index') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full shadow transition duration-200 dark:bg-indigo-700 dark:hover:bg-indigo-600">
            Browse All Products
        </a>
    </div>
@endif
