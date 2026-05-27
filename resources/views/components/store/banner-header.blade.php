@props([
    'seller',
    'logoClass' => 'w-44 h-44',
    'bannerClass' => 'h-64',
    'bannerFontClass' => 'text-4xl',
    'logoOffset' => '-bottom-24',
])

<div class="relative">
    <div class="overflow-hidden shadow-2xl bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900">
        <div class="{{ $bannerClass }} w-full bg-slate-800/20 flex items-center justify-center">
            
            {{-- 
                TRIPLE CHECK: 
                Try 'store_banner_url' (from your first code) 
                and 'banner_url' (from my previous suggestion) 
            --}}
            @php
                $bannerPath = $seller->store_banner_url ?? $seller->banner_url;
            @endphp

            @if($bannerPath)
                {{-- Use the real banner if any path exists --}}
                <img src="{{ asset($bannerPath) }}"
                     alt="{{ $seller->store_name ?? $seller->name }} Banner"
                     class="w-full h-full object-cover"
                     {{-- If the specific file path is broken, ONLY then show the name --}}
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';" />
                
                {{-- Fallback name (Hidden unless image file is missing from storage) --}}
                <div class="hidden w-full h-full items-center justify-center bg-gradient-to-r from-slate-700 to-slate-600">
                     <span class="text-white {{ $bannerFontClass }} font-medium opacity-50 uppercase">
                        {{ $seller->store_name ?? $seller->name }}
                    </span>
                </div>
            @else
                {{-- This ONLY shows if the database fields are both empty --}}
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-sky-700 via-emerald-600 to-yellow-500">
                    <span class="text-white tracking-wide {{ $bannerFontClass }} font-medium opacity-90 uppercase">
                        {{ $seller->store_name ?? $seller->name }}
                    </span>
                </div>
            @endif
        </div>
    </div>

    <div class="absolute left-1/2 -translate-x-1/2 transform {{ $logoOffset }} z-20">
        @php
            $storeName = $seller->store_name ?? $seller->name;
            $logoPath = $seller->store_logo_url ?? $seller->logo_url;
            $initials = urlencode($storeName);
            $uiAvatar = "https://ui-avatars.com/api/?name={$initials}&color=7F9CF5&background=EBF4FF";
        @endphp
        
        {{-- Show real logo if exists, otherwise generate initials --}}
        <img src="{{ $logoPath ? asset($logoPath) : $uiAvatar }}"
             alt="{{ $storeName }}"
             class="{{ $logoClass }} rounded-full border-4 border-white dark:border-gray-800 shadow-xl bg-white dark:bg-slate-800 object-cover"
             onerror="this.onerror=null; this.src='{{ $uiAvatar }}';" />
    </div>
</div>