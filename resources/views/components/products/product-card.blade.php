@props(['product', 'compact' => false])

@php
    $imageUrl    = $product->image_url;
    $fallbackTxt = urlencode(substr($product->name, 0, 20));
    $hasSale     = $product->sale_price && $product->sale_price < $product->price;
    $displayPrice = $hasSale ? $product->sale_price : $product->price;
@endphp

@if($compact)
{{-- ─── Compact card (Taobao-style: square image + name + price) ──── --}}
<a href="{{ route('products.show', $product->slug) }}"
   class="block group bg-white rounded-lg overflow-hidden
          hover:shadow-md transition-shadow duration-200">

    {{-- Square image --}}
    <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
        <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
             loading="lazy"
             onerror="this.onerror=null;this.src='https://placehold.co/300x300/f3f4f6/9ca3af?text={{ $fallbackTxt }}'">

        @if($hasSale)
        @php $discPct = round((($product->price - $product->sale_price) / $product->price) * 100); @endphp
        <span class="absolute top-1.5 left-1.5 bg-orange-500 text-white text-[9px] font-bold
                     px-1.5 py-0.5 rounded leading-none">
            -{{ $discPct }}%
        </span>
        @endif
    </div>

    {{-- Info --}}
    <div class="p-2">
        <p class="text-[11px] text-gray-700 line-clamp-2 leading-snug mb-1">
            {{ $product->name }}
        </p>
        <span class="text-sm font-bold text-orange-500">
            {{ \App\Helpers\CurrencyHelper::format($displayPrice) }}
        </span>
        @if($hasSale)
        <span class="text-[10px] text-gray-400 line-through ml-1">
            {{ \App\Helpers\CurrencyHelper::format($product->price) }}
        </span>
        @endif
    </div>

</a>

@else
{{-- ─── Standard card (square image + name + price, no buttons) ───── --}}
<a href="{{ route('products.show', $product->slug) }}"
   class="block group bg-white rounded-xl overflow-hidden
          border border-gray-100
          hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">

    {{-- Square image --}}
    <div class="relative w-full aspect-square overflow-hidden bg-gray-100">
        <img src="{{ $imageUrl }}" alt="{{ $product->name }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
             loading="lazy"
             onerror="this.onerror=null;this.src='https://placehold.co/400x400/f3f4f6/9ca3af?text={{ $fallbackTxt }}'">

        @if($hasSale)
        @php $discPct = round((($product->price - $product->sale_price) / $product->price) * 100); @endphp
        <span class="absolute top-2 left-2 bg-orange-500 text-white text-[10px] font-bold
                     px-2 py-0.5 rounded leading-none">
            -{{ $discPct }}%
        </span>
        @endif
    </div>

    {{-- Info --}}
    <div class="p-2.5">
        <p class="text-xs text-gray-800 line-clamp-2 leading-snug mb-1.5">
            {{ $product->name }}
        </p>
        <div class="flex items-baseline gap-1.5">
            <span class="text-sm font-bold text-orange-500">
                {{ \App\Helpers\CurrencyHelper::format($displayPrice) }}
            </span>
            @if($hasSale)
            <span class="text-[10px] text-gray-400 line-through">
                {{ \App\Helpers\CurrencyHelper::format($product->price) }}
            </span>
            @endif
        </div>
    </div>

</a>
@endif
