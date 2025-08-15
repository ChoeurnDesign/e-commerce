<x-app-layout>
    @section('title', 'My Wishlist - ShopExpress')

    <div class="container mx-auto px-4 py-8 bg-gray-300 dark:bg-gray-900"> {{-- Added dark mode background for the container --}}
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">My Wishlist</h1> {{-- Added dark mode text color --}}
                <p class="text-gray-600 dark:text-gray-400">{{ $wishlistItems->total() }} {{ Str::plural('item', $wishlistItems->total()) }} in your wishlist</p> {{-- Added dark mode text color --}}
            </div>

            @if($wishlistItems->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($wishlistItems as $product)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300"> {{-- ADDED dark:bg-gray-800 here --}}
                            <div class="relative">
                                <img src="{{ $product->image ? asset('img/products/' . $product->image) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name) }}"

                                    alt="{{ $product->name }}" class="w-full h-48 object-cover">

                                <button
                                    onclick="toggleWishlist({{ $product->id }}, this)"
                                    class="absolute top-3 right-3 bg-white/90 hover:bg-white dark:bg-gray-700/90 dark:hover:bg-gray-700 text-red-500 hover:text-red-600 dark:text-red-400 dark:hover:text-red-500 p-3 rounded-full shadow-lg transition duration-200" {{-- Added dark mode classes for button background and text --}}
                                    data-product-id="{{ $product->id }}"
                                >
                                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </button>

                                @if($product->category)
                                    <span class="absolute top-2 left-2 bg-indigo-600 text-white px-2 py-1 rounded text-xs">
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-2 text-gray-900 dark:text-gray-100"> {{-- Added dark mode text color --}}
                                    <a href="{{ route('products.show', $product->slug) }}" class="hover:text-indigo-600 dark:hover:text-purple-400"> {{-- Added dark mode hover color --}}
                                        {{ $product->name }}
                                    </a>
                                </h3>

                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2"> {{-- Added dark mode text color --}}
                                    {{ $product->short_description }}
                                </p>

                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400"> {{-- Adjusted dark mode price color --}}
                                        ${{ number_format($product->price, 2) }}
                                    </span>

                                    @if($product->compare_price && $product->compare_price > $product->price)
                                        <span class="text-sm text-gray-500 line-through dark:text-gray-400"> {{-- Adjusted dark mode strikethrough color --}}
                                            ${{ number_format($product->compare_price, 2) }}
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center mb-3 min-h-[24px]">
                                    @if($product->reviews_count > 0)
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $product->average_rating)
                                                    <span>★</span>
                                                @else
                                                    <span class="text-gray-300 dark:text-gray-600">☆</span> {{-- Adjusted dark mode empty star color --}}
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="text-sm text-gray-600 dark:text-gray-400 ml-2"> {{-- Added dark mode text color --}}
                                            ({{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }})
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400 italic dark:text-gray-500">No Review</span> {{-- Added dark mode text color --}}
                                    @endif
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('products.show', $product->slug) }}"
                                       class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-full hover:bg-indigo-700 transition duration-200 text-center text-sm font-medium">
                                        View Details
                                    </a>

                                    <button
                                        onclick="addToCart({{ $product->id }}, this)"
                                        class="bg-green-600 text-white py-2 px-4 rounded-full hover:bg-green-700 transition duration-200 text-sm font-medium add-to-cart-btn"
                                        data-product-id="{{ $product->id }}">
                                        <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.45A1 1 0 007.5 17h9.02a1 1 0 00.86-.5L21 13M7 13V6a1 1 0 01.883-.993L8 5h9a1 1 0 01.993.883L18 6v7"></path>
                                        </svg>
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $wishlistItems->links() }}
                </div>

            @else
                <div class="text-center py-16">
                    <div class="text-6xl mb-4 text-gray-400 dark:text-gray-500">💔</div> {{-- Added dark mode text color --}}
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Your wishlist is empty</h2> {{-- Added dark mode text color --}}
                    <p class="text-gray-600 dark:text-gray-400 mb-8">Start adding products you love to your wishlist!</p> {{-- Added dark mode text color --}}
                    <a href="{{ route('products.index') }}"
                       class="bg-indigo-600 text-white py-3 px-6 rounded-lg hover:bg-indigo-700 transition duration-200 font-medium">
                        Explore Products
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
