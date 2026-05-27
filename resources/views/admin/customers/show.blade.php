@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')
<div class="p-4 md:p-6 w-full">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Customer #{{ $customer->id }} Details</h2>
        <a href="{{ route('admin.customers.index') }}" class="text-sm bg-white dark:bg-[#23263a] border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-[#2c324a] transition">
            &larr; Back to Customers
        </a>
    </div>

    {{-- Main Card --}}
    <div class="bg-white dark:bg-[#23263a] rounded-xl shadow-sm border border-gray-200 dark:border-[#23263a] overflow-hidden">
        
        {{-- Profile Header --}}
        <div class="p-6 border-b border-gray-100 dark:border-[#181f31] flex flex-col sm:flex-row items-center gap-6">
            @if($customer->profile_image)
                <img src="{{ asset('storage/'.$customer->profile_image) }}" alt="Avatar" class="w-24 h-24 rounded-full shadow-md border-4 border-gray-100 dark:border-[#181f31]">
            @else
                <div class="w-24 h-24 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-3xl text-indigo-600 dark:text-indigo-300 font-bold border-4 border-gray-100 dark:border-[#181f31]">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
            @endif
            
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $customer->name }}</h2>
                <div class="flex items-center gap-3 mt-2">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                        {{ $customer->role === 'admin' ? 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300' : 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300' }}">
                        {{ ucfirst($customer->role) }}
                    </span>
                    @if(now()->diffInDays($customer->created_at) < 7)
                        <span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 font-bold animate-pulse">New</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Details Grid --}}
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-sm font-semibold uppercase text-gray-400 dark:text-gray-500 mb-4">Contact Information</h3>
                <div class="space-y-4 text-gray-700 dark:text-gray-200">
                    <div>
                        <span class="block text-xs text-gray-500">Email Address</span>
                        <span class="font-medium">{{ $customer->email }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Phone Number</span>
                        <span class="font-medium">{{ $customer->phone ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Verification Status</span>
                        <span class="inline-block px-2 py-0.5 rounded text-xs font-medium mt-1
                            {{ $customer->email_verified_at ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300' }}">
                            {{ $customer->email_verified_at ? 'Email Verified' : 'Email Not Verified' }}
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase text-gray-400 dark:text-gray-500 mb-4">System Information</h3>
                <div class="space-y-4 text-gray-700 dark:text-gray-200">
                    <div>
                        <span class="block text-xs text-gray-500">User ID</span>
                        <span class="font-medium">#{{ $customer->id }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Registered Date</span>
                        <span class="font-medium">{{ $customer->created_at->format('Y-m-d H:i') }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-500">Last Updated</span>
                        <span class="font-medium">{{ $customer->updated_at->format('Y-m-d H:i') }}</span>
                    </div>
                    @if($customer->address)
                    <div>
                        <span class="block text-xs text-gray-500">Address</span>
                        <span class="font-medium">{{ $customer->address }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection