<x-app-layout>
    <div class="py-8 bg-gray-300 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-purple-400">Home</a> /
                <a href="{{ route('products.index') }}" class="hover:text-indigo-600 dark:hover:text-purple-400">Products</a> /
                <span class="text-gray-900 dark:text-gray-100">{{ $product->name }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <!-- Product Image Gallery -->
                <div>
                    <div class="relative bg-gray-300 dark:bg-gray-800 rounded-lg overflow-hidden mb-4">
                        <img id="mainImage"
                            src="{{ $product->image ? (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset($product->image)) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=No+Image';">
                        @if($product->is_on_sale)
                            <span class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">Sale</span>
                        @endif
                    </div>
                    @php
                        $productImages = [];
                        // Merge images, gallery, and main image without duplicates
                        if (isset($product->images) && is_array($product->images)) {
                            $productImages = array_merge($productImages, $product->images);
                        }
                        if (isset($product->gallery) && is_array($product->gallery)) {
                            $productImages = array_merge($productImages, $product->gallery);
                        }
                        if (!empty($product->image) && !in_array($product->image, $productImages)) {
                            array_unshift($productImages, $product->image);
                        }
                        // Remove duplicate image paths
                        $productImages = array_values(array_unique($productImages));
                    @endphp
                    @if(count($productImages) > 0)
                        <div class="grid grid-cols-5 gap-2">
                            @foreach($productImages as $index => $image)
                                <div
                                    onclick="changeMainImage('{{ filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image) }}', this)"
                                    class="cursor-pointer border-2 {{ $index === 0 ? 'border-indigo-500 dark:border-purple-400' : 'border-transparent hover:border-indigo-300 dark:hover:border-purple-400' }} rounded-md overflow-hidden transition-all"
                                >
                                    <img
                                        src="{{ filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image) }}"
                                        alt="{{ $product->name }} - Image {{ $index + 1 }}"
                                        class="h-16 w-full object-cover"
                                    >
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div>
                        <a href="{{ route('category.show', $product->category->slug) }}" class="text-indigo-600 dark:text-purple-400 text-sm font-medium">
                            {{ $product->category->name }}
                        </a>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $product->name }}</h1>
                        @if($product->short_description)
                            <p class="text-gray-600 dark:text-gray-300 mt-2">{{ $product->short_description }}</p>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="flex items-center space-x-3">
                        @if($product->is_on_sale)
                            <span class="text-3xl font-bold text-green-600 dark:text-green-400">${{ number_format($product->price, 2) }}</span>
                            <span class="text-xl text-gray-500 dark:text-gray-400 line-through">${{ number_format($product->compare_price, 2) }}</span>
                            <span class="text-sm bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded">
                                Save {{ $product->discount_percentage }}%
                            </span>
                        @else
                            <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <!-- Rating -->
                    @if($product->reviews_count > 0)
                    <div class="flex items-center space-x-2">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($product->average_rating))
                                    <x-icon-nav name="star-empty" class="w-5 h-5" />
                                @else
                                    <x-icon-nav name="star-filled" class="w-5 h-5 text-gray-300 dark:text-gray-600" />
                                @endif
                            @endfor
                        </div>
                        <span class="text-gray-600 dark:text-gray-300">{{ $product->reviews_count }} {{ Str::plural('review', $product->reviews_count) }}</span>
                    </div>
                    @endif

                    <!-- SKU -->
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        SKU: <span class="font-medium">{{ $product->sku }}</span>
                    </div>

                    <!-- Stock -->
                    <div class="flex items-center space-x-2">
                        @if($product->stock_quantity > 0)
                            <span class="w-3 h-3 bg-green-500 dark:bg-green-400 rounded-full"></span>
                            <span class="text-green-600 dark:text-green-400 font-medium">{{ $product->stock_quantity }} in stock</span>
                        @else
                            <span class="w-3 h-3 bg-red-500 dark:bg-red-400 rounded-full"></span>
                            <span class="text-red-600 dark:text-red-400 font-medium">Out of stock</span>
                        @endif
                    </div>

                    <!-- Actions -->
                    @if($product->stock_quantity > 0)
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <label class="text-sm font-medium">Qty:</label>
                                <select id="quantity"
                                    class="border border-gray-300 dark:border-gray-700 rounded-full px-3 py-1 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-purple-400 focus:border-indigo-500 dark:focus:border-purple-400 transition text-base appearance-none bg-white dark:bg-gray-900 dark:text-gray-100 w-20">
                                    @for($i = 1; $i <= min(10, $product->stock_quantity); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="flex items-center space-x-2">
                                <button
                                    onclick="addToCart({{ $product->id }}, this, document.getElementById('quantity').value)"
                                    class="add-to-cart-btn flex items-center gap-2 bg-indigo-600 dark:bg-purple-700 hover:bg-indigo-700 dark:hover:bg-purple-600 text-white py-2 px-2 rounded-full font-medium transition text-sm"
                                    style="font-size: 1rem;"
                                    type="button">
                                    <!-- cart icon -->
                                    <x-icon-nav name="cart" class="h-5 w-5 mr-1" />
                                    Add to Cart
                                </button>
                                @auth
                                    <button onclick="toggleWishlist({{ $product->id }}, this)"
                                            class="wishlist-btn p-2 rounded-lg border transition flex items-center justify-center {{ auth()->user()->hasInWishlist($product->id) ? 'bg-red-50 dark:bg-red-900 text-red-600 dark:text-red-400 border-red-200 dark:border-red-900' : 'bg-gray-300 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-800 hover:bg-red-50 dark:hover:bg-red-900 hover:text-red-600 dark:hover:text-red-400' }}"
                                            style="width: 40px; height: 40px;"
                                            aria-label="Wishlist"
                                            type="button">
                                        @if(auth()->user()->hasInWishlist($product->id))
                                            <!-- Solid heart icon -->
                                            <x-icon-nav name="wishlist-filled" />
                                        @else
                                            <!-- Outline heart icon -->
                                            <x-icon-nav name="wishlist" />
                                        @endif
                                    </button>
                                @else
                                    <a href="{{ route('login') }}"
                                       class="p-2 rounded-lg border bg-gray-300 dark:bg-gray-800 text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-800 hover:bg-red-50 dark:hover:bg-red-900 hover:text-red-600 dark:hover:text-red-400 transition flex items-center justify-center"
                                       style="width: 40px; height: 40px;"
                                       aria-label="Wishlist">
                                        <!-- Outline heart icon -->
                                        <x-icon-nav name="wishlist" />
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @else
                        <button disabled class="w-full bg-gray-400 dark:bg-gray-700 text-white py-3 px-6 rounded-lg font-medium cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif

                    <!-- Features -->
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-gray-200 dark:border-gray-700 text-sm">
                        <div class="flex items-center space-x-2">
                            <span class="text-green-500 dark:text-green-400">✓</span>
                            <span class="dark:text-gray-300">Free Shipping</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-green-500 dark:text-green-400">✓</span>
                            <span class="dark:text-gray-300">Guarantee</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-green-500 dark:text-green-400">✓</span>
                            <span class="dark:text-gray-300">Easy Returns</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8">
                <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Description</h2>
                <div class="text-gray-600 dark:text-gray-300">{!! $product->description !!}</div>
            </div>

            <!-- Specifications Table: Display product specifications if present -->
            @if(!empty($product->specifications) && is_array($product->specifications))
                <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8">
                    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Specifications</h2>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <tbody>
                        @foreach($product->specifications as $key => $value)
                            <tr>
                                <td class="py-2 px-4 font-semibold text-gray-800 dark:text-gray-200">{{ $key }}</td>
                                <td class="py-2 px-4 text-gray-600 dark:text-gray-300">{{ $value }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Reviews Section -->
            @include('products._reviews', ['product' => $product, 'userReview' => $userReview ?? null, 'relatedProducts' => $relatedProducts ?? null])

        </div>
    </div>
    @push('scripts')
    <script>
        // Gallery Image Switching with thumbnail highlight
        function changeMainImage(imageUrl, thumbDiv) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = imageUrl;

            // Remove highlight from all thumbnails
            const thumbnails = document.querySelectorAll('.grid.grid-cols-5 > div');
            thumbnails.forEach(thumb => {
                thumb.className = 'cursor-pointer border-2 border-transparent hover:border-indigo-300 dark:hover:border-purple-400 rounded-md overflow-hidden transition-all';
            });

            // Highlight the clicked thumbnail
            if(thumbDiv) {
                thumbDiv.className = 'cursor-pointer border-2 border-indigo-500 dark:border-purple-400 rounded-md overflow-hidden transition-all';
            }
        }
    </script>
    @endpush
</x-app-layout>
