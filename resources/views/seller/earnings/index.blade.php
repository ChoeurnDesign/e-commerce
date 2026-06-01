@extends('layouts.seller')

@section('title', 'Earnings & Wallet')

@section('content')
<div class="space-y-6">

    {{-- ══ HERO BALANCE CARD ══ --}}
    <div class="bg-gradient-to-br from-pink-600 via-pink-500 to-rose-400 rounded-2xl shadow-lg p-6 sm:p-8 text-white relative overflow-hidden">
        {{-- Decorative --}}
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/10 rounded-full"></div>

        <div class="relative z-10">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <p class="text-pink-200 text-sm font-medium mb-1">Available Balance</p>
                    <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight">
                        ${{ number_format($totalBalance, 2) }}
                    </h1>
                </div>
                <div class="flex gap-2 shrink-0">
                    <a href="{{ route('seller.orders.index') }}"
                       class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-semibold px-4 py-2.5 rounded-xl transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        View Orders
                    </a>
                </div>
            </div>

            {{-- Mini stats row --}}
            <div class="grid grid-cols-3 gap-3 sm:gap-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 border border-white/10">
                    <p class="text-2xl sm:text-3xl font-extrabold">${{ number_format($pendingEarnings, 2) }}</p>
                    <p class="text-[11px] text-pink-200 font-medium mt-1 uppercase tracking-wider">Pending</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 border border-white/10">
                    <p class="text-2xl sm:text-3xl font-extrabold">${{ number_format($totalRevenue, 2) }}</p>
                    <p class="text-[11px] text-pink-200 font-medium mt-1 uppercase tracking-wider">Total Revenue</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3 border border-white/10">
                    <p class="text-2xl sm:text-3xl font-extrabold">${{ number_format($totalCommission, 2) }}</p>
                    <p class="text-[11px] text-pink-200 font-medium mt-1 uppercase tracking-wider">Commission Paid</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ STATS CARDS ══ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $completedOrders }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Completed</p>
        </div>

        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                @if($pendingOrders > 0)
                <span class="text-[10px] font-bold bg-amber-100 text-amber-700 px-2 py-0.5 rounded-full">Action needed</span>
                @endif
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $pendingOrders }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Pending</p>
        </div>

        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $totalOrders }}</p>
            <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Total Orders</p>
        </div>

        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">
                @if($totalRevenue > 0)
                    {{ number_format(($totalBalance / $totalRevenue) * 100, 1) }}%
                @else
                    0%
                @endif
            </p>
            <p class="text-xs text-gray-500 font-medium mt-1 uppercase tracking-wider">Net Margin</p>
        </div>

    </div>

    {{-- ══ HOW EARNINGS WORK ══ --}}
    <div class="bg-pink-50 border border-pink-100 rounded-xl px-5 py-4 flex items-start gap-3 text-sm text-pink-800">
        <svg class="w-5 h-5 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <span class="font-semibold">How earnings work:</span>
            A <strong>10% commission</strong> is deducted from each order subtotal. Your earnings are released to your available balance once the order is marked as <strong>completed</strong> by the customer.
            Pending earnings will become available after customer confirmation.
        </div>
    </div>

    {{-- ══ TRANSACTIONS TABLE ══ --}}
    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-pink-100 flex items-center justify-between">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Transaction History</h2>
            <span class="text-xs text-gray-400 bg-pink-50 px-2.5 py-1 rounded-full">
                {{ $recentTransactions->total() }} total
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-pink-50 border-b border-pink-100">
                        <th class="px-5 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-5 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-5 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider">Subtotal</th>
                        <th class="px-5 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider">Commission</th>
                        <th class="px-5 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider">Your Earnings</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pink-50">
                    @forelse($recentTransactions as $item)
                    @php
                        $statusClass = match($item->status) {
                            'completed' => 'bg-green-100 text-green-700',
                            'confirmed' => 'bg-blue-100 text-blue-700',
                            'pending'   => 'bg-amber-100 text-amber-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            default     => 'bg-gray-100 text-gray-700',
                        };
                        $earningColor = match($item->status) {
                            'completed' => 'text-green-600',
                            'cancelled' => 'text-red-400 line-through',
                            default     => 'text-gray-500',
                        };
                    @endphp
                    <tr class="hover:bg-pink-50/50 transition-colors">
                        <td class="px-5 py-4">
                            <a href="{{ route('seller.orders.show', $item->id) }}" class="text-sm font-bold text-gray-900 hover:text-pink-600 transition-colors">
                                #{{ $item->order->order_number ?? 'N/A' }}
                            </a>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $item->order->customer_name ?? '' }}</p>
                        </td>
                        <td class="px-5 py-4">
                            <p class="text-sm text-gray-700">{{ $item->created_at->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-400">{{ $item->created_at->format('g:i A') }}</p>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <p class="text-sm font-semibold text-gray-800">${{ number_format($item->subtotal, 2) }}</p>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <p class="text-sm font-medium text-red-500">-${{ number_format($item->commission_amount, 2) }}</p>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $statusClass }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right">
                            <p class="text-sm font-bold {{ $earningColor }}">
                                +${{ number_format($item->seller_earnings, 2) }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center text-gray-400">
                                <svg class="w-12 h-12 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                                <p class="text-sm font-medium">No transactions yet</p>
                                <p class="text-xs mt-1">Your earnings will appear here once you receive orders</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($recentTransactions instanceof \Illuminate\Pagination\LengthAwarePaginator && $recentTransactions->hasPages())
        <div class="px-5 py-4 bg-pink-50 border-t border-pink-100">
            {{ $recentTransactions->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
