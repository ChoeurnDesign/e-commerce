{{-- Featured Products section --}}
@props(['featuredProducts'])

<div id="featured-products" class="py-10 sm:py-14 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section header --}}
        <div class="flex items-end justify-between mb-6 sm:mb-8">
            <div>
                <span class="text-xs font-bold text-pink-600 uppercase tracking-wider">
                    {{ __('Hand-picked') }}
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mt-0.5">
                    {{ __('Featured Products') }}
                </h2>
            </div>
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-1 text-sm font-semibold text-pink-600
                      hover:text-pink-600 transition-colors">
                {{ __('View all') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2 sm:gap-3">
                @foreach($featuredProducts as $product)
                    <x-products.product-card :product="$product" :compact="true" />
                @endforeach
            </div>
        @else
            <div class="text-center py-14">
                <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-100 mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-600">{{ __('No Products Yet') }}</h3>
            </div>
        @endif

    </div>
</div>

