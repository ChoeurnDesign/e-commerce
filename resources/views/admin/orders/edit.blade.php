@extends('layouts.admin')

@section('content')

<div class="space-y-6 min-h-screen">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit Order #{{ $order->id }}</h2>
    
    <div class="max-w-full mx-auto bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-100 dark:border-gray-600 mt-10">

        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Customer Information (Read Only) --}}
            <div class="mb-4">
                <x-input-label value="Customer Name" />
                <div class="mt-1 block w-full bg-gray-100 dark:bg-[#23263a] px-4 py-2 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-md">
                    {{ $order->user?->name ?? 'Guest' }}
                </div>
            </div>

            <div class="mb-4">
                <x-input-label value="Customer Email" />
                <div class="mt-1 block w-full bg-gray-100 dark:bg-[#23263a] px-4 py-2 text-gray-900 dark:text-gray-100 border border-gray-300 dark:border-gray-600 rounded-md">
                    {{ $order->user?->email ?? $order->email }}
                </div>
            </div>

            {{-- Order Status --}}
            <div class="mb-4">
                <x-input-label for="status" value="Order Status" />
                <select name="status" id="status" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md">
                    @foreach(['pending', 'processing', 'confirmed', 'shipped', 'delivered', 'completed', 'cancelled'] as $status)
                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Payment Status --}}
            <div class="mb-4">
                <x-input-label for="payment_status" value="Payment Status" />
                <select name="payment_status" id="payment_status" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 rounded-md">
                    @foreach(['pending', 'paid', 'failed', 'refunded'] as $status)
                        <option value="{{ $status }}" {{ $order->payment_status === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('payment_status')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex space-x-4">
                <x-admin.form-submit-button :action="route('admin.orders.update', $order->id)">Update Order</x-admin.form-submit-button>
                <x-admin.form-cancel-button :href="route('admin.orders.index')">Cancel</x-admin.form-cancel-button>
            </div>
        </form>
    </div>
</div>
@endsection