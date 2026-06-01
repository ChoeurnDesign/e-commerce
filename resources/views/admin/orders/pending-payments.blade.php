@extends('layouts.admin')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900">Pending Payment Verifications</h1>
            <p class="text-sm text-gray-500 mt-1">
                Review bank transfer receipts uploaded by customers. Verify or reject each one.
            </p>
        </div>
        <a href="{{ route('admin.orders.index') }}"
           class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50">
            ← All Orders
        </a>
    </div>

    @if($orders->total() === 0)
        <div class="bg-white rounded-2xl border border-gray-100 py-16 text-center">
            <div class="w-16 h-16 mx-auto bg-emerald-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800">All caught up!</h3>
            <p class="text-sm text-gray-500 mt-1">No bank transfers waiting for verification.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-0">

                        {{-- Receipt image (left) --}}
                        <div class="lg:col-span-4 bg-gray-50 p-4 border-r border-gray-100">
                            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-2">Receipt Upload</p>
                            @if($order->payment_proof)
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank"
                                   class="block relative rounded-xl overflow-hidden border border-gray-200 hover:border-pink-400 transition-colors group">
                                    <img src="{{ asset('storage/' . $order->payment_proof) }}"
                                         alt="Receipt for order #{{ $order->order_number }}"
                                         class="w-full h-auto max-h-72 object-contain bg-white">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                                        <span class="opacity-0 group-hover:opacity-100 text-white text-xs font-bold bg-black/60 px-3 py-1.5 rounded-full">
                                            🔍 Open Full Size
                                        </span>
                                    </div>
                                </a>
                            @else
                                <div class="rounded-xl border border-dashed border-gray-300 p-8 text-center text-gray-400 text-sm">
                                    No receipt uploaded
                                </div>
                            @endif

                            @if($order->payment_reference)
                                <div class="mt-3 bg-white rounded-lg border border-gray-200 p-3">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">Customer note / reference</p>
                                    <p class="text-sm text-gray-700 mt-1 break-words">{{ $order->payment_reference }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- Order details (middle) --}}
                        <div class="lg:col-span-5 p-5">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="font-extrabold text-gray-900">
                                        Order #{{ $order->order_number }}
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $order->created_at->diffForHumans() }} · {{ $order->created_at->format('M j, Y g:i A') }}</p>
                                </div>
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold rounded-full">
                                    Awaiting Verification
                                </span>
                            </div>

                            <dl class="space-y-2 text-sm">
                                <div class="flex justify-between gap-2">
                                    <dt class="text-gray-500">Customer</dt>
                                    <dd class="font-semibold text-gray-800 text-right">{{ $order->customer_name }}</dd>
                                </div>
                                <div class="flex justify-between gap-2">
                                    <dt class="text-gray-500">Email</dt>
                                    <dd class="text-gray-700 text-right">{{ $order->customer_email }}</dd>
                                </div>
                                @if($order->customer_phone)
                                <div class="flex justify-between gap-2">
                                    <dt class="text-gray-500">Phone</dt>
                                    <dd class="text-gray-700 text-right">{{ $order->customer_phone }}</dd>
                                </div>
                                @endif
                                <div class="flex justify-between gap-2 pt-2 border-t border-gray-100">
                                    <dt class="text-gray-500">Items</dt>
                                    <dd class="text-gray-700 text-right">{{ $order->orderItems->count() ?? '—' }}</dd>
                                </div>
                                <div class="flex justify-between gap-2">
                                    <dt class="text-gray-500">Subtotal</dt>
                                    <dd class="text-gray-700 text-right">${{ number_format($order->subtotal, 2) }}</dd>
                                </div>
                                <div class="flex justify-between gap-2 pt-2 border-t border-gray-100">
                                    <dt class="font-bold text-gray-900">Amount to verify</dt>
                                    <dd class="font-extrabold text-rose-600 text-base text-right">
                                        ${{ number_format($order->total_price, 2) }}
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        {{-- Actions (right) --}}
                        <div class="lg:col-span-3 p-5 bg-gray-50/50 border-l border-gray-100 flex flex-col gap-3">
                            <div>
                                <p class="text-xs font-bold text-gray-700 mb-2">Quick checklist:</p>
                                <ul class="text-[11px] text-gray-500 space-y-1">
                                    <li>✓ Amount matches order total</li>
                                    <li>✓ Bank reference looks valid</li>
                                    <li>✓ Receipt clear and unedited</li>
                                </ul>
                            </div>

                            <form method="POST" action="{{ route('admin.payments.verify', $order) }}"
                                  data-confirm="Approve this payment? Order will move to processing.">
                                @csrf
                                <button type="submit"
                                        class="w-full px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-sm font-bold transition-colors flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Verify Payment
                                </button>
                            </form>

                            <form method="POST" action="{{ route('admin.payments.reject', $order) }}"
                                  data-confirm="Reject this payment? Order will be cancelled."
                                  data-confirm-type="error">
                                @csrf
                                <input type="text" name="note" placeholder="Rejection reason (optional)"
                                       class="w-full mb-2 px-3 py-1.5 border border-gray-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-rose-200 focus:border-rose-400">
                                <button type="submit"
                                        class="w-full px-4 py-2 bg-white border border-rose-200 text-rose-600 hover:bg-rose-50 rounded-lg text-sm font-semibold transition-colors flex items-center justify-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Reject
                                </button>
                            </form>

                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="block text-center px-4 py-1.5 text-xs text-gray-500 hover:text-pink-600 font-medium transition-colors">
                                View Full Order →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
