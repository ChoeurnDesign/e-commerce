@extends('layouts.seller')

@section('content')
<div class="p-6 max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-gray-900">Withdrawals</h1>
        <p class="text-sm text-gray-500 mt-1">Request payouts of your earnings — processed manually within 1–3 business days.</p>
    </div>

    {{-- ═══ BALANCE OVERVIEW ═══════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        {{-- Available --}}
        <div class="bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl p-5 text-white shadow-md">
            <p class="text-[11px] font-bold uppercase tracking-wider text-white/80">Available to Withdraw</p>
            <p class="text-3xl font-extrabold mt-1">${{ number_format($availableBalance, 2) }}</p>
            <p class="text-xs text-white/80 mt-2">From completed orders</p>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-2xl border border-amber-100 p-5 shadow-sm">
            <p class="text-[11px] font-bold uppercase tracking-wider text-amber-600">Pending Withdrawals</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">${{ number_format($pendingPayouts, 2) }}</p>
            <p class="text-xs text-gray-500 mt-2">Awaiting admin approval</p>
        </div>

        {{-- Total withdrawn --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-500">Total Withdrawn</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">${{ number_format($totalWithdrawn, 2) }}</p>
            <p class="text-xs text-gray-500 mt-2">All-time payouts</p>
        </div>
    </div>

    {{-- ═══ REQUEST FORM ═══════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-pink-100 p-6 mb-6 shadow-sm" x-data="{ open: false }">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-base font-extrabold text-gray-900">Request a Payout</h2>
                <p class="text-xs text-gray-500 mt-0.5">Minimum withdrawal: ${{ number_format($minPayout, 2) }}</p>
            </div>
            <button @click="open = !open"
                    :disabled="{{ $availableBalance >= $minPayout ? 'false' : 'true' }}"
                    class="px-5 py-2.5 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600
                           text-white rounded-full font-bold text-sm shadow-md transition-all
                           disabled:opacity-40 disabled:cursor-not-allowed disabled:from-gray-300 disabled:to-gray-400">
                <span x-show="!open">+ New Withdrawal</span>
                <span x-show="open" x-cloak>Cancel</span>
            </button>
        </div>

        @if($availableBalance < $minPayout)
            <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs text-amber-700">
                ⚠ You need at least ${{ number_format($minPayout, 2) }} available to request a withdrawal.
                You currently have ${{ number_format($availableBalance, 2) }}.
            </div>
        @endif

        <div x-show="open" x-cloak x-transition class="mt-5 pt-5 border-t border-pink-100">
            <form method="POST" action="{{ route('seller.payouts.store') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Amount to withdraw <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-bold">$</span>
                        <input type="number" name="amount" step="0.01"
                               min="{{ $minPayout }}" max="{{ $availableBalance }}"
                               value="{{ old('amount', $availableBalance >= $minPayout ? $availableBalance : '') }}"
                               required
                               class="w-full pl-8 pr-3 py-2.5 rounded-lg border border-gray-300 text-sm font-bold text-gray-900 focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-400">
                    </div>
                    <p class="text-[11px] text-gray-500 mt-1">Maximum: ${{ number_format($availableBalance, 2) }}</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Bank <span class="text-rose-500">*</span></label>
                    <select name="bank_name" required
                            class="w-full px-3 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-400">
                        <option value="">Select bank</option>
                        @foreach(['ABA Bank', 'Acleda Bank', 'Wing Bank', 'Pi Pay', 'Sathapana', 'Canadia', 'Other'] as $bank)
                            <option value="{{ $bank }}" {{ old('bank_name') === $bank ? 'selected' : '' }}>{{ $bank }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Account Name <span class="text-rose-500">*</span></label>
                    <input type="text" name="account_name" value="{{ old('account_name') }}" required
                           placeholder="As shown on your bank account"
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Account Number <span class="text-rose-500">*</span></label>
                    <input type="text" name="account_number" value="{{ old('account_number') }}" required
                           placeholder="e.g. 000 123 456 789"
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Phone (optional)</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           placeholder="For wallet services (Wing, Pi Pay)"
                           class="w-full px-3 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-400">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-700 mb-1">Note (optional)</label>
                    <textarea name="seller_note" rows="2"
                              placeholder="Any message for admin"
                              class="w-full px-3 py-2.5 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-pink-200 focus:border-pink-400">{{ old('seller_note') }}</textarea>
                </div>

                <div class="md:col-span-2 flex items-center justify-end gap-2 pt-3">
                    <button type="button" @click="open = false"
                            class="px-5 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white rounded-lg text-sm font-bold shadow-md">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══ HISTORY ════════════════════════════════════════════════════ --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-base font-extrabold text-gray-900">Withdrawal History</h2>
        </div>

        @if($history->total() === 0)
            <div class="py-12 text-center text-sm text-gray-400">
                You haven't made any withdrawal requests yet.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-[11px] font-bold uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-5 py-3 text-left">Date</th>
                            <th class="px-5 py-3 text-left">Amount</th>
                            <th class="px-5 py-3 text-left">Bank</th>
                            <th class="px-5 py-3 text-left">Status</th>
                            <th class="px-5 py-3 text-left">Reference</th>
                            <th class="px-5 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($history as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 text-gray-700">
                                    <div class="font-medium">{{ $p->created_at->format('M j, Y') }}</div>
                                    <div class="text-[11px] text-gray-400">{{ $p->created_at->format('g:i A') }}</div>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="font-extrabold text-gray-900">${{ number_format($p->amount, 2) }}</span>
                                </td>
                                <td class="px-5 py-3 text-gray-700">
                                    <div>{{ $p->bank_name }}</div>
                                    <div class="text-[11px] text-gray-400 font-mono">{{ $p->account_number }}</div>
                                </td>
                                <td class="px-5 py-3">
                                    @php $c = $p->statusColor(); @endphp
                                    <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold bg-{{ $c }}-50 text-{{ $c }}-700">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-xs text-gray-500 font-mono">
                                    {{ $p->transaction_reference ?? '—' }}
                                </td>
                                <td class="px-5 py-3 text-right">
                                    @if($p->isPending())
                                        <form method="POST" action="{{ route('seller.payouts.destroy', $p) }}" class="inline"
                                              data-confirm="Cancel this withdrawal request?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-xs text-rose-600 hover:text-rose-700 font-bold">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @if($p->admin_note || $p->seller_note)
                                <tr class="bg-gray-50/50">
                                    <td colspan="6" class="px-5 py-2 text-[11px]">
                                        @if($p->seller_note)
                                            <div class="text-gray-600"><span class="font-bold">Your note:</span> {{ $p->seller_note }}</div>
                                        @endif
                                        @if($p->admin_note)
                                            <div class="text-{{ $p->statusColor() }}-700 mt-1"><span class="font-bold">Admin:</span> {{ $p->admin_note }}</div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($history->hasPages())
                <div class="px-5 py-3 border-t border-gray-100">
                    {{ $history->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
