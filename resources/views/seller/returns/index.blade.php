@extends('layouts.seller')

@section('title', 'Returns & Refunds')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
            </svg>
        </div>
        <div>
            <h1 class="text-xl font-bold text-gray-900">Returns & Refunds</h1>
            <p class="text-xs text-gray-500">Review and process customer return requests</p>
        </div>
    </div>

    {{-- Status filter tabs --}}
    <div class="flex items-center gap-2 bg-white border border-pink-100 rounded-xl p-1 overflow-x-auto">
        @php
            $tabs = [
                ['key' => null,                    'label' => 'All',      'count' => array_sum($counts)],
                ['key' => 'pending_seller_review', 'label' => 'Pending',  'count' => $counts['pending_seller_review']],
                ['key' => 'approved',              'label' => 'Approved', 'count' => $counts['approved']],
                ['key' => 'refunded',              'label' => 'Refunded', 'count' => $counts['refunded']],
                ['key' => 'rejected',              'label' => 'Rejected', 'count' => $counts['rejected']],
            ];
        @endphp
        @foreach($tabs as $tab)
            @php $isActive = ($status ?? null) === $tab['key']; @endphp
            <a href="{{ route('seller.returns.index', $tab['key'] ? ['status' => $tab['key']] : []) }}"
               class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all
                      {{ $isActive ? 'bg-pink-600 text-white' : 'text-gray-600 hover:bg-pink-50' }}">
                {{ $tab['label'] }}
                @if($tab['count'] > 0)
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full
                                 {{ $isActive ? 'bg-white/20' : 'bg-pink-100 text-pink-700' }}">{{ $tab['count'] }}</span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- List --}}
    @if($returns->count())
    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm overflow-hidden">
        <div class="divide-y divide-pink-50">
            @foreach($returns as $return)
            @php
                $badge = match($return->status) {
                    'pending_seller_review' => ['bg-amber-100 text-amber-700', 'Pending Review'],
                    'approved'              => ['bg-blue-100 text-blue-700', 'Approved'],
                    'refunded'              => ['bg-green-100 text-green-700', 'Refunded'],
                    'completed'             => ['bg-green-100 text-green-700', 'Completed'],
                    'rejected'              => ['bg-red-100 text-red-700', 'Rejected'],
                    'cancelled'             => ['bg-gray-100 text-gray-600', 'Cancelled'],
                    default                 => ['bg-gray-100 text-gray-600', ucfirst($return->status)],
                };
            @endphp
            <a href="{{ route('seller.returns.show', $return) }}"
               class="block px-5 py-4 hover:bg-pink-50/50 transition-colors">
                <div class="flex items-center justify-between gap-3 flex-wrap">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm font-bold text-gray-900">{{ $return->reference }}</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $badge[0] }}">{{ $badge[1] }}</span>
                            @if($return->status === 'pending_seller_review')
                                <span class="text-[10px] font-bold text-rose-500 animate-pulse">⏰ Action required</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-500">
                            Order #{{ $return->order->order_number }}
                            · {{ $return->customer->name ?? 'Customer' }}
                            · {{ $return->created_at->diffForHumans() }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">Reason: {{ $return->reasonLabel() }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-pink-600">${{ number_format($return->refund_amount, 2) }}</p>
                        <p class="text-[10px] text-gray-400">{{ $return->items->sum('quantity') }} item(s)</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        @if($returns->hasPages())
        <div class="px-5 py-4 border-t border-pink-100 bg-pink-50">{{ $returns->links() }}</div>
        @endif
    </div>
    @else
    <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-12 text-center">
        <svg class="w-14 h-14 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="text-lg font-semibold text-gray-700 mb-1">No return requests</h3>
        <p class="text-sm text-gray-400">When customers request returns, they'll appear here for your review.</p>
    </div>
    @endif

</div>
@endsection
