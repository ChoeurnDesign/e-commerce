@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
<div class="space-y-6 bg-gray-300 dark:bg-[#181f31] p-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Orders</h2>
    </div>

    <!-- Orders Table -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead class="bg-gray-300 dark:bg-[#23263a]">
                    <tr>
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
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">#{{ $order->id }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                                {{ $order->user?->name ?? 'Guest' }}<br>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $order->user?->email ?? $order->email }}</span>
                            </td>
                            <td class="px-6 py-4 text-indigo-700 dark:text-indigo-300 font-semibold">${{ number_format($order->total_price, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold {{ $order->payment_status == 'paid' ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                {{ $order->status == 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300' : '' }}
                                {{ $order->status == 'completed' ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' : '' }}
                                {{ $order->status == 'cancelled' ? 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' : '' }}
                                {{ !in_array($order->status, ['pending', 'completed', 'cancelled']) ? 'bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-200">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-300 hover:text-indigo-900 dark:hover:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-[#23263a] px-2 py-1 rounded transition-colors duration-200" title="View Order">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center text-amber-600 dark:text-amber-300 hover:text-amber-900 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-[#23263a] px-2 py-1 rounded transition-colors duration-200" title="Edit Order">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-[#23263a] px-2 py-1 rounded transition-colors duration-200" title="Delete Order" onclick="return confirm('Are you sure you want to delete this order?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
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
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
