@props(['product'])

<div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group overflow-hidden border border-gray-100 dark:border-gray-800 relative z-20 flex flex-col h-full">
    {{-- Image Section --}}
    <div class="relative overflow-hidden bg-gray-300 dark:bg-gray-800 rounded-t-2xl flex-shrink-0">
        <a href="{{ route('products.show', $product->slug) }}">
            @php
                $imageUrl = $product->image_url;
                $fallbackText = urlencode(substr($product->name, 0, 20));
            @endphp
            <img
                src="{{ $imageUrl }}"
                alt="{{ $product->name }}"
                class="w-full h-36 sm:h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                loading="lazy"
                onerror="
                    if(!this.classList.contains('failed')) {
                        this.src='https://placehold.co/400x400/1e293b/94a3b8?text={{ $fallbackText }}';
                        this.classList.add('failed');
                        this.parentElement.parentElement.classList.add('bg-gray-100', 'dark:bg-gray-800');
                    }
                "
                onload="this.parentElement.parentElement.classList.remove('bg-gray-300', 'dark:bg-gray-800');"
            >
        </a>
        <div class="absolute top-3 left-3 flex gap-2">
            @if($product->sale_price && $product->sale_price < $product->price)
                <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium shadow-md">Sale</span>
            @endif
            @if($product->is_featured)
                <span class="bg-yellow-500 text-white text-xs px-2 py-1 rounded-full font-medium shadow-md">Featured</span>
            @endif
        </div>
    </div>

    <div class="p-3 sm:p-5 flex flex-col flex-grow">
        <div class="flex items-center justify-between mb-1.5 sm:mb-2">
            <div class="text-[10px] sm:text-xs text-indigo-600 dark:text-indigo-400 font-medium bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 sm:py-1 rounded-full inline-block truncate max-w-[60%]">
                {{ $product->category->name ?? 'Uncategorized' }}
            </div>
            
            @if($product->seller)
                <a href="{{ route('stores.show', $product->seller->slug) }}" 
                   class="text-[10px] font-bold text-gray-500 hover:text-indigo-600 dark:text-gray-400 transition-colors uppercase tracking-tight">
                    {{ Str::limit($product->seller->store_name, 12) }}
                </a>
            @endif
        </div>

        <h3 class="text-sm sm:text-base text-gray-900 dark:text-gray-100 mb-2 sm:mb-3 line-clamp-2 leading-tight font-medium">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                {{ $product->name }}
            </a>
        </h3>
        
        <div>
            @if($product->sale_price && $product->compare_price && $product->sale_price < $product->compare_price)
                <span class="text-sm sm:text-lg font-bold text-green-600 dark:text-green-400">
                    {{ \App\Helpers\CurrencyHelper::format($product->sale_price) }}
                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">
                    {{ \App\Helpers\CurrencyHelper::format($product->compare_price) }}
                </span>
            @elseif($product->sale_price && $product->sale_price < $product->price)
                <span class="text-sm sm:text-lg font-bold text-green-600 dark:text-green-400">
                    {{ \App\Helpers\CurrencyHelper::format($product->sale_price) }}
                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400 line-through ml-2">
                    {{ \App\Helpers\CurrencyHelper::format($product->price) }}
                </span>
            @else
                <span class="text-sm sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                    {{ \App\Helpers\CurrencyHelper::format($product->price) }}
                </span>
            @endif
        </div>

        {{-- RATING SECTION using x-icon-dashboard --}}
        <div class="flex items-center mb-2">
            <div class="flex {{ $product->average_rating > 0 ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">
                @for ($i = 1; $i <= 5; $i++)
                    <x-icon-dashboard 
                        name="{{ ($product->average_rating > 0 && $i <= round($product->average_rating)) ? 'star-filled' : 'star-empty' }}" 
                        class="w-4 h-4" 
                    />
                @endfor
            </div>
            <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">
                {{ $product->reviews_count > 0
                    ? "({$product->reviews_count} " . \Illuminate\Support\Str::plural('review', $product->reviews_count) . ")"
                    : '(No reviews yet)' }}
            </span>
        </div>

        {{-- ACTION BUTTONS using x-icon-dashboard --}}
        <div class="flex justify-between items-center mt-auto pt-4">
            <div class="flex items-center">
                @auth
                    <button onclick="event.stopPropagation(); addToCart({{ $product->id }}, this)"
                        type="button"
                        class="add-to-cart-btn flex items-center gap-1 sm:gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-2.5 sm:px-4 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm transition-all shadow-md">
                        <x-icon-dashboard name="cart" class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" />
                        <span class="hidden xs:inline sm:inline">Add</span>
                    </button>
                @else
                    <button onclick="event.stopPropagation(); redirectToLogin()"
                        type="button"
                        class="add-to-cart-btn flex items-center gap-1 sm:gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-2.5 sm:px-4 py-2 sm:py-2.5 rounded-full text-xs sm:text-sm transition-all shadow-md">
                        <x-icon-dashboard name="cart" class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" />
                        <span class="hidden xs:inline sm:inline">Add</span>
                    </button>
                @endauth
            </div>

            <div class="flex items-center gap-1.5 sm:gap-3">
                @auth
                    @php $inWishlist = auth()->user()->hasInWishlist($product->id); @endphp
                    <button onclick="event.stopPropagation(); toggleWishlist({{ $product->id }}, this)"
                        type="button"
                        class="wishlist-btn border border-gray-300 dark:border-gray-700 shadow-sm transition-all rounded-full flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10
                        {{ $inWishlist ? 'text-red-500 border-red-400' : 'text-gray-400 dark:text-gray-500 hover:border-red-400 hover:text-red-400' }}">
                        <x-icon-dashboard name="{{ $inWishlist ? 'wishlist-filled' : 'wishlist' }}" class="w-4 h-4 sm:w-5 sm:h-5" />
                    </button>
                @else
                    <button onclick="event.stopPropagation(); redirectToLogin()"
                        type="button"
                        class="border border-gray-300 dark:border-gray-700 text-gray-400 dark:text-gray-500 rounded-full shadow-sm transition-all flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 hover:border-indigo-400">
                        <x-icon-dashboard name="wishlist" class="w-4 h-4 sm:w-5 sm:h-5" />
                    </button>
                @endauth

                <button type="button"
                    onclick="event.stopPropagation(); showProductInfo({{ $product->id }})"
                    class="border border-gray-300 dark:border-gray-700 text-gray-400 hover:text-indigo-600 hover:border-indigo-500 flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full transition shadow-sm">
                    <x-icon-dashboard name="info" class="w-4 h-4 sm:w-5 sm:h-5" />
                </button>
            </div>
        </div>
    </div>
</div>