@extends('layouts.seller')

@section('title', 'Earnings & Wallet')

@section('content')
<div class="max-w-full mx-auto space-y-8 bg-gray-300 dark:bg-[#181f31] min-h-screen p-8">
    {{-- Header Section --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <span class="mr-3 p-2 bg-white dark:bg-[#23263a] rounded-lg shadow-sm">
                <x-icon-nav name="wallet" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
            </span>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Earnings & Wallet</h1>
        </div>
    </div>

    {{-- Wallet Balance Card --}}
    <div class="bg-white dark:bg-[#23263a] p-8 rounded-xl shadow-md border-l-4 border-green-500 border border-gray-100 dark:border-[#23263a]">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="p-4 rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                    <x-icon-nav name="wallet" class="h-10 w-10" />
                </div>
                <div class="ml-6">
                    <h4 class="text-4xl font-extrabold text-gray-900 dark:text-white">
                        ${{ number_format($totalBalance, 2) }}
                    </h4>
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider mt-1">
                        Total Available Balance
                    </div>
                </div>
            </div>
            <div class="hidden md:block text-right">
                <span class="text-xs font-medium text-gray-400 dark:text-gray-500 italic">
                    *Earnings are released after customer confirmation
                </span>
            </div>
        </div>
    </div>

    {{-- Transaction History Table --}}
    <div class="space-y-4">
        <h4 class="text-lg font-bold text-gray-800 dark:text-gray-200">Recent Transactions</h4>
        <div class="bg-white dark:bg-[#23263a] shadow-sm overflow-hidden border border-gray-200 dark:border-[#23263a] rounded-xl">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr class="bg-gray-300 dark:bg-[#232c47]">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Order Number</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Subtotal</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Commission (10%)</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">My Earnings</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($recentTransactions as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-[#262c47] transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 font-bold">
                                #{{ $item->order->order_number }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                {{ $item->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-200 font-semibold">
                                ${{ number_format($item->subtotal, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-red-600 dark:text-red-400">
                                -${{ number_format($item->commission_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span @class([
                                    'px-2.5 py-0.5 rounded-full text-xs font-bold uppercase',
                                    'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-400' => $item->status === 'completed',
                                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-400' => $item->status !== 'completed',
                                ])>
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-right {{ $item->status === 'completed' ? 'text-green-600 dark:text-green-400' : 'text-gray-400' }}">
                                +${{ number_format($item->seller_earnings, 2) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center text-gray-500 dark:text-gray-400 font-medium">
                                <div class="flex flex-col items-center">
                                    <x-icon-dashboard name="wallet" class="h-12 w-12 mb-3 opacity-20" />
                                    No transactions recorded yet.
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($recentTransactions instanceof \Illuminate\Pagination\LengthAwarePaginator && $recentTransactions->hasPages())
            <div class="px-6 py-4 bg-gray-50 dark:bg-[#23263a] border-t border-gray-100 dark:border-[#23263a]">
                {{ $recentTransactions->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection