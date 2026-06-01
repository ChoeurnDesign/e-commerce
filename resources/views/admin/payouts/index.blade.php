@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900">Seller Payouts</h1>
        <p class="text-sm text-gray-500 mt-1">Review withdrawal requests and mark them as paid after manual bank transfer.</p>
    </div>

    {{-- Status tabs --}}
    <div class="flex flex-wrap gap-2 mb-5">
        @foreach([
            'pending'  => ['label' => 'Pending Review',  'color' => 'amber'],
            'approved' => ['label' => 'Approved',        'color' => 'blue'],
            'paid'     => ['label' => 'Paid',            'color' => 'emerald'],
            'rejected' => ['label' => 'Rejected',        'color' => 'rose'],
        ] as $key => $info)
            <a href="{{ route('admin.payouts.index', ['status' => $key]) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-bold transition-colors
                      {{ $status === $key
                          ? 'bg-' . $info['color'] . '-500 text-white shadow-sm'
                          : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
                {{ $info['label'] }}
                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold
                             {{ $status === $key ? 'bg-white/30' : 'bg-gray-100 text-gray-600' }}">
                    {{ $counts[$key] }}
                </span>
            </a>
        @endforeach
    </div>

    @if($payouts->total() === 0)
        <div class="bg-white rounded-2xl border border-gray-100 py-16 text-center">
            <div class="w-16 h-16 mx-auto bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">No {{ $status }} payouts</h3>
        </div>
    @else
        <div class="space-y-4">
            @foreach($payouts as $payout)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">

                        {{-- Seller (left) --}}
                        <div class="lg:col-span-3 p-5 bg-gray-50/50 border-r border-gray-100">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Seller</p>
                            @php
                                $seller = $payout->seller;
                                $initial = strtoupper(substr($seller->store_name ?? 'S', 0, 1));
                                $logo = !empty($seller->store_logo) && !filter_var($seller->store_logo, FILTER_VALIDATE_URL)
                                    ? asset('storage/' . ltrim($seller->store_logo, '/'))
                                    : null;
                            @endphp
                            <div class="flex items-center gap-3">
                                <div class="relative w-12 h-12 rounded-xl overflow-hidden flex-shrink-0 bg-gradient-to-br from-pink-400 to-rose-500 text-white flex items-center justify-center font-extrabold">
                                    {{ $initial }}
                                    @if($logo)
                                        <img src="{{ $logo }}" alt="" class="absolute inset-0 w-full h-full object-cover" onerror="this.style.display='none'">
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-extrabold text-gray-900 truncate">{{ $seller->store_name }}</p>
                                    <p class="text-[11px] text-gray-500 truncate">{{ $seller->user->email ?? '—' }}</p>
                                </div>
                            </div>
                            <p class="text-[11px] text-gray-400 mt-3">
                                Requested {{ $payout->created_at->diffForHumans() }}
                            </p>
                        </div>

                        {{-- Bank details + amount (middle) --}}
                        <div class="lg:col-span-5 p-5">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Amount Requested</p>
                                    <p class="text-3xl font-extrabold text-rose-600">${{ number_format($payout->amount, 2) }}</p>
                                </div>
                                @php $c = $payout->statusColor(); @endphp
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-{{ $c }}-50 text-{{ $c }}-700">
                                    {{ ucfirst($payout->status) }}
                                </span>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-3 text-xs space-y-1.5 border border-gray-100">
                                <div class="flex justify-between gap-2">
                                    <span class="text-gray-500">Bank</span>
                                    <span class="font-bold text-gray-800">{{ $payout->bank_name }}</span>
                                </div>
                                <div class="flex justify-between gap-2">
                                    <span class="text-gray-500">Account Name</span>
                                    <span class="font-bold text-gray-800">{{ $payout->account_name }}</span>
                                </div>
                                <div class="flex justify-between gap-2">
                                    <span class="text-gray-500">Account Number</span>
                                    <span class="font-mono font-bold text-gray-800 select-all">{{ $payout->account_number }}</span>
                                </div>
                                @if($payout->phone)
                                <div class="flex justify-between gap-2">
                                    <span class="text-gray-500">Phone</span>
                                    <span class="font-mono text-gray-800 select-all">{{ $payout->phone }}</span>
                                </div>
                                @endif
                            </div>

                            @if($payout->seller_note)
                                <p class="mt-2 text-[11px] text-gray-600"><span class="font-bold">Seller note:</span> {{ $payout->seller_note }}</p>
                            @endif
                            @if($payout->admin_note)
                                <p class="mt-2 text-[11px] text-{{ $c }}-700"><span class="font-bold">Admin note:</span> {{ $payout->admin_note }}</p>
                            @endif
                            @if($payout->transaction_reference)
                                <p class="mt-2 text-[11px] text-emerald-700 font-mono"><span class="font-bold">Bank ref:</span> {{ $payout->transaction_reference }}</p>
                            @endif
                        </div>

                        {{-- Actions (right) --}}
                        <div class="lg:col-span-4 p-5 bg-gray-50/30 border-l border-gray-100 flex flex-col gap-2"
                             x-data="{ showPay: false, showReject: false }">

                            @if($payout->isPending())
                                {{-- Mark Paid form --}}
                                <form method="POST" action="{{ route('admin.payouts.markPaid', $payout) }}"
                                      x-show="showPay" x-cloak class="space-y-2 mb-2">
                                    @csrf
                                    <input type="text" name="transaction_reference" required
                                           placeholder="Bank transaction reference / ID"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400">
                                    <input type="text" name="admin_note" placeholder="Note (optional)"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-emerald-200 focus:border-emerald-400">
                                    <div class="flex gap-2">
                                        <button type="button" @click="showPay = false"
                                                class="flex-1 px-3 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-xs font-bold hover:bg-gray-50">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="flex-1 px-3 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-bold">
                                            Confirm Paid
                                        </button>
                                    </div>
                                </form>

                                {{-- Reject form --}}
                                <form method="POST" action="{{ route('admin.payouts.reject', $payout) }}"
                                      x-show="showReject" x-cloak class="space-y-2 mb-2">
                                    @csrf
                                    <input type="text" name="admin_note" required
                                           placeholder="Reason for rejection"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                                    <div class="flex gap-2">
                                        <button type="button" @click="showReject = false"
                                                class="flex-1 px-3 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-xs font-bold hover:bg-gray-50">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="flex-1 px-3 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-lg text-xs font-bold">
                                            Confirm Reject
                                        </button>
                                    </div>
                                </form>

                                {{-- Default action buttons --}}
                                <div x-show="!showPay && !showReject" class="space-y-2">
                                    <p class="text-[11px] text-gray-500 mb-2">
                                        💡 Transfer the money via your banking app, then enter the transaction reference below.
                                    </p>
                                    <button @click="showPay = true"
                                            class="w-full px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-bold transition-colors">
                                        ✓ Mark as Paid
                                    </button>
                                    <button @click="showReject = true"
                                            class="w-full px-4 py-2 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-lg text-sm font-semibold transition-colors">
                                        ✕ Reject
                                    </button>
                                </div>
                            @elseif($payout->isApproved())
                                <form method="POST" action="{{ route('admin.payouts.markPaid', $payout) }}" class="space-y-2">
                                    @csrf
                                    <input type="text" name="transaction_reference" required
                                           placeholder="Bank transaction reference"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg text-xs">
                                    <button type="submit"
                                            class="w-full px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-bold">
                                        ✓ Mark as Paid
                                    </button>
                                </form>
                            @else
                                <div class="text-center py-3 text-xs text-gray-400">
                                    @if($payout->isPaid())
                                        Paid {{ $payout->processed_at?->diffForHumans() }}
                                    @elseif($payout->isRejected())
                                        Rejected {{ $payout->processed_at?->diffForHumans() }}
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $payouts->links() }}
        </div>
    @endif
</div>
@endsection
