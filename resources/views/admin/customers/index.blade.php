@extends('layouts.admin')

@section('title', 'Customers Management')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <span class="mr-2">
            <x-icon-dashboard name="customers" class="w-7 h-7 text-indigo-600"/>
        </span>
        <h1 class="text-2xl font-bold text-gray-900">Customers</h1>
    </div>

    {{-- Simple Search --}}
    <x-admin.simple-search
        placeholder="ID / Name / Email"
        hint="Search by user id, name or email"
        width="w-80"
        />

    {{-- 2. Ensure pagination links are rendered --}}
    <div class="px-6 py-4 border-t">
        {{ $customers->links() }}
    </div>

    <div class="bg-white shadow-sm overflow-hidden border border-gray-100 rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Profile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
    @forelse($customers as $customer)
        <tr class="hover:bg-gray-50 transition-colors duration-150">
            {{-- SHOW ACTUAL CUSTOMER ID, NOT ROW NUMBER --}}
            <td class="px-6 py-4 text-gray-900 font-medium">
                {{ $customer->id }}
            </td>
            <td class="px-6 py-4">
                @if($customer->profile_image)
                    <div class="w-10 h-10 rounded-full overflow-hidden shadow border-2 border-gray-200 bg-gray-100 flex items-center justify-center">
                        <img src="{{ asset('storage/'.$customer->profile_image) }}"
                             alt="Avatar"
                             class="w-full h-full object-cover object-center" />
                    </div>
                @else
                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-semibold shadow border border-gray-300">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                @endif
            </td>
            <td class="px-6 py-4 font-semibold text-gray-900">
                <div class="flex items-center">
                    {{ $customer->name }}
                    @if(now()->diffInDays($customer->created_at) < 7)
                        <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700 animate-pulse">
                            New
                        </span>
                    @endif
                </div>
            </td>
            <td class="px-6 py-4 text-gray-700">{{ $customer->email }}</td>
            <td class="px-6 py-4">
                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                    {{ $customer->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                    {{ ucfirst($customer->role) }}
                </span>
            </td>
            <td class="px-6 py-4">
                <span class="{{ now()->diffInDays($customer->created_at) < 7 ? 'text-blue-700 font-medium' : 'text-gray-600' }}">
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
            <td colspan="7" class="py-12 text-center text-gray-500 text-lg">
                No customers found.
            </td>
        </tr>
    @endforelse
</tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-white">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection 