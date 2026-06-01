<x-app-layout>
    @section('title', 'My Wishlist - ShopExpress')

    <div class="py-8 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @php $total = $wishlistItems->total(); @endphp

            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-900">My Wishlist</h1>
                <p class="text-gray-600 mt-2">
                    {{ $total }} {{ \Illuminate\Support\Str::plural('item', $total) }} in your wishlist
                </p>
            </div>

            @if($wishlistItems->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($wishlistItems as $product)
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
                <div class="text-center py-16">
                    <div class="text-6xl mb-6">💔</div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-4">Your wishlist is empty</h3>
                    <p class="text-gray-500 mb-8">Start adding products you love to your wishlist!</p>
                    <a href="{{ route('products.index') }}"
                       class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Explore Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
