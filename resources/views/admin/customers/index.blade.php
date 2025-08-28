@extends('layouts.admin')

@section('title', 'Customers Management')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <span class="mr-2">
            <x-icon-dashboard name="customers" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
        </span>
        <h1 class="text-2xl text-gray-900 dark:text-gray-100">Customers</h1>
    </div>

    {{-- Simple Search --}}
    <x-admin.simple-search
        placeholder="ID / Name / Email"
        hint="Search by user id, name or email"
        width="w-80"
        :autofocus="true"
    />

    <!-- Customers Table -->
    <div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead>
                    <tr class="bg-gray-300 dark:bg-[#232c47]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Profile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Joined</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-300 dark:hover:bg-[#262c47]">
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4">
                                @if($customer->profile_image)
                                    <div class="w-10 h-10 rounded-full overflow-hidden shadow border-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        <img src="{{ asset('storage/'.$customer->profile_image) }}"
                                             alt="Avatar"
                                             class="w-full h-full object-cover object-center" />
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-300">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                {{ $customer->name }}
                                @if(now()->diffInDays($customer->created_at) < 7)
                                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 animate-pulse">
                                        New
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-200">{{ $customer->email }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $customer->role === 'admin' ? 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' : 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300' }}">
                                    {{ ucfirst($customer->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="{{ now()->diffInDays($customer->created_at) < 7 ? 'text-blue-700 dark:text-blue-300' : 'text-gray-600 dark:text-gray-300' }}">
                                    {{ $customer->created_at->format('Y-m-d') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <x-admin.table-view-button :href="route('admin.customers.show', $customer->id)" />
                                    <x-admin.table-edit-button :href="route('admin.customers.edit', $customer->id)" />
                                    <x-admin.table-delete-button :action="route('admin.customers.destroy', $customer->id)" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500 dark:text-gray-300 text-lg">
                                No customers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
