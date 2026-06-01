<div class="flex flex-col sm:flex-row items-center gap-4 px-6 py-4" data-product-id="{{ $item['id'] }}">
    @php
        $image = $item['image'] ?? '';
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            $imgSrc = $image;
        } elseif (!empty($image)) {
            $imgSrc = str_starts_with($image, 'storage/') ? asset($image) : asset('storage/' . $image);
        } else {
            $imgSrc = 'https://placehold.co/400x400/e2e8f0/94a3b8?text=No+Image';
        }
    @endphp

    {{-- Product Image --}}
    <a href="{{ route('products.show', $item['slug']) }}" class="flex-shrink-0">
        <img
            src="{{ $imgSrc }}"
            alt="{{ $item['name'] }}"
            class="w-16 h-16 object-cover rounded-lg border border-gray-200"
            onerror="this.onerror=null;this.src='https://placehold.co/400x400/e2e8f0/94a3b8?text=No+Image';"
        />
    </a>

    {{-- Product Info --}}
    <div class="flex-1 w-full min-w-0">
        <div class="flex items-center justify-between">
            <a href="{{ route('products.show', $item['slug']) }}"
                class="font-medium text-gray-900 hover:text-pink-600 truncate block">
                {{ $item['name'] }}
            </a>

            {{-- ✅ SweetAlert2 confirm instead of browser confirm() --}}
            <form action="{{ route('cart.remove', $item['id']) }}" method="POST" class="inline ml-2">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="text-gray-400 hover:text-red-500 p-2.5 rounded transition"
                    title="Remove" aria-label="Remove"
                    onclick="confirmRemove(event, this)">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>

        {{-- Price --}}
        <div class="flex items-center gap-2 mt-1">
            @if(isset($item['sale_price']) && $item['sale_price'] && $item['sale_price'] < $item['original_price'])
                <span class="text-sm font-semibold text-green-600">
                    {{ \App\Helpers\CurrencyHelper::format($item['sale_price']) }}
                </span>
                <span class="text-xs text-gray-400 line-through">
                    {{ \App\Helpers\CurrencyHelper::format($item['original_price']) }}
                </span>
            @else
                <span class="text-sm font-semibold text-gray-900">
                    {{ \App\Helpers\CurrencyHelper::format($item['price']) }}
                </span>
            @endif

            @if(isset($item['stock_quantity']) && $item['stock_quantity'] <= 5)
                <span class="text-xs text-orange-500 ml-2">
                    Only {{ $item['stock_quantity'] }} left
                </span>
            @endif
        </div>
    </div>

    {{-- Quantity Controls --}}
    <div class="flex flex-col items-center gap-2 min-w-[6rem]">
        <div class="flex items-center border border-gray-300 rounded-md overflow-hidden bg-white">
            <button type="button"
                class="quantity-btn px-2 py-1 text-gray-700 hover:bg-gray-100 active:bg-gray-200 transition"
                data-action="decrease"
                data-product-id="{{ $item['id'] }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                </svg>
            </button>

            {{-- ✅ data-original-quantity required for change detection --}}
            <input
                type="number"
                name="quantities[{{ $item['id'] }}]"
                value="{{ $item['quantity'] }}"
                min="1"
                max="{{ $item['stock_quantity'] }}"
                class="quantity-input w-16 text-center border-0 focus:ring-0 focus:outline-none bg-transparent text-gray-900 font-semibold text-sm"
                data-product-id="{{ $item['id'] }}"
                data-original-quantity="{{ $item['quantity'] }}"
                data-price="{{ isset($item['sale_price']) && $item['sale_price'] && $item['sale_price'] < $item['original_price'] ? $item['sale_price'] : $item['price'] }}"
            />

            <button type="button"
                class="quantity-btn px-2 py-1 text-gray-700 hover:bg-gray-100 active:bg-gray-200 transition"
                data-action="increase"
                data-product-id="{{ $item['id'] }}"
                data-max="{{ $item['stock_quantity'] }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
        </div>

        <div class="text-xs mt-1 font-semibold text-gray-700 item-subtotal"
            data-product-id="{{ $item['id'] }}">
            {{ \App\Helpers\CurrencyHelper::format($item['subtotal']) }}
        </div>
    </div>
</div>