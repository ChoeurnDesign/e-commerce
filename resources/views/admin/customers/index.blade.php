@extends('layouts.admin')

@section('content')
<div class="p-6 bg-gray-300 dark:bg-[#181f31] min-h-screen">
    <div class="mb-6 flex items-center">
        <span class="mr-2">
            <x-icon-dashboard name="customers" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
        </span>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Customers</h1>
    </div>
    <div class="bg-white dark:bg-[#23263a] shadow rounded-lg border-2 border-gray-300 dark:border-[#23263a] overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
            <thead class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider rounded-tl-lg">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Profile</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider rounded-tr-lg">Joined</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-100 dark:divide-[#23263a]">
                @foreach($customers as $customer)
                <tr class="hover:bg-blue-50 dark:hover:bg-[#23263a] transition">
                    <td class="px-6 py-4 text-gray-900 dark:text-gray-100">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        @if($customer->profile_image)
                            <img src="{{ asset('storage/'.$customer->profile_image) }}" alt="Avatar" class="w-10 h-10 rounded-full shadow">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-300 font-bold">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">{{ $customer->name }}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $customer->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $customer->role === 'admin' ? 'bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300' : 'bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300' }}">
                            {{ ucfirst($customer->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="{{ now()->diffInDays($customer->created_at) < 7 ? 'text-blue-700 dark:text-blue-300 font-bold' : 'text-gray-600 dark:text-gray-300' }}">
                            {{ $customer->created_at->format('Y-m-d') }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
