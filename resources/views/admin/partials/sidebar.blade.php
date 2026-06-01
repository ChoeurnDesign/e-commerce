@php
    $pendingPaymentsCount = \App\Models\Order::where('payment_method', 'bank_transfer')
        ->whereIn('payment_status', ['awaiting_verification', 'pending'])
        ->whereNotNull('payment_proof')
        ->count();
    $pendingPayoutsCount = \App\Models\PayoutRequest::where('status', 'pending')->count();
    $pendingSellersCount = \App\Models\Seller::where('status', 'pending')->count();

    $is = fn(...$names) => request()->routeIs($names);
@endphp

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-[260px] bg-gradient-to-b from-slate-800 via-slate-800 to-slate-900 flex-shrink-0 flex flex-col shadow-2xl transition-all duration-300 ease-in-out lg:translate-x-0 lg:sticky lg:top-0 lg:z-30"
       @click.away="if (window.innerWidth < 1024) sidebarOpen = false">

    {{-- Brand header --}}
    <div class="flex items-center justify-between h-16 px-5 border-b border-white/10 shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-indigo-500/30">
                A
            </div>
            <div>
                <span class="text-sm font-bold text-white block">Admin Panel</span>
                <span class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">{{ setting('store_name', 'ShopExpress') }}</span>
            </div>
        </a>
        <button @click="sidebarOpen = false"
                class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">

        @php
            $navItems = [
                ['route' => 'admin.dashboard',        'match' => 'admin.dashboard',        'label' => 'Dashboard',   'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'badge' => 0],
                ['route' => 'admin.products.index',   'match' => 'admin.products.*',       'label' => 'Products',    'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'badge' => 0],
                ['route' => 'admin.categories.index',  'match' => 'admin.categories.*',    'label' => 'Categories',  'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'badge' => 0],
                ['route' => 'admin.orders.index',      'match' => 'admin.orders.*',        'label' => 'Orders',      'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'badge' => 0],
                ['route' => 'admin.payments.pending',  'match' => 'admin.payments.*',      'label' => 'Payments',    'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'badge' => $pendingPaymentsCount, 'badgeColor' => 'bg-rose-500'],
                ['route' => 'admin.payouts.index',     'match' => 'admin.payouts.*',       'label' => 'Payouts',     'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z', 'badge' => $pendingPayoutsCount, 'badgeColor' => 'bg-amber-500'],
                ['route' => 'admin.customers.index',   'match' => 'admin.customers.*',     'label' => 'Customers',   'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'badge' => 0],
                ['route' => 'admin.sellers.index',     'match' => 'admin.sellers.*',       'label' => 'Sellers',     'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'badge' => $pendingSellersCount, 'badgeColor' => 'bg-red-500'],
                ['route' => 'admin.reports-dash.index', 'match' => 'admin.reports-dash.*', 'label' => 'Reports',     'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'badge' => 0],
                ['route' => 'admin.sales-report.index', 'match' => 'admin.sales-report.*', 'label' => 'Sales Report', 'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z', 'badge' => 0],
                ['route' => 'admin.reviews.index',     'match' => 'admin.reviews.*',       'label' => 'Reviews',     'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'badge' => 0],
                ['route' => 'admin.onsale.index',      'match' => 'admin.onsale.*',        'label' => 'On Sale',     'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'badge' => 0],
                ['route' => 'admin.settings.index',    'match' => 'admin.settings.*',      'label' => 'Settings',    'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'badge' => 0],
            ];
        @endphp

        @foreach($navItems as $item)
            @php $active = $is($item['match']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                      {{ $active
                          ? 'bg-indigo-500/20 text-indigo-300 shadow-sm shadow-indigo-500/10'
                          : 'text-slate-300 hover:text-white hover:bg-white/10' }}"
               @click="if (window.innerWidth < 1024) sidebarOpen = false">
                <span class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0
                                 {{ $active ? 'bg-indigo-500/25 text-indigo-300' : 'text-slate-400' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $item['icon'] }}"/>
                        </svg>
                    </span>
                    {{ $item['label'] }}
                </span>
                @if($item['badge'] > 0)
                    <span class="{{ $item['badgeColor'] ?? 'bg-red-500' }} text-white text-[10px] font-bold rounded-full px-2 py-0.5 leading-none">
                        {{ $item['badge'] > 99 ? '99+' : $item['badge'] }}
                    </span>
                @elseif($active)
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400"></span>
                @endif
            </a>
        @endforeach

        {{-- Visit Store --}}
        <div class="pt-6 mt-2 border-t border-white/10">
            <a href="{{ route('home') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:text-white hover:bg-white/10 transition-all">
                <span class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-slate-500">
                    <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </span>
                Visit Store
            </a>
        </div>
    </nav>

    {{-- Logout --}}
    <div class="px-3 py-4 border-t border-white/10 shrink-0">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-red-300 hover:bg-red-500/15 hover:text-red-200 transition-all">
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
