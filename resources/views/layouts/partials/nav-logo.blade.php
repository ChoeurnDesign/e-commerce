@php
    $storeLogo = $settings['store_logo'] ?? null;
    $logoUrl   = null;
    if ($storeLogo) {
        if (file_exists(public_path($storeLogo))) {
            $logoUrl = asset($storeLogo);
        } elseif (file_exists(public_path('storage/' . $storeLogo))) {
            $logoUrl = asset('storage/' . $storeLogo);
        }
    }
@endphp

<a href="{{ route('home') }}" class="flex items-center gap-2.5 flex-shrink-0 min-w-0">

    @if($logoUrl)
        {{-- Store logo image uploaded in settings --}}
        <img src="{{ $logoUrl }}"
             alt="{{ $settings['store_name'] ?? 'ShopExpress' }}"
             class="h-20 w-auto max-w-[150px] object-contain flex-shrink-0">
    @else
        {{-- 4-quadrant SVG fallback logo --}}
        <div class="w-9 h-9 flex-shrink-0">
            <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="1"  y="1"  width="13" height="13" rx="3"   fill="#F97316"/>
                <rect x="18" y="1"  width="13" height="13" rx="3"   fill="#F97316" opacity="0.55"/>
                <rect x="1"  y="18" width="13" height="13" rx="3"   fill="#F97316" opacity="0.55"/>
                <rect x="18" y="18" width="13" height="13" rx="3"   fill="#F97316"/>
            </svg>
        </div>
        <span class="text-lg font-extrabold text-gray-900 truncate">
            {{ $settings['store_name'] ?? 'ShopExpress' }}
        </span>
    @endif

</a>

