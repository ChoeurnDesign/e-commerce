@props(['product','context' => 'seller'])

    <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
        <div class="flex items-center justify-between">
            <span class="mr-2">
                <x-icon-dashboard name="products" class="w-7 h-7 text-indigo-600 dark:text-yellow-400" />
            </span>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{$title}}</h1>
        </div>
    </div>

@php
    use Illuminate\Support\Str;

    // Context flags
    $internal = in_array($context, ['admin','seller']);
    $isAdmin  = $context === 'admin';

    // Normalize main image: keep http(s), keep storage/*, otherwise prefix storage/
    $mainImage = method_exists($product,'getImageUrlAttribute') && !empty($product->image_url)
        ? $product->image_url
        : ($product->image && file_exists(public_path($product->image))
            ? asset($product->image)
            : 'https://via.placeholder.com/800x800?text=' . urlencode($product->name ?? 'Product'));

    $onSale = $product->on_sale && $product->sale_price && $product->sale_price < $product->price;

    $discountPercent = $product->discount_percent
        ?? ($onSale ? (int)round(100 - ($product->sale_price / max(0.01,$product->price) * 100)) : null);

    $showCompare = $product->compare_price && $product->compare_price > ($onSale ? $product->sale_price : $product->price);

    $specs   = is_array($product->specifications ?? null) ? $product->specifications : (json_decode($product->specifications ?? '[]', true) ?: []);
    $gallery = is_array($product->gallery ?? null)        ? $product->gallery        : (json_decode($product->gallery ?? '[]', true) ?: []);

    // Build thumbnails (ensure storage/ for local) and turn into absolute URLs
    $thumbs = collect([$mainImage])
        ->merge($gallery)
        ->filter()
        ->unique()
        ->take(6)
        ->map(function($p) {
            $patched = Str::startsWith($p, ['http://','https://','storage/']) ? $p : ('storage/' . ltrim($p, '/'));
            return Str::startsWith($patched, ['http://','https://']) ? $patched : asset($patched);
        });

    $routePrefix = $isAdmin ? 'admin' : ($context === 'seller' ? 'seller' : null);
@endphp

<div class="bg-white dark:bg-[#23263a] rounded-lg shadow border border-gray-100 dark:border-[#23263a] p-6 flex flex-col lg:flex-row gap-8">
    {{-- LEFT: Image + Badges + Thumbnails --}}
    <div class="w-full lg:w-1/3">
        <div id="prodImgWrap"
             class="relative aspect-square w-full rounded-xl overflow-hidden bg-gray-100 dark:bg-[#1f2333] flex items-center justify-center">
            @include('products.partials.image-seller', [
                'product' => $product,
                'image' => $mainImage ?? null,
                'class' => 'absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-300',
                'id' => 'prodMainImg'
            ])
            @if($onSale || $product->is_featured || !$product->is_active)
                <div class="absolute top-2 left-2 flex flex-wrap gap-1 text-[10px] font-semibold z-10">
                    @if($onSale)
                        <span class="px-2 py-0.5 rounded bg-red-600 text-white">SALE</span>
                        @if($discountPercent)
                            <span class="px-2 py-0.5 rounded bg-green-600 text-white">-{{ $discountPercent }}%</span>
                        @endif
                    @endif
                    @if($product->is_featured)
                        <span class="px-2 py-0.5 rounded bg-yellow-500 text-white">FEATURED</span>
                    @endif
                    @unless($product->is_active)
                        <span class="px-2 py-0.5 rounded bg-red-700 text-white">INACTIVE</span>
                    @endunless
                </div>
            @endif

            @if($internal)
                <button id="prodFitToggle"
                        class="hidden absolute bottom-2 right-2 text-[10px] px-2 py-1 rounded bg-black/60 text-white">
                    Fill
                </button>
            @endif
        </div>

        @if($thumbs->isNotEmpty())
            <div class="mt-4 grid grid-cols-6 gap-2">
                @foreach($thumbs as $t)
                    <button type="button"
                            class="group aspect-square rounded border border-gray-200 dark:border-[#2f3650] overflow-hidden bg-gray-50 dark:bg-[#262d42] focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            data-full="{{ $t }}">
                        <img src="{{ $t }}" alt="Thumb"
                             class="w-full h-full object-cover transition-transform group-hover:scale-105">
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- RIGHT: Details --}}
    <div class="flex-1 space-y-6 min-w-0">

        {{-- Header / Basic Info --}}
        <div>
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $product->name }}</h1>
            <div class="mt-2 flex flex-wrap gap-6 text-xs text-gray-600 dark:text-gray-400">
                <span>SKU:
                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $product->sku }}</span>
                </span>
                <span>Category:
                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $product->category->name ?? 'No Category' }}</span>
                </span>
                <span>Status:
                    <span class="font-medium {{ $product->is_active ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </span>
                @if($isAdmin && $product->relationLoaded('creator') && $product->creator)
                    <span>Owner:
                        <span class="font-medium text-gray-800 dark:text-gray-200">{{ $product->creator->name }}</span>
                    </span>
                @endif
            </div>
        </div>

        {{-- Short Description --}}
        @if($product->short_description)
            <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                {{ $product->short_description }}
            </p>
        @endif

        {{-- Pricing --}}
        <div class="space-y-1">
            <div class="flex items-baseline flex-wrap gap-4">
                @if($onSale)
                    <span class="text-3xl font-bold text-green-600 dark:text-green-400">
                        ${{ number_format($product->sale_price,2) }}
                    </span>
                    <span class="text-lg line-through text-gray-500 dark:text-gray-400">
                        ${{ number_format($product->price,2) }}
                    </span>
                @else
                    <span class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        ${{ number_format($product->price,2) }}
                    </span>
                @endif
                @if($showCompare)
                    <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400">
                        Compare: ${{ number_format($product->compare_price,2) }}
                    </span>
                @endif
            </div>
            <div class="text-xs text-gray-600 dark:text-gray-400">
                Stock: <span class="font-medium text-gray-800 dark:text-gray-200">{{ (int)$product->stock_quantity }}</span>
            </div>
        </div>

        {{-- Flags --}}
        <div class="flex flex-wrap gap-2 text-[10px]">
            <span class="px-2 py-1 rounded bg-gray-100 dark:bg-[#2f3650] text-gray-700 dark:text-gray-200">
                {{ $product->is_featured ? 'Featured' : 'Standard' }}
            </span>
            <span class="px-2 py-1 rounded bg-gray-100 dark:bg-[#2f3650] text-gray-700 dark:text-gray-200">
                {{ $onSale ? 'On Sale' : 'Regular Price' }}
            </span>
        </div>

        {{-- Description --}}
        @if($product->description)
            <div>
                <h2 class="text-xs font-semibold uppercase tracking-wide mb-1 text-gray-800 dark:text-gray-200">Description</h2>
                <div class="text-sm text-gray-800 dark:text-gray-200 leading-relaxed">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
        @endif

        {{-- SEO Meta (internal only) --}}
        @if($internal && ($product->meta_title || $product->meta_description))
            <div>
                <h2 class="text-xs font-semibold uppercase tracking-wide mb-1 text-gray-800 dark:text-gray-200">SEO Meta</h2>
                @if($product->meta_title)
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                        <strong>Title:</strong> {{ $product->meta_title }}
                    </p>
                @endif
                @if($product->meta_description)
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                        <strong>Description:</strong> {{ $product->meta_description }}
                    </p>
                @endif
            </div>
        @endif

        {{-- Admin-only stats --}}
        @if($isAdmin && isset($product->page_views))
            <div>
                <h2 class="text-xs font-semibold uppercase tracking-wide mb-1 text-gray-800 dark:text-gray-200">Stats</h2>
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    <strong>Views:</strong> {{ (int)$product->page_views }}
                </p>
            </div>
        @endif

        {{-- Specifications --}}
        @if(!empty($specs))
            <div>
                <h2 class="text-xs font-semibold uppercase tracking-wide mb-2 text-gray-800 dark:text-gray-200">Specifications</h2>
                <ul class="grid sm:grid-cols-2 lg:grid-cols-3 gap-2 text-[11px]">
                    @foreach($specs as $k=>$v)
                        <li class="bg-gray-50 dark:bg-[#2a3146] border border-gray-100 dark:border-[#2f3650] rounded px-2 py-1">
                            <span class="font-semibold">{{ $k }}:</span>
                            <span>{{ is_scalar($v) ? $v : json_encode($v) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Gallery --}}
        @if(!empty($gallery))
            <div>
                <h2 class="text-xs font-semibold uppercase tracking-wide mb-2 text-gray-800 dark:text-gray-200">Gallery</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach($gallery as $g)
                        @include('products.partials.image-seller', [
                            'product' => $product,
                            'image' => $g,
                            'class' => 'h-24 w-24 object-cover rounded border border-gray-200 dark:border-[#2f3650]',
                            'isGallery' => true,
                        ])
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Actions (internal only) --}}
        @if($internal && $routePrefix)
            <div class="flex flex-wrap gap-3 pt-2">
                @can('update',$product)
                    <a href="{{ route($routePrefix.'.products.edit',$product) }}"
                       class="px-4 py-2 text-sm font-medium rounded bg-indigo-600 hover:bg-indigo-700 text-white shadow">
                        Edit
                    </a>
                @endcan
                @can('delete',$product)
                    <form method="POST" action="{{ route($routePrefix.'.products.destroy',$product) }}" onsubmit="return confirm('Delete this product?')">
                        @csrf <input type="hidden" name="_method" value="">
                        <button type="submit" class="px-4 py-2 text-sm font-medium rounded bg-red-600 hover:bg-red-700 text-white shadow">
                            Delete
                        </button>
                    </form>
                @endcan
            </div>
        @endif

    </div>
</div>

@if($internal)
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const img    = document.getElementById('prodMainImg');
        const wrap   = document.getElementById('prodImgWrap');
        const toggle = document.getElementById('prodFitToggle');

        if (!img) return; // guard

        function orient() {
            if (!img.naturalWidth || !img.naturalHeight) return;
            const r = img.naturalWidth / img.naturalHeight;
            if (r > 1.25) {
                wrap.style.aspectRatio = '16 / 10';
                img.classList.remove('object-contain');
                img.classList.add('object-cover');
            } else if (r < 0.8) {
                wrap.style.aspectRatio = '3 / 4';
                img.classList.remove('object-cover');
                img.classList.add('object-contain');
            } else {
                wrap.style.aspectRatio = '1 / 1';
                img.classList.remove('object-cover');
                img.classList.add('object-contain');
            }
            img.classList.add('opacity-100');
            if (toggle) toggle.classList.remove('hidden');
        }

        if (img.complete) orient(); else img.addEventListener('load', orient);

        if (toggle) {
            toggle.addEventListener('click', () => {
                const contain = img.classList.contains('object-contain');
                img.classList.toggle('object-contain', !contain);
                img.classList.toggle('object-cover', contain);
                toggle.textContent = contain ? 'Fit' : 'Fill';
            });
        }

        document.querySelectorAll('[data-full]').forEach(btn => {
            btn.addEventListener('click', () => {
                img.classList.remove('opacity-100');
                img.src = btn.dataset.full;
                if (img.complete) orient(); else img.onload = orient;
            });
        });
    });
    </script>
@endif
