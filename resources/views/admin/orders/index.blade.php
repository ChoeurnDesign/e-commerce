@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <span class="mr-2">
            <x-icon-dashboard name="orders" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
        </span>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Orders</h1>
    </div>

    {{-- Reusable Simple Search Component --}}
    <x-admin.simple-search
        placeholder="Order # / Name / Email"
        hint="ID, order number, customer name/email"
        :autofocus="true"
        width="w-80"
    />

    <div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead>
                <tr class="bg-gray-300 dark:bg-[#232c47]">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Total Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Payment Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Order Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-300 dark:hover:bg-[#262c47]">
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100">#{{ $order->id }}</td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                            {{ $order->display_name }}
                            <br>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $order->display_email }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-indigo-700 dark:text-indigo-300">
                            ${{ number_format($order->total_price, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            {{-- If using helper: <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $order->paymentBadgeClasses }}">{{ ucfirst($order->payment_status) }}</span> --}}
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                {{ $order->payment_status == 'paid'
                                    ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300'
                                    : ($order->payment_status == 'pending'
                                        ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300'
                                        : 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                @class([
                                    'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300' => $order->status === 'pending',
                                    'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' => $order->status === 'processing',
                                    'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200'        => $order->status === 'confirmed',
                                    'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300'=> $order->status === 'shipped',
                                    'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300'    => $order->status === 'delivered' || $order->status === 'completed',
                                    'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300'            => $order->status === 'cancelled',
                                    'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200'        => ! in_array($order->status, ['pending','processing','confirmed','shipped','delivered','completed','cancelled']),
                                ])">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                            {{ $order->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center space-x-3">
                                <x-admin.table-view-button :href="route('admin.orders.show', $order)" />
                                <x-admin.table-delete-button :action="route('admin.orders.destroy', $order)" />
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-gray-500 dark:text-gray-300 text-lg">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
