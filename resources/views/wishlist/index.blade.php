<x-app-layout>
    @section('title', 'My Wishlist - ShopExpress')

    {{-- 
        Main Wrapper: 
        Applied 'bg-gray-300 dark:bg-gray-900' and 'min-h-screen' 
        to ensure the background matches your Shopping Cart page.
    --}}
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php $total = $wishlistItems->total(); @endphp

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">My Wishlist</h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ $total }} {{ \Illuminate\Support\Str::plural('item', $total) }} in your wishlist
                </p>
            </div>

            @if($wishlistItems->count())
                {{-- Grid layout for products --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($wishlistItems as $product)
                        {{-- Using your specific product card component --}}
                        <x-products.product-card 
                            :product="$product" 
                            :showMoreInfo="false" 
                            cardClass="shadow-md hover:shadow-lg" 
                        />
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $wishlistItems->links() }}
                </div>
            @else
                {{-- Empty state styling with dark mode support --}}
                <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                    <div class="text-6xl mb-4 text-gray-400 dark:text-gray-500">💔</div>
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Your wishlist is empty</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">Start adding products you love to your wishlist!</p>
                    <a href="{{ route('products.index') }}"
                       class="bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-200 font-medium">
                        Explore Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>