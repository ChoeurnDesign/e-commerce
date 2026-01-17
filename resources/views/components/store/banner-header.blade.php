@props([
    'seller',
    'logoClass' => 'w-44 h-44',
    'bannerClass' => 'h-64',
    'bannerFontClass' => 'text-4xl',
    'logoOffset' => '-bottom-24',
])

@php
    $rawBanner = $seller->store_banner ?? $seller->banner_image ?? null;

    if ($rawBanner) {
        $path = ltrim($rawBanner, '/');
        $path = preg_replace('#^(public/|storage/)#', '', $path);
        $bannerUrl = asset('storage/' . $path);
    } else {
        $bannerUrl = null;
    }
@endphp

<div class="relative">
    <!-- Card container background (top area) -->
    <div class="overflow-hidden shadow-2xl bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900">
        <!-- Banner with large rounded inner corners to match new design -->
        <div class="{{ $bannerClass }} w-full bg-slate-800/20 flex items-center justify-center px-6 py-4">
            @if($bannerUrl)
                <img src="{{ $bannerUrl }}"
                     alt="{{ $seller->store_name ?? $seller->name }} Banner"
                     class="w-full h-full object-cover "
                     onerror="this.onerror=null;this.src='{{ asset('images/default-banner.png') }}';" />
            @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-sky-700 via-emerald-600 to-yellow-500">
                    <span class="text-white dark:text-gray-200 tracking-wide {{ $bannerFontClass }} font-medium opacity-90">
                        Store Banner
                    </span>
                </div>
            @endif
        </div>

        <!-- a short spacer so the logo can overlap visually similar to the image -->
        {{-- <div class="h-6 bg-transparent"></div> --}}
    </div>

    <!-- Store Logo: overlaps banner, aligned left like the provided design -->
    <div class="absolute left-16 transform  {{ $logoOffset }} z-20">
        <img src="{{ $seller->store_logo_url ?? 'https://ui-avatars.com/api/?name='.urlencode($seller->store_name ?? $seller->name) }}"
             alt="{{ $seller->store_name ?? $seller->name }}"
             class="{{ $logoClass }} rounded-full shadow-xl bg-white dark:bg-slate-800 object-cover"
             onerror="this.onerror=null;this.src='{{ asset('images/default-store.png') }}';" />
    </div>
</div>