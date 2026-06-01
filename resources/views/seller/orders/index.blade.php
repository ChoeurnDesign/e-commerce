@extends('layouts.seller')

@section('title', 'My Orders')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
            <x-icon-dashboard name="orders" class="w-5 h-5 text-pink-600"/>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">My Orders</h1>
            <p class="text-xs text-gray-500">Track and manage your customer orders</p>
        </div>
    </div>

    {{-- Reusable Simple Search Component --}}
    <x-admin.simple-search
        placeholder="Order # / Name / Email"
        hint="ID, order number, customer name/email"
        :autofocus="true"
        width="w-80"
    />

    <div class="bg-white shadow-sm overflow-hidden border border-pink-100 rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-pink-100">
                <thead>
                <tr class="bg-pink-50">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-pink-100">
                @forelse($orders as $vendorOrder)
                {{-- We access the main order details via the relationship --}}
                @php $mainOrder = $vendorOrder->order; @endphp

                <tr class="hover:bg-pink-50">
                    <td class="px-6 py-4 text-gray-900">
                        #{{ $mainOrder->order_number }}
                    </td>
                    <td class="px-6 py-4 text-gray-700">
                        {{ $mainOrder->customer_name }}
                        <br>
                        <span class="text-xs text-gray-500">
                            {{ $mainOrder->customer_email }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-pink-700">
                        {{-- Show the specific earnings for this seller, not the whole order total --}}
                        ${{ number_format($vendorOrder->subtotal, 2) }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                            {{ $mainOrder->payment_status == 'paid'
                                ? 'bg-green-100 text-green-700'
                                : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($mainOrder->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                            @class([
                                'bg-yellow-100 text-yellow-700' => $vendorOrder->status === 'pending',
                                'bg-pink-100 text-pink-700' => $vendorOrder->status === 'processing',
                                'bg-green-100 text-green-700' => $vendorOrder->status === 'confirmed',
                                'bg-purple-100 text-purple-700'=> $vendorOrder->status === 'shipped',
                                'bg-red-100 text-red-700' => $vendorOrder->status === 'cancelled',
                            ])">
                            {{ ucfirst($vendorOrder->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-700">
                        {{ $vendorOrder->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center space-x-3">
                            
                            {{-- If the order is still Pending, show the clickable button --}}
                            @if($vendorOrder->status === 'pending')
                                <form action="{{ route('seller.orders.confirm', $vendorOrder->id) }}" method="POST" data-confirm="Confirm this order?">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-1.5 rounded-lg text-sm font-medium transition-all shadow-md flex items-center">
                                        Confirm Order
                                    </button>
                                </form>
                            @endif

                            {{-- If the order is already Confirmed, show the Check Icon + Text --}}
                            @if($vendorOrder->status === 'confirmed')
                                <div class="flex items-center text-green-500 font-semibold px-4 py-1.5 border border-green-500/30 bg-green-500/10 rounded-lg text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Confirmed
                                </div>
                            @endif
                            
                            {{-- The View Button always stays visible --}}
                            <a href="{{ route('seller.orders.show', $vendorOrder->id) }}" class="text-gray-400 hover:text-white transition-colors" title="View Details">
                                <div class="flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span class="text-sm">View</span>
                                </div>
                            </a>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-12 text-center text-gray-500 text-lg">
                        No orders found.
                    </td>
                </tr>
            @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-pink-100 bg-white">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection