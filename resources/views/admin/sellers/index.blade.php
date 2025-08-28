@extends('layouts.admin')
@section('title', 'Sellers Management')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <x-icon-dashboard name="users" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
        <h1 class="ml-2 text-2xl font-bold text-gray-900 dark:text-gray-100">Sellers</h1>
    </div>
    @include('admin.sellers.partials.filters')
    @includeWhen(isset($stats), 'admin.sellers.partials.statistics', ['stats' => $stats])

    <!-- Sellers Table -->
    <div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead>
                    <tr class="bg-gray-300 dark:bg-[#232c47]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Seller</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Store</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Applied At</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                    @forelse($sellers as $seller)
                        <tr class="hover:bg-gray-200 dark:hover:bg-[#262c47]">
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-semibold">#{{ $seller->id }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-200">{{ $seller->user?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-200">{{ $seller->user?->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-200">{{ $seller->store_name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <x-status-badge :status="$seller->status"/>
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-200">{{ $seller->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @include('admin.sellers.partials.actions', ['seller' => $seller, 'compact' => true])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-gray-500 dark:text-gray-300 text-lg">
                                No sellers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
            {{ $sellers->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
