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
            <x-products.product-card :product="$product" :minimal="true" />
            @endforeach
        </div>
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-purple-700 dark:hover:bg-purple-600 dark:focus:ring-purple-400">
                {{ __('View All Products') }}
            </a>
        </div>
        @else
        <div class="text-center py-12" role="status">
            <div class="text-gray-400 dark:text-gray-600 text-6xl mb-4" aria-hidden="true">🛍️</div>
            <h3 class="text-xl text-gray-600 dark:text-gray-300 mb-2">{{ __('No Products Yet') }}</h3>
            <p class="text-gray-500 dark:text-gray-400">
                {{ __('Featured products will appear here once they are added.') }}</p>
        </div>
        @endif
    </div>
</div>
