@extends('layouts.seller')

@section('title', 'Order Details')

@section('content')
@php $mainOrder = $vendorOrder->order; @endphp

<div class="max-w-full mx-auto space-y-8 bg-gray-300 dark:bg-[#181f31] min-h-screen p-8">
    {{-- Header Section --}}
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Order #{{ $mainOrder->order_number }} Details</h2>
        <div class="flex space-x-2">
            @if(in_array($vendorOrder->status, ['pending', 'processing']))
                <form action="{{ route('seller.orders.confirm', $vendorOrder->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition shadow-md font-medium">
                        Confirm Order
                    </button>
                </form>
            @endif
            <a href="{{ route('seller.orders.index') }}"
                class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#262c47] text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition duration-200">
                &larr; Back to Orders
            </a>
        </div>
    </div>

    {{-- Info Card --}}
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 space-y-4 border border-gray-100 dark:border-[#23263a]">
        <div class="flex flex-col md:flex-row md:justify-between gap-6">
            <div>
                <h3 class="font-semibold text-lg mb-2 text-gray-800 dark:text-gray-100">Customer Info</h3>
                <div class="text-gray-700 dark:text-gray-200">
                    <div>Name: <span class="font-medium">{{ $mainOrder->customer_name }}</span></div>
                    <div>Email: <span class="font-medium text-indigo-600 dark:text-indigo-400">{{ $mainOrder->customer_email }}</span></div>
                </div>
            </div>
            <div>
                <h3 class="font-semibold text-lg mb-2 text-gray-800 dark:text-gray-100">Order Info</h3>
                <div class="text-gray-700 dark:text-gray-200">
                    <div>Order ID: <span class="font-medium">#{{ $mainOrder->order_number }}</span></div>
                    <div>Placed At: <span class="font-medium">{{ $vendorOrder->created_at->format('Y-m-d H:i') }}</span></div>
                    <div class="mt-1">Status:
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                            @class([
                                'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300' => $vendorOrder->status === 'pending',
                                'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' => $vendorOrder->status === 'processing',
                                'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' => $vendorOrder->status === 'confirmed',
                                'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' => $vendorOrder->status === 'cancelled',
                            ])">
                            {{ ucfirst($vendorOrder->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Product Table Card --}}
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-100 dark:border-[#23263a]">
        <h3 class="font-semibold text-lg mb-4 text-gray-800 dark:text-gray-100">Your Products in this Order</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead class="bg-gray-300 dark:bg-[#23263a]">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Qty</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                    @foreach($vendorOrder->items as $item)
                        @php
                            $rawPath = $item->product_image ?? $item->fallback_image;
                            $imageUrl = $rawPath ? (filter_var($rawPath, FILTER_VALIDATE_URL) ? $rawPath : asset(ltrim($rawPath, '/'))) : asset('images/placeholder.png');
                        @endphp
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img src="{{ $imageUrl }}" 
                                         class="w-12 h-12 rounded-lg mr-3 object-cover border border-gray-200 dark:border-gray-600"
                                         alt="{{ $item->product_name }}">
                                    <div>
                                        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $item->product_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">SKU: {{ $item->product_sku ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                ${{ number_format($item->price, 2) }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-700 dark:text-gray-200">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900 dark:text-gray-100">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Totals Section --}}
        <div class="flex flex-col items-end mt-6 space-y-1">
            <span class="text-gray-600 dark:text-gray-400">Subtotal: <span class="font-medium text-gray-900 dark:text-gray-100">${{ number_format($vendorOrder->subtotal, 2) }}</span></span>
            <span class="text-gray-600 dark:text-gray-400">Commission: <span class="text-red-500 font-medium">-${{ number_format($vendorOrder->commission_amount, 2) }}</span></span>
            <div class="pt-2 border-t border-gray-200 dark:border-gray-700 mt-2">
                <span class="text-xl font-bold text-indigo-700 dark:text-indigo-300">Your Earnings: ${{ number_format($vendorOrder->seller_earnings, 2) }}</span>
            </div>
        </div>
    </div>
</div>
@endsection