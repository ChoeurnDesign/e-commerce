<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </x-slot>

    <div class="py-8 bg-gray-200 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">All Products</h1>
                <p class="text-gray-600 dark:text-gray-300">
                    Discover our amazing collection of available products
                </p>
            </div>

            <div class="mb-8">
                <x-products.search-filters :categories="$categories" :show-advanced="true" />
            </div>

            <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                <p class="text-gray-600 dark:text-gray-300 font-medium">
                    <span class="text-green-600 dark:text-green-400 font-semibold">
                        {{ $products->total() }}
                    </span>
                    products found
                    @if(request('search'))
                        for
                        <span class="italic text-indigo-600 dark:text-indigo-400">
                            "{{ request('search') }}"
                        </span>
                    @endif
                </p>
                <div class="text-sm text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-800 px-4 py-2 rounded-full border border-gray-200 dark:border-gray-700">
                    Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                </div>
            </div>

            @if($products->count())
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
                    <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-300 mb-4">
                        No Available Products Found
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">
                        Try adjusting your filters or search terms.
                    </p>
                    <a href="{{ route('products.index') }}"
                       class="bg-indigo-600 hover:bg-indigo-700 dark:bg-purple-700 dark:hover:bg-purple-600 text-white px-8 py-3 rounded-full font-medium transition-all shadow-md hover:shadow-lg">
                        View All Products
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>