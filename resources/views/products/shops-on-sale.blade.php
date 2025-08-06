<x-app-layout>
    <div class="py-12 bg-gray-300 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-red-600 dark:text-yellow-400 drop-shadow-lg">
                    {{ __('Shops On Sale') }}
                </h1>
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    {{ __('Browse all items currently on sale and save big!') }}
                </p>
            </div>

            @if($saleProducts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                 @foreach($saleProducts as $product)
                    <x-products.product-card :product="$product" :isSale="true" />
                @endforeach
            </div>
            @else
                <div class="text-center py-12" role="status">
                    <div class="text-gray-400 dark:text-gray-600 text-6xl mb-4" aria-hidden="true">🛍️</div>
                    <h3 class="text-xl text-gray-600 dark:text-gray-300 mb-2">{{ __('No Products On Sale') }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ __('Currently, there are no products on sale. Please check back later!') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
