@php
    $seller = auth()->user()->seller;
    $storeName = $seller?->store_name;
    $storeInitials = 'S';
    if ($storeName) {
        $words = explode(' ', $storeName);
        $storeInitials = strtoupper(implode('', array_map(fn($w) => mb_substr($w, 0, 1), $words)));
    }
    $sidebarLogo = $seller?->store_logo ? $seller->store_logo_url : null;

    $is = fn(...$names) => request()->routeIs($names);

    // Pending counts for badges
    $pendingReturnsCount = $seller
        ? \App\Models\ReturnRequest::where('seller_id', $seller->id)->where('status', 'pending_seller_review')->count()
        : 0;
@endphp

<aside class="fixed md:relative inset-y-0 left-0 z-50 w-[260px] bg-gradient-to-b from-gray-700 via-gray-700 to-gray-800 flex-shrink-0 flex flex-col shadow-2xl transition-all duration-300 ease-in-out"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

    {{-- ── Brand header ── --}}
    <div class="flex items-center justify-between h-16 px-5 border-b border-white/15">
        <a href="{{ route('seller.dashboard') }}" class="flex items-center gap-3 flex-1 min-w-0">
            @if($sidebarLogo)
                <img src="{{ $sidebarLogo }}"
                     alt="Store Logo"
                     class="w-9 h-9 rounded-lg object-cover ring-2 ring-pink-500/40"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div style="display:none;" class="w-9 h-9 rounded-lg bg-gradient-to-br from-pink-500 to-rose-500 text-white items-center justify-center font-bold text-xs ring-2 ring-pink-500/40">
                    {{ $storeInitials }}
                </div>
            @else
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-pink-500 to-rose-500 text-white flex items-center justify-center font-bold text-xs ring-2 ring-pink-500/40">
                    {{ $storeInitials }}
                </div>
            @endif
            <div class="min-w-0">
                <span class="text-sm font-bold text-white block truncate">{{ $storeName ?? 'Seller Panel' }}</span>
                <span class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">Seller Panel</span>
            </div>
        </a>

        <button @click="sidebarOpen = false"
                class="md:hidden p-1.5 rounded-lg text-gray-500 hover:text-white hover:bg-white/10 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- ── Navigation ── --}}
    <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto scrollbar-thin">

        @php
            $navItems = [
                ['route' => 'seller.dashboard',        'match' => 'seller.dashboard',     'label' => 'Dashboard',      'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['route' => 'seller.products.index',   'match' => 'seller.products.*',    'label' => 'Products',       'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
                ['route' => 'seller.images.index',     'match' => 'seller.images.*',      'label' => 'Image Gallery',  'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['route' => 'seller.orders.index',     'match' => 'seller.orders.*',      'label' => 'Orders',         'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['route' => 'seller.returns.index',    'match' => 'seller.returns.*',     'label' => 'Returns',        'icon' => 'M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6', 'badge' => $pendingReturnsCount],
                ['route' => 'seller.earnings',         'match' => 'seller.earnings',      'label' => 'Earnings',       'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1'],
                ['route' => 'seller.payouts.index',    'match' => 'seller.payouts.*',     'label' => 'Withdrawals',    'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z'],
                ['route' => 'seller.reviews.index',    'match' => 'seller.reviews.*',     'label' => 'Reviews',        'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                ['route' => 'seller.settings.edit',    'match' => 'seller.settings.edit', 'label' => 'Settings',       'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
            ];
        @endphp

        @foreach($navItems as $item)
            @php $active = $is($item['match']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                      {{ $active
                          ? 'bg-pink-500/20 text-pink-300 shadow-sm shadow-pink-500/10'
                          : 'text-gray-300 hover:text-white hover:bg-white/15' }}">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 transition-colors
                             {{ $active ? 'bg-pink-500/25 text-pink-300' : 'text-gray-400' }}">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}"/>
                    </svg>
                </span>
                {{ $item['label'] }}
                @if(!empty($item['badge']) && $item['badge'] > 0)
                    <span class="ml-auto bg-rose-500 text-white text-[10px] font-bold rounded-full px-2 py-0.5 leading-none">
                        {{ $item['badge'] > 99 ? '99+' : $item['badge'] }}
                    </span>
                @elseif($active)
                    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-pink-400"></span>
                @endif
            </a>
        @endforeach

        {{-- Visit store --}}
        <div class="pt-6 mt-2 border-t border-white/10">
            <a href="{{ route('home') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-300 hover:text-white hover:bg-white/15 transition-all">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-gray-400">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </span>
                Visit Store
            </a>
        </div>
    </nav>

    {{-- ── Logout ── --}}
    <div class="px-3 py-4 border-t border-white/10">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                           text-red-300 hover:bg-red-500/15 hover:text-red-200 transition-all">
                <span class="w-8 h-8 rounded-lg bg-red-500/10 flex items-center justify-center shrink-0">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                </span>
                Logout
            </button>
        </form>
    </div>
</aside>
