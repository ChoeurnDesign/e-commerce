@extends('layouts.admin')
@section('title', 'Products Management')

@section('content')
<!-- Header -->
<div class="flex justify-between items-center mb-6 flex-wrap gap-4">
    <div class="flex items-center">
        <span class="mr-2">
            <x-icon-dashboard name="products" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
        </span>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Products</h1>
    </div>
    <div class="flex space-x-4">
        @isset($importRoute)
            <a href="{{ $importRoute }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-6 h-6 text-white mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Import
            </a>
        @endisset
        @isset($createRoute)
            <a href="{{ $createRoute }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Product
            </a>
        @endisset
    </div>
</div>

{{-- Filter / Search Bar (only renders if $filterFields exist) --}}
@if(isset($filterFields) && is_array($filterFields))
    <x-admin.filter-bar :fields="$filterFields" :action="$filterAction ?? request()->url()" />
@endif

<!-- Products Table -->
<div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
            <thead>
                <tr class="bg-gray-300 dark:bg-[#232c47]">
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Category</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Added By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                @forelse($products as $product)
                    <tr class="hover:bg-gray-100 dark:hover:bg-[#262c47]">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @include('products.partials.image-unified', ['product' => $product])
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</div>
                                    <div class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">
                                        ID: {{ $product->id }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-100">
                            {{ $product->category->name ?? 'No Category' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap justify-center flex text-sm text-gray-800 dark:text-gray-100">
                            @if($product->creator)
                                <span class="flex items-center">
                                    <span class="inline-block px-2 py-1 rounded-full shadow text-xs font-semibold
                                        {{ $product->creator->role == 'admin' ? 'bg-blue-900 text-blue-200' :
                                           ($product->creator->role == 'seller' ? 'bg-yellow-500 text-white' : 'bg-gray-400 text-white') }}">
                                        {{ ucfirst($product->creator->role) }}
                                    </span>
                                    <span class="ml-2">{{ $product->creator->name }}</span>
                                </span>
                            @else
                                <span class="text-gray-400">Unknown</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-gray-100">${{ number_format($product->price, 2) }}</div>
                            @if($product->sale_price)
                                <div class="text-xs text-green-600 dark:text-green-400">Sale: ${{ number_format($product->sale_price, 2) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm {{ $product->stock_quantity > 10 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs rounded-full
                                  {{ $product->is_active ? 'bg-green-100 dark:bg-green-950 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-950 text-red-800 dark:text-red-300' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center space-x-3">
                                @isset($showRouteName)
                                    <x-admin.table-view-button :href="route($showRouteName, $product)" />
                                @endisset
                                @isset($editRouteName)
                                    <x-admin.table-edit-button :href="route($editRouteName, $product)" />
                                @endisset
                                @isset($deleteRouteName)
                                    <x-admin.table-delete-button :action="route($deleteRouteName, $product)" />
                                @endisset
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500 dark:text-gray-300">
                            No products found for the current filters.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
        {{ $products->links() }}
    </div>
</div>
@endsection
