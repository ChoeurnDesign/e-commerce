@extends('layouts.seller')

@section('title', 'Seller Dashboard')

@section('content')
@php
    $seller = $seller ?? auth()->user()->seller;
@endphp

@if(!$seller)
    <div class="p-6 bg-pink-50 border border-pink-200 rounded-xl">
        <h2 class="text-lg font-semibold text-red-700 mb-2">No Seller Account</h2>
        <p class="text-sm text-red-600">
            You have not created a seller profile yet.
            <a href="{{ route('seller.register.form') }}" class="underline text-pink-600 font-medium">Start here</a>.
        </p>
    </div>
@else
<div class="space-y-6">

    {{-- ══ WELCOME HERO ══ --}}
    <div class="bg-gradient-to-br from-pink-600 via-pink-500 to-rose-400 rounded-2xl shadow-lg p-6 sm:p-8 text-white relative overflow-hidden">
        {{-- Decorative circles --}}
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/10 rounded-full"></div>

        <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <p class="text-pink-200 text-sm font-medium mb-1">{{ now()->format('l, F j, Y') }}</p>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Welcome back, {{ $seller->store_name ?? auth()->user()->name }}!
                </h1>
                <p class="text-pink-100 text-sm mt-1.5 max-w-md">
                    Here's what's happening with your store today. Keep up the great work!
                </p>
            </div>

            @if($seller->status === 'approved')
            <div class="flex gap-2 shrink-0">
                <a href="{{ route('seller.products.create') }}"
                   class="inline-flex items-center gap-2 bg-white text-pink-600 hover:bg-pink-50 font-bold px-5 py-2.5 rounded-xl shadow-sm transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Product
                </a>
                <a href="{{ route('seller.orders.index') }}"
                   class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    View Orders
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- ══ METRIC CARDS ══ --}}
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Earnings --}}
        <a href="{{ route('seller.earnings') }}" class="group bg-white rounded-2xl border border-pink-100 shadow-sm p-5 hover:shadow-md hover:border-pink-200 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-pink-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">${{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Total Earnings</p>
        </a>

        {{-- Products --}}
        <a href="{{ route('seller.products.index') }}" class="group bg-white rounded-2xl border border-pink-100 shadow-sm p-5 hover:shadow-md hover:border-pink-200 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <svg class="w-4 h-4 text-gray-300 group-hover:text-pink-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $productsCount }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Active Products</p>
        </a>

        {{-- Orders --}}
        <a href="{{ route('seller.orders.index') }}" class="group bg-white rounded-2xl border border-pink-100 shadow-sm p-5 hover:shadow-md hover:border-pink-200 transition-all">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                @if(($pendingOrdersCount ?? 0) > 0)
                    <span class="text-[10px] font-bold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">
                        {{ $pendingOrdersCount }} pending
                    </span>
                @endif
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $ordersCount }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Total Orders</p>
        </a>

        {{-- Rating --}}
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">
                {{ $averageRating !== null ? number_format($averageRating, 1) : '—' }}
                @if($averageRating)
                    <span class="text-sm text-gray-400 font-normal">/ 5</span>
                @endif
            </p>
            <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Average Rating</p>
        </div>

    </section>

    {{-- ══ QUICK ACTIONS ══ --}}
    @if($seller->status === 'approved')
    <section class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        @foreach([
            ['route' => 'seller.products.create',     'label' => 'New Product',   'icon' => 'M12 4v16m8-8H4',                                               'color' => 'pink'],
            ['route' => 'seller.products.import.form', 'label' => 'Import CSV',   'icon' => 'M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3', 'color' => 'blue'],
            ['route' => 'seller.images.index',         'label' => 'Image Gallery', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'purple'],
            ['route' => 'seller.settings.edit',        'label' => 'Settings',     'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'color' => 'gray'],
        ] as $action)
        <a href="{{ route($action['route']) }}"
           class="flex items-center gap-3 px-4 py-3 bg-white rounded-xl border border-pink-100 hover:border-pink-200 hover:shadow-sm transition-all group">
            <div class="w-8 h-8 rounded-lg bg-{{ $action['color'] }}-100 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-{{ $action['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/>
                </svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-pink-600 transition-colors">{{ $action['label'] }}</span>
        </a>
        @endforeach
    </section>
    @endif

    {{-- ══ RECENT ORDERS + RECENT PRODUCTS ══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Recent Orders --}}
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-pink-100 flex items-center justify-between">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Recent Orders</h2>
                <a href="{{ route('seller.orders.index') }}" class="text-xs text-pink-600 hover:text-pink-700 font-semibold">
                    View All →
                </a>
            </div>

            @if(isset($recentOrders) && $recentOrders->count())
            <div class="divide-y divide-pink-50">
                @foreach($recentOrders as $vo)
                @php $mainOrder = $vo->order; @endphp
                <a href="{{ route('seller.orders.show', $vo->id) }}"
                   class="flex items-center gap-3 px-5 py-3.5 hover:bg-pink-50/50 transition-colors">
                    {{-- Status dot --}}
                    <div class="shrink-0">
                        @php
                            $dotColor = match($vo->status) {
                                'pending'    => 'bg-amber-400',
                                'processing' => 'bg-blue-400',
                                'confirmed'  => 'bg-green-500',
                                'shipped'    => 'bg-purple-500',
                                'cancelled'  => 'bg-red-400',
                                default      => 'bg-gray-400',
                            };
                        @endphp
                        <div class="w-2.5 h-2.5 rounded-full {{ $dotColor }}"></div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">#{{ $mainOrder->order_number ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-400">{{ $mainOrder->customer_name ?? 'Unknown' }}</p>
                    </div>

                    <div class="text-right shrink-0">
                        <p class="text-sm font-bold text-gray-900">${{ number_format($vo->subtotal, 2) }}</p>
                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $vo->created_at->diffForHumans(null, true, true) }}</p>
                    </div>

                    @php
                        $badgeClass = match($vo->status) {
                            'pending'    => 'bg-amber-100 text-amber-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'confirmed'  => 'bg-green-100 text-green-700',
                            'shipped'    => 'bg-purple-100 text-purple-700',
                            'cancelled'  => 'bg-red-100 text-red-700',
                            default      => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $badgeClass }} shrink-0">
                        {{ ucfirst($vo->status) }}
                    </span>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-10 text-gray-400">
                <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-sm">No orders yet</p>
            </div>
            @endif
        </div>

        {{-- Recent Products --}}
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-pink-100 flex items-center justify-between">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Your Products</h2>
                <a href="{{ route('seller.products.index') }}" class="text-xs text-pink-600 hover:text-pink-700 font-semibold">
                    View All →
                </a>
            </div>

            @if(isset($recentProducts) && $recentProducts->count())
            <div class="divide-y divide-pink-50">
                @foreach($recentProducts as $product)
                <a href="{{ route('seller.products.show', $product) }}"
                   class="flex items-center gap-3 px-5 py-3 hover:bg-pink-50/50 transition-colors">
                    {{-- Thumbnail --}}
                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 border border-pink-100 shrink-0">
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.onerror=null;this.src='https://placehold.co/80x80/fce7f3/db2777?text=?'">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $product->name }}</p>
                        <p class="text-xs text-gray-400">SKU: {{ $product->sku ?? '—' }}</p>
                    </div>

                    <div class="text-right shrink-0">
                        @if($product->on_sale && $product->sale_price)
                            <p class="text-sm font-bold text-rose-600">${{ number_format($product->sale_price, 2) }}</p>
                            <p class="text-[10px] text-gray-400 line-through">${{ number_format($product->price, 2) }}</p>
                        @else
                            <p class="text-sm font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                        @endif
                    </div>

                    <div class="shrink-0">
                        @if($product->is_active)
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-700">Active</span>
                        @else
                            <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-red-100 text-red-700">Inactive</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-10 text-gray-400">
                <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                <p class="text-sm">No products yet</p>
                <a href="{{ route('seller.products.create') }}" class="text-xs text-pink-600 underline mt-1 inline-block">Add your first product</a>
            </div>
            @endif
        </div>

    </div>

    {{-- ══ STORE STATUS ══ --}}
    <section class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-pink-100 flex items-center gap-3">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Store Status</h2>
            @php
                $statusBadge = match($seller->status) {
                    'approved' => 'bg-green-100 text-green-700',
                    'pending'  => 'bg-amber-100 text-amber-700',
                    'rejected' => 'bg-red-100 text-red-700',
                    default    => 'bg-gray-100 text-gray-700',
                };
            @endphp
            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $statusBadge }} capitalize">
                {{ $seller->status }}
            </span>
        </div>

        <div class="p-6">
            @if($seller->status === 'approved')
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-green-700 font-bold">Your seller account is active!</p>
                        <p class="text-sm text-gray-500">Manage your products, track sales, and grow your store.</p>
                    </div>
                </div>
                @includeIf('seller.partials.onboarding-checklist', ['seller' => $seller])

            @elseif($seller->status === 'pending')
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-amber-700 font-bold">Application Under Review</p>
                        <p class="text-sm text-gray-500">
                            Your application is being reviewed by our team.
                            <a href="{{ route('seller.register.form') }}" class="text-pink-600 underline font-medium">Review your profile</a>.
                        </p>
                    </div>
                </div>
                @includeIf('seller.partials.onboarding-checklist', ['seller' => $seller])

            @elseif($seller->status === 'rejected')
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-red-700 font-bold">Application Rejected</p>
                        <p class="text-sm text-gray-500">
                            Please update your info and re-apply:
                            <a href="{{ route('seller.register.form') }}" class="text-pink-600 underline font-medium">Edit application</a>.
                        </p>
                        @if($seller->admin_comment)
                            <p class="mt-2 text-sm text-red-500 bg-red-50 px-3 py-2 rounded-lg border border-red-100">
                                <strong>Reason:</strong> {{ $seller->admin_comment }}
                            </p>
                        @endif
                    </div>
                </div>
                @includeIf('seller.partials.onboarding-checklist', ['seller' => $seller])
            @else
                <p class="text-gray-600">Status information unavailable.</p>
            @endif
        </div>
    </section>

</div>
@endif
@endsection
