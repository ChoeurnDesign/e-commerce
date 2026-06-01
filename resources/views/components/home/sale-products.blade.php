@props(['saleProducts'])

@if($saleProducts && $saleProducts->count() > 0)
<section id="sale-products" class="relative overflow-hidden py-10 sm:py-14">

    {{-- Vivid gradient background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-rose-600 via-pink-600 to-orange-500"></div>
    {{-- Subtle noise/depth overlay --}}
    <div class="absolute inset-0 opacity-10"
         style="background-image: radial-gradient(circle at 20% 50%, white 1px, transparent 1px),
                                  radial-gradient(circle at 80% 20%, white 1px, transparent 1px);
                background-size: 60px 60px;"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between mb-6 sm:mb-8 gap-3">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <div class="flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-white/20 backdrop-blur-sm flex-shrink-0">
                        <x-icon-dashboard name="sale" class="w-5 h-5 sm:w-6 sm:h-6 text-white" />
                    </div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                        {{ __('Flash Sale') }}
                    </h2>
                </div>
                <p class="text-white/70 text-sm sm:text-base ml-1">
                    {{ __('Limited-time deals — grab them before they\'re gone') }}
                </p>
            </div>

            <a href="{{ route('products.shops_on_sale') }}"
               class="inline-flex items-center gap-2 self-start sm:self-auto
                      bg-white/15 hover:bg-white/25 backdrop-blur-sm
                      border border-white/30 hover:border-white/60
                      text-white font-semibold
                      py-2 px-5 rounded-full
                      transition-all duration-300 text-sm whitespace-nowrap
                      hover:-translate-y-0.5">
                {{ __('View All Deals') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Product grid --}}
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 gap-2 sm:gap-3">
            @foreach($saleProducts->take(8) as $product)
            @php
                $saleP = (float) $product->sale_price;
                $origP = (float) $product->price;
                $discountPct = $origP > 0 ? round((($origP - $saleP) / $origP) * 100) : 0;
            @endphp
            <a href="{{ route('products.show', $product->slug) }}"
               class="group relative bg-white rounded-xl overflow-hidden
                      hover:shadow-lg hover:-translate-y-0.5
                      transition-all duration-200 flex flex-col border border-white/10">

                {{-- Discount badge --}}
                @if($discountPct > 0)
                <div class="absolute top-1.5 left-1.5 z-10
                             bg-rose-500 text-white text-[9px] font-extrabold
                             px-1.5 py-0.5 rounded-full shadow-sm leading-none">
                    -{{ $discountPct }}%
                </div>
                @endif

                {{-- Product image --}}
                <div class="relative bg-gray-100 overflow-hidden flex-shrink-0" style="padding-top: 100%">
                    <img src="{{ $product->image_url }}"
                         alt="{{ $product->name }}"
                         class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-400"
                         loading="lazy"
                         onerror="this.onerror=null;this.src='https://placehold.co/200x200/f3f4f6/9ca3af?text=?'">
                </div>

                {{-- Product info --}}
                <div class="p-2 flex flex-col flex-1">
                    <h3 class="text-[11px] font-medium text-gray-900 line-clamp-2 leading-snug mb-1.5 flex-1">
                        {{ $product->name }}
                    </h3>

                    <div class="flex items-baseline gap-1 flex-wrap mb-2">
                        <span class="text-sm font-extrabold text-rose-400">
                            ${{ number_format($saleP, 0) }}
                        </span>
                        <span class="text-[9px] text-white/50 line-through">
                            ${{ number_format($origP, 0) }}
                        </span>
                    </div>

                    @auth
                    <button type="button"
                            onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $product->id }}, this)"
                            class="add-to-cart-btn w-full flex items-center justify-center gap-1
                                   bg-white/20 hover:bg-white/30
                                   text-white font-semibold
                                   py-1 rounded-lg text-[10px]
                                   transition-colors duration-200">
                        {{ __('Add to Cart') }}
                    </button>
                    @else
                    <button type="button"
                            onclick="event.preventDefault(); event.stopPropagation(); redirectToLogin()"
                            class="w-full flex items-center justify-center gap-1
                                   bg-white/20 hover:bg-white/30
                                   text-white font-semibold
                                   py-1 rounded-lg text-[10px]
                                   transition-colors duration-200">
                        {{ __('Add to Cart') }}
                    </button>
                    @endauth
                </div>
            </a>
            @endforeach
        </div>

        {{-- Bottom CTA --}}
        <div class="text-center mt-8">
            <a href="{{ route('products.shops_on_sale') }}"
               class="inline-flex items-center gap-2
                      bg-white text-rose-600 hover:bg-rose-50
                      font-bold py-3 px-8 rounded-full
                      shadow-lg shadow-black/20
                      hover:shadow-xl hover:-translate-y-0.5
                      transition-all duration-300 text-sm sm:text-base">
                {{ __('Shop All Sale Items') }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>
</section>
@endif
