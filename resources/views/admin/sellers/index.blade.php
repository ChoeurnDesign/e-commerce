@extends('layouts.admin')
@section('title', 'Sellers Management')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <x-icon-dashboard name="users" class="w-7 h-7 text-indigo-600"/>
        <h1 class="ml-2 text-2xl font-bold text-gray-900">Sellers</h1>
    </div>
    @include('admin.sellers.partials.filters')
    @includeWhen(isset($stats), 'admin.sellers.partials.statistics', ['stats' => $stats])

    <div class="bg-white shadow-sm overflow-hidden border border-gray-100 rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    {{-- Fixed: Changed harsh bg-gray-50 to clean bg-gray-100 for light mode --}}
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Seller</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Store</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applied At</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($sellers as $seller)
                        {{-- Fixed: Changed harsh hover:bg-gray-200 to smooth hover:bg-gray-50 for light mode --}}
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 text-gray-900 font-semibold">#{{ $seller->id }}</td>
                            <td class="px-6 py-4 text-gray-700 font-medium">{{ $seller->user?->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $seller->user?->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $seller->store_name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <x-status-badge :status="$seller->status"/>
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $seller->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @include('admin.sellers.partials.actions', ['seller' => $seller, 'compact' => true])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500 text-lg">
                                No sellers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-white">
            {{ $sellers->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection