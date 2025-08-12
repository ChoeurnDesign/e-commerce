@extends('layouts.admin')

@section('title', 'Edit Order')

@section('content')
<div class="space-y-6 min-h-screen">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Order #{{ $order->id }}</h2>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#262c47] text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition duration-200">
            &larr; Back to Orders
        </a>
    </div>

    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-100 dark:border-[#23263a]">
        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Order Status</label>
                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-[#23263a] dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="pending" @selected(old('status', $order->status) == 'pending')>Pending</option>
                    <option value="completed" @selected(old('status', $order->status) == 'completed')>Completed</option>
                    <option value="cancelled" @selected(old('status', $order->status) == 'cancelled')>Cancelled</option>
                </select>
                @error('status')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Payment Status</label>
                <select name="payment_status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-[#23263a] dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="unpaid" @selected(old('payment_status', $order->payment_status) == 'unpaid')>Unpaid</option>
                    <option value="paid" @selected(old('payment_status', $order->payment_status) == 'paid')>Paid</option>
                </select>
                @error('payment_status')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Customer Email</label>
                <input type="email" name="email" value="{{ old('email', $order->user?->email ?? $order->email) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-[#23263a] dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" readonly>
            </div>

            <div class="pt-4 flex space-x-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg  transition duration-200">
                    Update Order
                </button>
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-400 dark:hover:bg-[#262c47] text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg  transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
