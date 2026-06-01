<x-app-layout>
    @php
        $isOnSaleAdmin  = $product->on_sale && $product->sale_price && (float)$product->sale_price < (float)$product->price;
        $isOnSaleCompare = !$isOnSaleAdmin && $product->is_on_sale;
        $showSaleBadge   = $isOnSaleAdmin || $isOnSaleCompare;
        $currentPrice    = $isOnSaleAdmin ? (float)$product->sale_price : (float)$product->price;
        $originalPrice   = $isOnSaleAdmin ? (float)$product->price : ($isOnSaleCompare ? (float)$product->compare_price : null);
        $savePct = null;
        if ($isOnSaleAdmin && $product->price > 0) {
            $savePct = round((($product->price - $product->sale_price) / $product->price) * 100);
        } elseif ($isOnSaleCompare && ($product->discount_percentage ?? 0)) {
            $savePct = $product->discount_percentage;
        }

        $productImages = [];
        if (isset($product->images) && is_array($product->images))  $productImages = array_merge($productImages, $product->images);
        if (isset($product->gallery) && is_array($product->gallery)) $productImages = array_merge($productImages, $product->gallery);
        if (!empty($product->image) && !in_array($product->image, $productImages)) array_unshift($productImages, $product->image);
        $productImages = array_values(array_unique($productImages));
    @endphp

    <div class="py-6">
        <div class="max-w-full mx-auto px-6 sm:px-10 lg:px-16">

            {{-- Breadcrumb --}}
            <nav class="mb-5 flex items-center gap-1.5 text-xs text-gray-500 flex-wrap">
                <a href="{{ route('home') }}" class="hover:text-pink-600 transition-colors">{{ __('Home') }}</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('products.index') }}" class="hover:text-pink-600 transition-colors">{{ __('Products') }}</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('category.show', $product->category->slug) }}" class="hover:text-pink-600 transition-colors">{{ $product->category->name }}</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-gray-800 font-medium truncate">{{ Str::limit($product->name, 50) }}</span>
            </nav>

            {{-- ═══ MAIN PRODUCT CARD ═══════════════════════════════════════ --}}
            <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">

                    {{-- ── Left: Image gallery ─────────────────────────────── --}}
                    <div class="lg:col-span-5 p-5 bg-gradient-to-br from-pink-50/40 to-white">
                        <div class="sticky top-24">
                            <div class="relative bg-white rounded-2xl overflow-hidden aspect-square border border-pink-100 group">
                                <img id="mainImage"
                                     src="{{ $product->image_url }}"
                                     alt="{{ $product->name }}"
                                     class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     onerror="this.onerror=null;this.src='https://placehold.co/600x600/fdf2f8/f9a8d4?text=No+Image'">

                                @if($showSaleBadge)
                                    <span class="absolute top-4 left-4 bg-gradient-to-r from-rose-500 to-pink-500 text-white px-3 py-1 rounded-full text-xs font-extrabold shadow-md">
                                        @if($savePct) -{{ $savePct }}% @else {{ __('SALE') }} @endif
                                    </span>
                                @endif

                                @auth
                                <button onclick="toggleWishlist({{ $product->id }}, this)"
                                        class="wishlist-btn absolute top-4 right-4 w-10 h-10 rounded-full bg-white/95 backdrop-blur-sm shadow-md flex items-center justify-center transition-all
                                               {{ auth()->user()->hasInWishlist($product->id) ? 'text-rose-500' : 'text-gray-400 hover:text-rose-500' }}">
                                    <svg class="w-5 h-5" fill="{{ auth()->user()->hasInWishlist($product->id) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                                @endauth
                            </div>

                            @if(count($productImages) > 1)
                            <div class="grid grid-cols-5 gap-2 mt-3">
                                @foreach($productImages as $index => $image)
                                    @php $imgSrc = filter_var($image, FILTER_VALIDATE_URL) ? $image : asset($image); @endphp
                                    <div onclick="changeMainImage('{{ $imgSrc }}', this)"
                                         class="thumb cursor-pointer rounded-lg overflow-hidden border-2 transition-all aspect-square
                                                {{ $index === 0 ? 'border-pink-500 shadow-md' : 'border-pink-100 hover:border-pink-300' }}">
                                        <img src="{{ $imgSrc }}" alt="{{ $product->name }} #{{ $index + 1 }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.onerror=null;this.src='https://placehold.co/80x80/fdf2f8/f9a8d4?text=?'">
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- ── Right: Product info ─────────────────────────────── --}}
                    <div class="lg:col-span-7 p-6 lg:p-8 flex flex-col gap-5 border-l border-pink-100">

                        {{-- Category + Title --}}
                        <div>
                            <a href="{{ route('category.show', $product->category->slug) }}"
                               class="inline-block text-[11px] font-bold uppercase tracking-wider text-pink-600 hover:text-pink-700 mb-2">
                                {{ $product->category->name }}
                            </a>
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-gray-900 leading-tight">
                                {{ $product->name }}
                            </h1>

                            {{-- Rating + Sold --}}
                            <div class="flex items-center gap-3 mt-3 text-xs">
                                @if($product->reviews_count > 0)
                                <div class="flex items-center gap-1">
                                    <div class="flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3.5 h-3.5 {{ $i <= round($product->average_rating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="font-bold text-gray-800">{{ number_format($product->average_rating, 1) }}</span>
                                    <span class="text-gray-400">({{ $product->reviews_count }} {{ __('reviews') }})</span>
                                </div>
                                <span class="text-gray-300">|</span>
                                @endif
                                <span class="text-gray-500">
                                    {{ __('SKU') }}: <span class="font-medium text-gray-700">{{ $product->sku }}</span>
                                </span>
                            </div>
                        </div>

                        {{-- Price block --}}
                        <div class="bg-gradient-to-r from-pink-50 to-rose-50 rounded-2xl p-5 border border-pink-100">
                            <div class="flex items-baseline flex-wrap gap-3">
                                <span class="text-3xl sm:text-4xl font-extrabold text-rose-600">
                                    ${{ number_format($currentPrice, 2) }}
                                </span>
                                @if($originalPrice)
                                    <span class="text-lg text-gray-400 line-through">
                                        ${{ number_format($originalPrice, 2) }}
                                    </span>
                                    @if($savePct)
                                        <span class="bg-rose-500 text-white px-2.5 py-1 rounded-full text-xs font-extrabold">
                                            {{ __('SAVE') }} {{ $savePct }}%
                                        </span>
                                    @endif
                                @endif
                            </div>
                            @if($product->short_description)
                                <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $product->short_description }}</p>
                            @endif
                        </div>

                        {{-- Stock indicator --}}
                        <div class="flex items-center gap-2">
                            @if($product->stock_quantity > 0)
                                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-100">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    <span class="text-emerald-700 font-bold text-xs">{{ __('In Stock') }}</span>
                                </div>
                                <span class="text-xs text-gray-500">{{ $product->stock_quantity }} {{ __('units available') }}</span>
                            @else
                                <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-rose-50 border border-rose-100">
                                    <span class="w-2 h-2 bg-rose-500 rounded-full"></span>
                                    <span class="text-rose-700 font-bold text-xs">{{ __('Out of Stock') }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Seller card --}}
                        @if($product->seller)
                        <div class="bg-white border border-pink-100 rounded-2xl p-4 flex items-center gap-3">
                            @php
                                $sellerInitial = strtoupper(substr($product->seller->store_name ?? 'S', 0, 1));
                                $sellerLogo = !empty($product->seller->store_logo) && !filter_var($product->seller->store_logo, FILTER_VALIDATE_URL)
                                    ? asset('storage/' . ltrim($product->seller->store_logo, '/'))
                                    : ($product->seller->store_logo ?? null);
                            @endphp
                            <div class="relative w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 border border-pink-100">
                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-pink-400 to-rose-500 text-white font-bold">{{ $sellerInitial }}</div>
                                @if($sellerLogo)
                                <img src="{{ $sellerLogo }}" alt="" class="relative w-full h-full object-cover" onerror="this.style.display='none'">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] uppercase tracking-wider text-gray-400 font-bold">{{ __('Sold by') }}</p>
                                <h4 class="text-sm font-extrabold text-gray-900 truncate">{{ $product->seller->store_name }}</h4>
                            </div>
                            <a href="{{ route('stores.show', $product->seller->slug) }}"
                               class="text-xs font-bold px-3 py-2 bg-pink-50 text-pink-600 rounded-lg hover:bg-pink-500 hover:text-white transition-colors flex-shrink-0">
                                {{ __('Visit Store') }} →
                            </a>
                        </div>
                        @endif

                        {{-- Qty + Buttons --}}
                        @if($product->stock_quantity > 0)
                        <div class="space-y-3 mt-auto">
                            <div class="flex items-center gap-4">
                                <label class="text-sm font-bold text-gray-700">{{ __('Quantity') }}:</label>
                                <div class="flex items-center border border-pink-200 rounded-full overflow-hidden bg-white">
                                    <button type="button" onclick="adjustQty(-1)"
                                            class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-pink-50 hover:text-pink-600 transition-colors">−</button>
                                    <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                           class="w-12 text-center text-sm font-bold text-gray-800 bg-transparent border-0 focus:outline-none focus:ring-0 [-moz-appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                    <button type="button" onclick="adjustQty(1)"
                                            class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-pink-50 hover:text-pink-600 transition-colors">+</button>
                                </div>
                            </div>

                            @php
                                $isOwnProduct = auth()->check() && auth()->user()->isSeller()
                                    && auth()->user()->seller->id === $product->seller_id;
                            @endphp
                            <div class="flex items-center gap-3">
                                @if($isOwnProduct)
                                    {{-- Seller viewing their own product — show notice, no buy buttons --}}
                                    <div class="flex-1 flex items-center justify-center gap-2 bg-amber-50 border border-amber-200 text-amber-700 py-3 rounded-full text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                                        </svg>
                                        {{ __('This is your product') }}
                                    </div>
                                    <a href="{{ route('seller.dashboard') }}"
                                       class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 text-white py-3 rounded-full font-bold text-sm shadow-md transition-all">
                                        {{ __('Manage in Dashboard') }}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @else
                                @auth
                                <button onclick="addToCart({{ $product->id }}, this, document.getElementById('quantity').value)"
                                        class="flex-1 flex items-center justify-center gap-2 bg-white border-2 border-orange-500 text-orange-600 hover:bg-orange-50 py-3 rounded-full font-bold text-sm transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                                    </svg>
                                    {{ __('Add to Cart') }}
                                </button>
                                <button onclick="addToCart({{ $product->id }}, this, document.getElementById('quantity').value); setTimeout(() => window.location.href='{{ route('cart.index') }}', 600);"
                                        class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-orange-500 to-rose-500 hover:from-orange-600 hover:to-rose-600 text-white py-3 rounded-full font-bold text-sm shadow-md transition-all">
                                    {{ __('Buy Now') }}
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                                @else
                                <a href="{{ route('login') }}"
                                   class="flex-1 flex items-center justify-center gap-2 bg-gradient-to-r from-orange-500 to-rose-500 text-white py-3 rounded-full font-bold text-sm shadow-md">
                                    {{ __('Sign in to Purchase') }}
                                </a>
                                @endauth
                                @endif
                            </div>
                        </div>
                        @else
                            <button disabled class="w-full bg-gray-100 text-gray-400 py-3 rounded-full font-bold text-sm cursor-not-allowed">
                                {{ __('Out of Stock') }}
                            </button>
                        @endif

                        {{-- Trust badges --}}
                        <div class="grid grid-cols-3 gap-3 pt-4 border-t border-pink-100">
                            @foreach([
                                ['icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z', 'title' => __('100% Authentic'), 'sub' => __('Verified seller')],
                                ['icon' => 'M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'title' => __('Free Shipping'), 'sub' => __('On orders $50+')],
                                ['icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'title' => __('Secure Payment'), 'sub' => __('Buyer protection')],
                            ] as $trust)
                            <div class="flex items-start gap-2">
                                <div class="w-9 h-9 rounded-lg bg-pink-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $trust['icon'] }}"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[11px] font-bold text-gray-800 leading-tight">{{ $trust['title'] }}</p>
                                    <p class="text-[10px] text-gray-500 leading-tight mt-0.5">{{ $trust['sub'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ═══ DESCRIPTION + SPECS ════════════════════════════════════ --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-5" x-data="{ tab: 'desc' }">
                <div class="lg:col-span-2 bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
                    <div class="flex border-b border-pink-100">
                        <button @click="tab = 'desc'" :class="tab === 'desc' ? 'text-pink-600 border-pink-500' : 'text-gray-500 border-transparent hover:text-pink-600'"
                                class="px-5 py-3 text-sm font-bold border-b-2 transition-colors">
                            {{ __('Description') }}
                        </button>
                        @if(!empty($product->specifications) && is_array($product->specifications))
                        <button @click="tab = 'specs'" :class="tab === 'specs' ? 'text-pink-600 border-pink-500' : 'text-gray-500 border-transparent hover:text-pink-600'"
                                class="px-5 py-3 text-sm font-bold border-b-2 transition-colors">
                            {{ __('Specifications') }}
                        </button>
                        @endif
                    </div>
                    <div x-show="tab === 'desc'" class="p-6">
                        <div class="text-gray-600 text-sm leading-relaxed prose max-w-none">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                    @if(!empty($product->specifications) && is_array($product->specifications))
                    <div x-show="tab === 'specs'" x-cloak class="p-6">
                        <dl class="divide-y divide-pink-50">
                            @foreach($product->specifications as $key => $value)
                            <div class="flex py-3 gap-6">
                                <dt class="w-1/3 text-sm font-bold text-gray-700 flex-shrink-0">{{ $key }}</dt>
                                <dd class="text-sm text-gray-600">{{ $value }}</dd>
                            </div>
                            @endforeach
                        </dl>
                    </div>
                    @endif
                </div>

                {{-- Side widgets — quick facts --}}
                <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
                    <h3 class="text-sm font-extrabold text-gray-800 mb-3 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-pink-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                        {{ __('Quick Info') }}
                    </h3>
                    <dl class="space-y-2.5 text-xs">
                        <div class="flex justify-between gap-2">
                            <dt class="text-gray-500">{{ __('Category') }}</dt>
                            <dd class="font-bold text-gray-800 text-right">{{ $product->category->name }}</dd>
                        </div>
                        <div class="flex justify-between gap-2">
                            <dt class="text-gray-500">{{ __('SKU') }}</dt>
                            <dd class="font-bold text-gray-800 text-right">{{ $product->sku }}</dd>
                        </div>
                        @if($product->seller)
                        <div class="flex justify-between gap-2">
                            <dt class="text-gray-500">{{ __('Brand') }}</dt>
                            <dd class="font-bold text-gray-800 text-right">{{ $product->seller->store_name }}</dd>
                        </div>
                        @endif
                        <div class="flex justify-between gap-2">
                            <dt class="text-gray-500">{{ __('Stock') }}</dt>
                            <dd class="font-bold {{ $product->stock_quantity > 0 ? 'text-emerald-600' : 'text-rose-500' }} text-right">
                                {{ $product->stock_quantity > 0 ? $product->stock_quantity . ' ' . __('available') : __('Out of stock') }}
                            </dd>
                        </div>
                        @if($product->reviews_count > 0)
                        <div class="flex justify-between gap-2">
                            <dt class="text-gray-500">{{ __('Rating') }}</dt>
                            <dd class="font-bold text-amber-500 text-right">{{ number_format($product->average_rating, 1) }} ★</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            {{-- ═══ REVIEWS & RELATED ══════════════════════════════════════ --}}
            <div class="mt-5">
                @include('products._reviews', [
                    'product'         => $product,
                    'userReview'      => $userReview ?? null,
                    'relatedProducts' => $relatedProducts ?? null,
                ])
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function changeMainImage(imageUrl, thumbDiv) {
            document.getElementById('mainImage').src = imageUrl;
            document.querySelectorAll('.thumb').forEach(t => {
                t.className = 'thumb cursor-pointer rounded-lg overflow-hidden border-2 border-pink-100 hover:border-pink-300 transition-all aspect-square';
            });
            if (thumbDiv) thumbDiv.className = 'thumb cursor-pointer rounded-lg overflow-hidden border-2 border-pink-500 shadow-md transition-all aspect-square';
        }
        function adjustQty(delta) {
            const input = document.getElementById('quantity');
            const max = parseInt(input.max);
            const next = Math.max(1, Math.min(max, parseInt(input.value || 1) + delta));
            input.value = next;
        }
    </script>
    @endpush
</x-app-layout>
