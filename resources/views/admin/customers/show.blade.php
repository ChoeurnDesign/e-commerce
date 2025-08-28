@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-12 bg-white dark:bg-[#23263a] rounded-xl shadow-lg border border-gray-300 dark:border-[#23263a] p-8">
    <div class="flex items-center mb-8">
        @if($customer->profile_image)
            <img src="{{ asset('storage/'.$customer->profile_image) }}" alt="Avatar" class="w-20 h-20 rounded-full shadow-lg border-4 border-indigo-300 dark:border-indigo-700">
        @else
            <div class="w-20 h-20 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-4xl text-gray-500 dark:text-gray-300 font-bold shadow-lg border-4 border-gray-200 dark:border-gray-700">
                {{ strtoupper(substr($customer->name, 0, 1)) }}
            </div>
        @endif
        <div class="ml-6">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $customer->name }}</h2>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                {{ $customer->role === 'admin' ? 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300' : 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300' }}">
                {{ ucfirst($customer->role) }}
            </span>
            @if(now()->diffInDays($customer->created_at) < 7)
                <span class="ml-2 px-2 py-0.5 rounded-full text-xs bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 font-bold animate-pulse">New</span>
            @endif
            <div class="mt-2 text-gray-600 dark:text-gray-300 text-sm">
                Joined: <span class="font-medium">{{ $customer->created_at->format('F d, Y') }}</span>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Contact Information</h3>
                <div class="flex items-center mb-1">
                    <x-icon-nav name="user"/>
                    <span class="text-gray-700 dark:text-gray-300">{{ $customer->email }}</span>
                </div>
                @if($customer->phone)
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500 dark:text-green-300" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M3 5a2 2 0 012-2h3.28a2 2 0 011.95 1.45l1.13 4.53a2 2 0 01-.45 1.95l-2.27 2.27a16.06 16.06 0 006.36 6.36l2.27-2.27a2 2 0 011.95-.45l4.53 1.13A2 2 0 0121 18.72V22a2 2 0 01-2 2h-1A19 19 0 013 5v-1z"/>
                    </svg>
                    <span class="text-gray-700 dark:text-gray-300">{{ $customer->phone }}</span>
                </div>
                @endif
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Account Status</h3>
                <div class="flex items-center">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $customer->email_verified_at ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-300' }}">
                        {{ $customer->email_verified_at ? 'Email Verified' : 'Email Not Verified' }}
                    </span>
                </div>
            </div>
        </div>
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">Other Information</h3>
            <ul class="text-gray-700 dark:text-gray-300 space-y-2">
                <li>
                    <span class="font-medium">User ID:</span> {{ $customer->id }}
                </li>
                <li>
                    <span class="font-medium">Registered At:</span> {{ $customer->created_at->format('Y-m-d H:i') }}
                </li>
                <li>
                    <span class="font-medium">Last Updated:</span> {{ $customer->updated_at->format('Y-m-d H:i') }}
                </li>
                @if($customer->address)
                <li>
                    <span class="font-medium">Address:</span> {{ $customer->address }}
                </li>
                @endif
                {{-- Add more fields as needed --}}
            </ul>
        </div>
    </div>
    <div class="mt-10 flex justify-end">
        <a href="{{ route('admin.customers.index') }}" class="px-5 py-2 rounded bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            Back to Customers
        </a>
    </div>
</div>
@endsection
