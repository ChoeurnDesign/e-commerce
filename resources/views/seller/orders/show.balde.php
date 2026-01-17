@extends('layouts.seller')

@section('title', 'Order Details')

@section('content')
<div class="max-w-full mx-auto space-y-8 bg-gray-300 dark:bg-[#181f31] min-h-screen p-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Order #{{ $order->id }} Details</h2>
        <a href="{{ route('seller.orders.index') }}"
            class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#262c47] text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition duration-200">
            &larr; Back to Orders
        </a>
    </div>

    <!-- Order & Customer Info -->
    <div
        class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 space-y-4 border border-gray-100 dark:border-[#23263a]">
        <div class="flex flex-col md:flex-row md:justify-between gap-6">
            <div>
                <h3 class="font-semibold text-lg mb-2 text-gray-800 dark:text-gray-100">Customer Info</h3>
                <div class="text-gray-700 dark:text-gray-200">
                    <div>Name: <span class="font-medium">{{ $order->customer_name }}</span></div>
                    <div>Email: <span class="font-medium">{{ $order->customer_email }}</span></div>
                </div>
            </div>
            <div>
                <h3 class="font-semibold text-lg mb-2 text-gray-800 dark:text-gray-100">Order Info</h3>
                <div class="text-gray-700    dark:text-gray-200">
                    <div>Order ID: <span class="font-medium">#{{ $order->id }}</span></div>
                    <div>Placed At: <span class="font-medium">{{ $order->created_at->format('Y-m-d H:i') }}</span></div>
                    <div>Status:
                        <span
                            class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                            {{ $order->status == 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300' : '' }}
                            {{ $order->status == 'completed' ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' : '' }}
                            {{ $order->status == 'cancelled' ? 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' : '' }}
                            {{ !in_array($order->status, ['pending', 'completed', 'cancelled']) ? 'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div>Payment:
                        <span
                            class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $order->payment_status == 'paid' ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-100 dark:border-[#23263a]">
        <h3 class="font-semibold text-lg mb-4 text-gray-800 dark:text-gray-100">Products in Order</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead class="bg-gray-300 dark:bg-[#23263a]">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Product</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            SKU</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Price</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Quantity</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">
                            Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-4 py-2 text-gray-900 dark:text-gray-100">
                            {{ $item->product?->name ?? 'Product Deleted' }}
                        </td>
                        <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $item->product?->sku ?? '-' }}</td>
                        <td class="px-4 py-2 text-gray-900 dark:text-gray-100">${{ number_format($item->price, 2) }}
                        </td>
                        <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 font-semibold text-gray-900 dark:text-gray-100">
                            ${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex justify-end mt-4">
            <span class="text-xl font-bold text-indigo-700 dark:text-indigo-300">Total:
                ${{ number_format($order->total_price, 2) }}</span>
        </div>
    </div>
</div>
@endsection