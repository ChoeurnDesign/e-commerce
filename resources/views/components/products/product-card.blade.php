@props(['product'])

<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group overflow-hidden border border-gray-100 dark:border-gray-800 relative z-20">
    <div class="relative overflow-hidden bg-gray-300 dark:bg-gray-800 rounded-t-2xl">
        <a href="{{ route('products.show', $product->slug) }}">
            <img src="{{ $product->image ? asset('img/products/' . $product->image) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name) }}"
                alt="{{ $product->name }}"
                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                onerror="this.onerror=null; this.src='https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=No+Image';">
        </a>
        <div class="absolute top-3 left-3 flex gap-2">
            @if($product->sale_price && $product->sale_price < $product->price)
                <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full font-medium shadow-md">Sale</span>
            @endif
            @if($product->is_featured)
                <span class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-full font-medium shadow-md">Featured</span>
            @endif
        </div>
    </div>
    <div class="p-5 flex flex-col h-full">
        <div class="text-xs text-indigo-600 dark:text-purple-300 font-medium mb-2 bg-indigo-50 dark:bg-gray-800 px-3 py-1 rounded-full inline-block">
            {{ $product->category->name ?? 'Uncategorized' }}
        </div>
        <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3 line-clamp-2 leading-tight">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:underline">
                {{ $product->name }}
            </a>
        </h3>
        <div class="flex items-center justify-between mb-2">
             <div>
                @if($product->sale_price && $product->compare_price && $product->sale_price < $product->compare_price)
                    <span class="text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">${{ number_format($product->compare_price, 2) }}</span>
                @elseif($product->sale_price && $product->sale_price < $product->price)
                    <span class="text-lg font-bold text-green-600 dark:text-green-400">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                @else
                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>
            <span class="text-xs {{ $product->stock_quantity > 0 ? 'text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900' : 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900' }} px-2 py-1 rounded-full font-medium flex items-center">
                <div class="w-2 h-2 {{ $product->stock_quantity > 0 ? 'bg-green-500 dark:bg-green-400' : 'bg-red-500 dark:bg-red-400' }} rounded-full mr-2"></div>
                {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
            </span>
        </div>
        <div class="flex items-center mb-2">
            <div class="flex text-yellow-400">
                @for ($i = 1; $i <= 5; $i++)
                    @if($product->average_rating && $i <= round($product->average_rating))
                        <svg class="w-4 h-4 inline-block" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @else
                        <svg class="w-4 h-4 inline-block text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @endif
                @endfor
            </div>
            <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">
                {{ $product->reviews_count > 0
                    ? "({$product->reviews_count} " . \Illuminate\Support\Str::plural('review', $product->reviews_count) . ")"
                    : '(No reviews yet)' }}
            </span>
        </div>

        <div class="flex gap-4 mt-4 items-center">
            @auth
                {{-- Add to Cart --}}
                <button onclick="event.stopPropagation(); addToCart({{ $product->id }}, this)"
                    type="button"
                    class="add-to-cart-btn flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-2 py-2.5 rounded-full text-sm font-semibold transition-all shadow-md"
                    style="font-size: 1rem; min-width:unset;"
                    data-product-id="{{ $product->id }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.45A1 1 0 007.5 17h9.02a1 1 0 00.86-.5L21 13M7 13V6a1 1 0 01.883-.993L8 5h9a1 1 0 01.993.883L18 6v7"></path>
                    </svg>
                    Add To Cart
                </button>

                {{-- Wishlist --}}
                <button onclick="event.stopPropagation(); toggleWishlist({{ $product->id }}, this)"
                    type="button"
                    class="wishlist-btn border border-gray-400 dark:border-gray-700 shadow transition-all p-0 rounded-full flex items-center justify-center w-10 h-10 {{ auth()->user()->hasInWishlist($product->id) ? 'text-red-500' : 'text-gray-400 dark:text-gray-500 hover:border-red-400 dark:hover:border-red-400' }}"
                    data-product-id="{{ $product->id }}"
                    aria-label="Add to favorites">
                    @if(auth()->user()->hasInWishlist($product->id))
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    @endif
                </button>
            @else
                {{-- Add to Cart (guest) --}}
                <button onclick="event.stopPropagation(); redirectToLogin()"
                    type="button"
                    class="add-to-cart-btn flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-full text-sm font-semibold transition-all shadow-md"
                    style="font-size: 1rem; min-width:unset;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.45A1 1 0 007.5 17h9.02a1 1 0 00.86-.5L21 13M7 13V6a1 1 0 01.883-.993L8 5h9a1 1 0 01.993.883L18 6v7"></path>
                    </svg>
                    Add To Cart
                </button>

                {{-- Wishlist (guest) --}}
                <button onclick="event.stopPropagation(); redirectToLogin()"
                        type="button"
                        class="border border-gray-400 dark:border-gray-700 text-gray-400 dark:text-gray-500 p-0 rounded-full shadow transition-all flex items-center justify-center w-10 h-10 hover:border-indigo-400 dark:hover:border-indigo-400"
                        aria-label="Add to favorites">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </button>
            @endauth

            {{-- more info --}}
            <button type="button"
                    onclick="event.stopPropagation(); showProductInfo({{ $product->id }})"
                    class="border border-gray-400 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-purple-300 hover:border-indigo-600 dark:hover:border-purple-400 flex items-center justify-center w-10 h-10 rounded-full transition"
                    title="More Info">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="size-6">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>
            </button>
        </div>
    </div>
</div>
