@php
    $getActiveClass = function($routeName) {
        // Keeps the vibrant active indigo state, but changes background/text cleanly depending on theme
        return request()->routeIs($routeName) 
            ? 'bg-indigo-600 text-white shadow-sm' 
            : 'text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-[#23263a] hover:text-indigo-600 dark:hover:text-white';
    };
    
    $getIconClass = function($routeName) {
        return request()->routeIs($routeName) 
            ? 'text-white' 
            : 'text-gray-500 dark:text-gray-300 group-hover:text-indigo-600 dark:group-hover:text-white';
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
       class="text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 flex items-center px-4 py-2 text-sm font-medium rounded-md mt-8 transition-colors border border-dashed border-gray-300 dark:border-gray-700"
       @click="if (window.innerWidth < 1024) sidebarOpen = false">
        <x-icon-dashboard name="back" class="mr-3 h-5 w-5" />
        Visit Store
    </a>
</nav>