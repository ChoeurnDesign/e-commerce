@php
    $getActiveClass = function($routeName) {
        // Keeps the vibrant active indigo state, but changes background/text cleanly depending on theme
        return request()->routeIs($routeName) 
            ? 'bg-indigo-600 text-white' 
            : 'text-gray-700 hover:bg-gray-200 hover:text-indigo-600';
    };
    
    $getIconClass = function($routeName) {
        return request()->routeIs($routeName) 
            ? 'text-white' 
            : 'text-gray-500 group-hover:text-indigo-600';
    };
@endphp

<nav class="space-y-2 flex-1 overflow-y-auto px-2">
    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}"
       class="{{ $getActiveClass('admin.dashboard') }} group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
         <x-icon-dashboard name="dashboard" class="mr-3 h-5 w-5 {{ $getIconClass('admin.dashboard') }}" />
         Dashboard
    </a>

    {{-- Products --}}
    <a href="{{ route('admin.products.index') }}"
       class="{{ $getActiveClass('admin.products.*') }} group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
         <x-icon-nav name="products" class="mr-3 h-5 w-5 {{ $getIconClass('admin.products.*') }}" />
         Products
    </a>

    {{-- Categories --}}
    <a href="{{ route('admin.categories.index') }}"
       class="{{ $getActiveClass('admin.categories.*') }} group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
         <x-icon-nav name="categories" class="mr-3 h-5 w-5 {{ $getIconClass('admin.categories.*') }}" />
         Categories
    </a>

    {{-- Orders --}}
    <a href="{{ route('admin.orders.index') }}"
       class="{{ $getActiveClass('admin.orders.*') }} group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
         <x-icon-nav name="orders" class="mr-3 h-5 w-5 {{ $getIconClass('admin.orders.*') }}" />
         Orders
    </a>

    {{-- Pending Payment Verifications (bank transfers waiting for admin review) --}}
    @php
        $pendingPaymentsCount = \App\Models\Order::where('payment_method', 'bank_transfer')
            ->whereIn('payment_status', ['awaiting_verification', 'pending'])
            ->whereNotNull('payment_proof')
            ->count();
        $pendingPayoutsCount = \App\Models\PayoutRequest::where('status', 'pending')->count();
    @endphp
    <a href="{{ route('admin.payments.pending') }}"
       class="{{ $getActiveClass('admin.payments.*') }} group flex items-center justify-between px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
         <span class="flex items-center">
            <svg class="mr-3 h-5 w-5 {{ $getIconClass('admin.payments.*') }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            Payments
         </span>
         @if($pendingPaymentsCount > 0)
            <span class="bg-rose-500 text-white text-[10px] font-bold rounded-full px-2 py-0.5 leading-none">
                {{ $pendingPaymentsCount > 99 ? '99+' : $pendingPaymentsCount }}
            </span>
         @endif
    </a>

    {{-- Seller Payouts --}}
    <a href="{{ route('admin.payouts.index') }}"
       class="{{ $getActiveClass('admin.payouts.*') }} group flex items-center justify-between px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
         <span class="flex items-center">
            <svg class="mr-3 h-5 w-5 {{ $getIconClass('admin.payouts.*') }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375M3.75 18.75v-.625c0-.621.504-1.125 1.125-1.125h.375m1.5 1.5v-.75a.75.75 0 01.75-.75h.75M12 6.75v10.5"/>
            </svg>
            Payouts
         </span>
         @if($pendingPayoutsCount > 0)
            <span class="bg-amber-500 text-white text-[10px] font-bold rounded-full px-2 py-0.5 leading-none">
                {{ $pendingPayoutsCount > 99 ? '99+' : $pendingPayoutsCount }}
            </span>
         @endif
    </a>

    {{-- Customers --}}
    <a href="{{ route('admin.customers.index') }}"
       class="{{ $getActiveClass('admin.customers.*') }} group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
         <x-icon-nav name="customers" class="mr-3 h-5 w-5 {{ $getIconClass('admin.customers.*') }}" />
         Customers
    </a>

    {{-- Sellers --}}
    <a href="{{ route('admin.sellers.index') }}"
       class="{{ $getActiveClass('admin.sellers.*') }} group flex items-center justify-between px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
        <div class="flex items-center">
            <x-icon-nav name="sellers" class="mr-3 h-5 w-5 {{ $getIconClass('admin.sellers.*') }}" />
            <span>Sellers</span>
        </div>
        @if(isset($pendingSellersCount) && $pendingSellersCount > 0)
            <span class="ml-auto inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                {{ $pendingSellersCount }}
            </span>
        @endif
    </a>

    {{-- Reports --}}
    <a href="{{ route('admin.reports-dash.index') }}"
       class="{{ $getActiveClass('admin.reports-dash.*') }} group flex items-center justify-between px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
        <div class="flex items-center">
            <x-icon-nav name="reports" class="mr-3 h-5 w-5 {{ $getIconClass('admin.reports-dash.*') }}" />
            <span>Reports</span>
        </div>
        @if(isset($unreadReportsCount) && $unreadReportsCount > 0)
            <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
                {{ $unreadReportsCount }}
            </span>
        @endif
    </a>

    <a href="{{ route('admin.reviews.index') }}"
       class="{{ $getActiveClass('admin.reviews.*') }} group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
        <x-icon-nav name="reviews" class="mr-3 h-5 w-5 {{ $getIconClass('admin.reviews.*') }}" />
        Reviews
    </a>

    {{-- On Sale --}}
    <a href="{{ route('admin.onsale.index') }}"
       class="{{ $getActiveClass('admin.onsale.*') }} group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
        <x-icon-nav name="onsale" class="mr-3 h-5 w-5 {{ $getIconClass('admin.onsale.*') }}" />
        On Sale
    </a>

    {{-- Settings --}}
    <a href="{{ route('admin.settings.index') }}"
       class="{{ $getActiveClass('admin.settings.*') }} group flex items-center px-4 py-2 text-sm font-medium rounded-md transition-colors"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
        <x-icon-nav name="settings" class="mr-3 h-5 w-5 {{ $getIconClass('admin.settings.*') }}" />
        Settings
    </a>

    {{-- Visit Store --}}
    <a href="{{ route('home') }}"
       class="text-gray-500 hover:text-indigo-600 flex items-center px-4 py-2 text-sm font-medium rounded-md mt-8 transition-colors border border-dashed border-gray-300"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
        <x-icon-dashboard name="back" class="mr-3 h-5 w-5" />
        Visit Store
    </a>
</nav>