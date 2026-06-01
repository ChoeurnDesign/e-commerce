{{-- New Arrivals section — latest products, different from featured --}}
@props(['newArrivals'])

@if($newArrivals && $newArrivals->count() > 0)
<div id="new-arrivals" class="py-10 sm:py-14 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section header --}}
        <div class="flex items-end justify-between mb-6 sm:mb-8">
            <div>
                <span class="text-xs font-bold text-pink-600 uppercase tracking-wider">
                    {{ __('Just Added') }}
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mt-0.5">
                    {{ __('New Arrivals') }}
                </h2>
            </div>
            <a href="{{ route('products.index', ['sort' => 'latest']) }}"
               class="inline-flex items-center gap-1 text-sm font-semibold text-pink-600
                      hover:text-pink-600 transition-colors">
                {{ __('See all') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Product grid --}}
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2 sm:gap-3">
            @foreach($newArrivals as $product)
                <x-products.product-card :product="$product" :compact="true" />
            @endforeach
        </div>

    </div>
</div>
@endif

