@extends('layouts.admin')
@section('title', 'Seller Detail')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="flex items-center mb-6">
        <x-icon-dashboard name="users" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
        <h1 class="ml-2 text-2xl font-bold text-gray-900 dark:text-gray-100">Seller Detail</h1>
    </div>

    <div class="bg-white dark:bg-[#23263a] p-6 rounded shadow">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><b>Name:</b> {{ $seller->user?->name ?? '-' }}</div>
            <div><b>Email:</b> {{ $seller->user?->email ?? '-' }}</div>
            <div><b>Store:</b> {{ $seller->store_name ?? '-' }}</div>
            <div><b>Status:</b> <x-status-badge :status="$seller->status"/></div>
            <div><b>Applied At:</b> {{ $seller->created_at?->format('Y-m-d H:i') }}</div>
            <div><b>Total Products:</b> {{ $seller->products_count ?? $seller->products->count() }}</div>
            <div><b>Total Orders:</b> {{ $seller->orders_count ?? $seller->orders->count() }}</div>
            <div><b>Total Sales:</b> ${{ number_format($seller->total_sales ?? 0, 2) }}</div>
        </div>

        <div class="mt-6">
            @include('admin.sellers.partials.actions', ['seller' => $seller, 'compact' => false])
        </div>
    </div>

    @include('admin.sellers.partials.business_document', ['seller' => $seller])

    @include('admin.sellers.partials.products', [
        'seller'   => $seller,
        'products' => $products ?? $seller->products ?? collect()
    ])

    @include('admin.sellers.partials.orders', [
        'seller' => $seller,
        'orders' => $orders ?? $seller->orders ?? collect()
    ])
</div>
@endsection
