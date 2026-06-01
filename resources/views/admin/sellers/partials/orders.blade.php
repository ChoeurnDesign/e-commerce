@php
    // Ensure $orders is a collection
    $orders = $orders ?? collect();
@endphp

<div class="mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Seller Orders</h3>

    @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 bg-white rounded shadow">
                <thead>
                <tr class="bg-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Date</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4 text-gray-900 font-semibold">
                            #{{ $order->id }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $order->order_number ?? 'N/A' }}
                        </td>
                        {{-- FIX: Changed $order->customer to $order->user to match your Controller --}}
                        <td class="px-6 py-4 text-gray-700">
                            {{ $order->user?->name ?? 'Guest' }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            ${{ number_format((float) ($order->total_price ?? 0), 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-2 py-1 rounded-full text-xs
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status === 'completed') bg-green-100 text-green-700
                                @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                                @else bg-gray-200 text-gray-700 @endif">
                                {{ ucfirst($order->status ?? 'pending') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            {{ $order->created_at ? $order->created_at->format('Y-m-d H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs rounded transition"
                               target="_blank">
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="bg-white p-8 text-gray-500 text-center rounded shadow">
            No orders found for this seller.
        </div>
    @endif
</div>