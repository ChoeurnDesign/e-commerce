@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')
<div class="p-4 md:p-6 w-full">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Customer #{{ $customer->id }} Details</h2>
        <a href="{{ route('admin.customers.index') }}" class="text-sm bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition">
            &larr; Back to Customers
        </a>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        {{-- Profile Header --}}
        <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row items-center gap-6">
            @if($customer->profile_image)
                <img src="{{ asset('storage/'.$customer->profile_image) }}" alt="Avatar" class="w-24 h-24 rounded-full shadow-md border-4 border-gray-100">
            @else
                <div class="w-24 h-24 rounded-full bg-indigo-100 flex items-center justify-center text-3xl text-indigo-600 font-bold border-4 border-gray-100">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
            @endif
            
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h2>
                <div class="flex items-center gap-3 mt-2">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                        {{ $customer->role === 'admin' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                        {{ ucfirst($customer->role) }}
                    </span>
                    @if(now()->diffInDays($customer->created_at) < 7)
                        <span class="px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-700 font-bold animate-pulse">New</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Details Grid --}}
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-sm font-semibold uppercase text-gray-400 mb-4">Contact Information</h3>
                <div class="space-y-4 text-gray-700">
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
                            {{ $customer->email_verified_at ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $customer->email_verified_at ? 'Email Verified' : 'Email Not Verified' }}
                        </span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold uppercase text-gray-400 mb-4">System Information</h3>
                <div class="space-y-4 text-gray-700">
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