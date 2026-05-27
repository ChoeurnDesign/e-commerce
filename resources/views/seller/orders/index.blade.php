@extends('layouts.seller')

@section('title', 'My Orders')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <span class="mr-2">
            <x-icon-dashboard name="orders" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
        </span>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">My Orders</h1>
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
                @forelse($orders as $vendorOrder)
                {{-- We access the main order details via the relationship --}}
                @php $mainOrder = $vendorOrder->order; @endphp

                <tr class="hover:bg-gray-300 dark:hover:bg-[#262c47]">
                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                        #{{ $mainOrder->order_number }}
                    </td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                        {{ $mainOrder->customer_name }}
                        <br>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $mainOrder->customer_email }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-indigo-700 dark:text-indigo-300">
                        {{-- Show the specific earnings for this seller, not the whole order total --}}
                        ${{ number_format($vendorOrder->subtotal, 2) }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                            {{ $mainOrder->payment_status == 'paid'
                                ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300'
                                : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300' }}">
                            {{ ucfirst($mainOrder->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                            @class([
                                'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300' => $vendorOrder->status === 'pending',
                                'bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300' => $vendorOrder->status === 'processing',
                                'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' => $vendorOrder->status === 'confirmed',
                                'bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300'=> $vendorOrder->status === 'shipped',
                                'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' => $vendorOrder->status === 'cancelled',
                            ])">
                            {{ ucfirst($vendorOrder->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                        {{ $vendorOrder->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center justify-center space-x-3">
                            
                            {{-- If the order is still Pending, show the clickable button --}}
                            @if($vendorOrder->status === 'pending')
                                <form action="{{ route('seller.orders.confirm', $vendorOrder->id) }}" method="POST" onsubmit="return confirm('Confirm this order?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-lg text-sm font-medium transition-all shadow-md flex items-center">
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