<div id="featured-products" class="py-10 sm:py-16 bg-gray-50 dark:bg-gray-900/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-7 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-3">
                {{ __('Featured Products') }}
            </h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base max-w-xl mx-auto">
                {{ __('Check out our handpicked selection of amazing products') }}
            </p>
        </div>

        @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6">
                @foreach($featuredProducts as $product)
                    <x-products.product-card :product="$product" :minimal="true" />
                @endforeach
            </div>

            <div class="text-center mt-8 sm:mt-12">
                <a href="{{ route('products.index') }}"
                    class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold
                           py-2.5 px-7 sm:py-3 sm:px-8 rounded-full text-sm sm:text-base
                           transition duration-300 shadow-md hover:shadow-lg
                           dark:bg-indigo-500 dark:hover:bg-indigo-600">
                    {{ __('View All Products') }}
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-300 dark:text-gray-600 text-5xl mb-4">🛍️</div>
                <h3 class="text-lg text-gray-500 dark:text-gray-400">{{ __('No Products Yet') }}</h3>
            </div>
        @endif
    </div>
</div>
