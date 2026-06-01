@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between flex-wrap gap-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Orders</h1>
                <p class="text-xs text-gray-500">Manage and track all customer orders</p>
            </div>
        </div>
    </div>

    {{-- Search --}}
    <x-admin.simple-search
        placeholder="Order # / Name / Email"
        hint="ID, order number, customer name/email"
        :autofocus="true"
        width="w-80"
    />

    {{-- Orders table --}}
    <div class="bg-white shadow-sm overflow-hidden border border-gray-100 rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                <tr class="bg-gray-50">
                    <th class="px-5 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Order</th>
                    <th class="px-5 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="px-5 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-5 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Payment</th>
                    <th class="px-5 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-5 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                @forelse($orders as $order)
                    @php
                        $statusClass = match($order->status) {
                            'pending'    => 'bg-amber-100 text-amber-700',
                            'processing' => 'bg-blue-100 text-blue-700',
                            'confirmed'  => 'bg-indigo-100 text-indigo-700',
                            'shipped'    => 'bg-purple-100 text-purple-700',
                            'delivered'  => 'bg-teal-100 text-teal-700',
                            'completed'  => 'bg-green-100 text-green-700',
                            'cancelled'  => 'bg-red-100 text-red-700',
                            default      => 'bg-gray-100 text-gray-600',
                        };
                        $payClass = match($order->payment_status) {
                            'paid'                   => 'bg-green-100 text-green-700',
                            'pending'                => 'bg-amber-100 text-amber-700',
                            'awaiting_verification'  => 'bg-blue-100 text-blue-700',
                            'failed'                 => 'bg-red-100 text-red-700',
                            'refunded'               => 'bg-gray-100 text-gray-600',
                            default                  => 'bg-gray-100 text-gray-600',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-bold text-gray-900 hover:text-indigo-600 transition-colors">
                                #{{ $order->order_number }}
                            </a>
                            <p class="text-[10px] text-gray-400 mt-0.5">ID: {{ $order->id }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-sm font-medium text-gray-800">{{ $order->display_name }}</p>
                            <p class="text-xs text-gray-400">{{ $order->display_email }}</p>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <p class="text-sm font-bold text-gray-900">${{ number_format($order->total_price, 2) }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $payClass }}">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-sm text-gray-700">{{ $order->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->format('g:i A') }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}"
                                   class="p-1.5 rounded-lg hover:bg-gray-100 transition-colors text-gray-500 hover:text-indigo-600"
                                   title="View">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}"
                                   class="p-1.5 rounded-lg hover:bg-gray-100 transition-colors text-gray-500 hover:text-amber-600"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                @if(!in_array($order->status, ['completed', 'delivered', 'shipped']))
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="button" onclick="confirmDelete(event, this)"
                                            data-confirm="Delete order #{{ $order->order_number }}? Stock will be restored."
                                            class="p-1.5 rounded-lg hover:bg-red-50 transition-colors text-gray-400 hover:text-red-600"
                                            title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-500">No orders found.</p>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
