@props(['product'])


<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group overflow-hidden border border-gray-100 dark:border-gray-800 relative z-20">
    <div class="relative overflow-hidden bg-gray-300 dark:bg-gray-800 rounded-t-2xl">
        <a href="{{ route('products.show', $product->slug) }}">
            <img
                src="{{ $product->image ? (filter_var($product->image, FILTER_VALIDATE_URL) ? $product->image : asset($product->image)) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name) }}"
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
        <div class="text-xs text-indigo-600 dark:text-purple-300 font-medium mb-2 bg-gray-300 dark:bg-gray-800 px-3 py-1 rounded-full inline-block">
            {{ $product->category->name ?? 'Uncategorized' }}
        </div>
        <h3 class= "text-gray-900 dark:text-gray-100 mb-3 line-clamp-2 leading-tight">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:underline">
                {{ $product->name }}
            </a>
        </h3>
        <div>
            @if($product->sale_price && $product->compare_price && $product->sale_price < $product->compare_price)
                <span class="text-lg font-bold text-green-600 dark:text-green-400">
                    {{ \App\Helpers\CurrencyHelper::format($product->sale_price) }}
                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">
                    {{ \App\Helpers\CurrencyHelper::format($product->compare_price) }}
                </span>
            @elseif($product->sale_price && $product->sale_price < $product->price)
                <span class="text-lg font-bold text-green-600 dark:text-green-400">
                    {{ \App\Helpers\CurrencyHelper::format($product->sale_price) }}
                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">
                    {{ \App\Helpers\CurrencyHelper::format($product->price) }}
                </span>
            @else
                <span class="text-lg font-bold text-gray-900 dark:text-gray-100">
                    {{ \App\Helpers\CurrencyHelper::format($product->price) }}
                </span>
            @endif
            </div>
        <div class="flex items-center mb-2">
            <div class="flex text-yellow-400">
                @for ($i = 1; $i <= 5; $i++)
                    @if($product->average_rating && $i <= round($product->average_rating))
                        <x-icon-nav name="star-empty" class="w-4 h-4 inline-block" />
                    @else
                        <x-icon-nav name="star-filled" class="w-4 h-4 inline-block" />
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
                    class="add-to-cart-btn flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-2 py-2.5 rounded-full text-sm transition-all shadow-md"
                    style="font-size: 1rem; min-width:unset;"
                    data-product-id="{{ $product->id }}">
                    <x-icon-nav name="cart" />
                    Add To Cart
                </button>

                {{-- Wishlist --}}
                <button onclick="event.stopPropagation(); toggleWishlist({{ $product->id }}, this)"
                    type="button"
                    class="wishlist-btn border-2 border-gray-400 dark:border-gray-700 shadow transition-all p-0 rounded-full flex items-center justify-center w-10 h-10 {{ auth()->user()->hasInWishlist($product->id) ? 'text-red-500' : 'text-gray-400 dark:text-gray-500 hover:border-red-400 dark:hover:border-red-400' }}"
                    data-product-id="{{ $product->id }}"
                    aria-label="Add to favorites">
                    @if(auth()->user()->hasInWishlist($product->id))
                        <x-icon-nav name="wishlist" />
                    @else
                        <x-icon-nav name="wishlist-filled" />
                    @endif
                </button>
            @else
                {{-- Add to Cart (guest) --}}
                <button onclick="event.stopPropagation(); redirectToLogin()"
                    type="button"
                    class="add-to-cart-btn flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-2 py-2 rounded-full text-sm transition-all shadow-md"
                    style="font-size: 1rem; min-width:unset;">
                    <x-icon-nav name="cart"/>
                    Add To Cart
                </button>

                {{-- Wishlist (guest) --}}
                <button onclick="event.stopPropagation(); redirectToLogin()"
                        type="button"
                        class="border-2 border-gray-400 dark:border-gray-700 text-gray-400 dark:text-gray-500 p-0 rounded-full shadow transition-all flex items-center justify-center w-10 h-10 hover:border-indigo-400 dark:hover:border-indigo-400"
                        aria-label="Add to favorites">
                    <x-icon-nav name="wishlist-filled" />
                </button>
            @endauth

            {{-- more info --}}
            <button type="button"
                    onclick="event.stopPropagation(); showProductInfo({{ $product->id }})"
                    class="border-2 border-gray-400 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-purple-300 hover:border-indigo-600 dark:hover:border-purple-400 flex items-center justify-center w-10 h-10 rounded-full transition"
                    title="More Info">
                <x-icon-nav name="info" />
            </button>
        </div>
    </div>
</div>
