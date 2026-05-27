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

                <div class="product-pagination-container mt-12 mb-10 border-t border-gray-200 dark:border-gray-700 pt-8">
                    {{ $products->links() }}
                </div>

                <style>
                    /* Compact Premium Design */
                    .product-pagination-container nav { 
                        @apply flex flex-col items-center gap-6 sm:flex-row sm:justify-between !important; 
                    }

                    /* The Number Pill */
                    .product-pagination-container a, 
                    .product-pagination-container span[aria-disabled="true"] span,
                    .product-pagination-container span[aria-current="page"] span {
                        @apply inline-flex items-center justify-center min-w-[2.5rem] h-10 mx-0.5 rounded-full text-sm font-semibold transition-all duration-200 border-none !important;
                    }

                    /* Normal State */
                    .product-pagination-container a {
                        @apply bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-300 hover:bg-indigo-600 hover:text-white hover:-translate-y-1 hover:shadow-lg hover:shadow-indigo-500/30;
                    }

                    /* Active State */
                    .product-pagination-container span[aria-current="page"] span {
                        @apply bg-gradient-to-br from-indigo-500 to-indigo-700 text-white shadow-lg shadow-indigo-500/40 !important;
                    }

                    /* The Margin Gap you asked for */
                    @media (min-width: 640px) {
                        .product-pagination-container nav > div:last-child { @apply ml-16 !important; }
                    }
                </style>
                @else
            @endif
        </div>
    </div>
</x-app-layout> 