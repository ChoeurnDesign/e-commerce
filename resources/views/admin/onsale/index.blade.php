@extends('layouts.admin')

@section('title','Onsale Management')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="flex items-center mb-6">
        <span class="mr-2">
            <x-icon-nav name="onsale" class="w-7 h-7 text-indigo-600"/>
        </span>
        <h1 class="text-2xl font-bold text-gray-900">On Sale</h1>
    </div>

    <x-admin.simple-search
        placeholder="ID / Name / SKU"
        hint="Search by product id, name or SKU"
        width="w-80"
        :autofocus="true"
        action="{{ route('admin.onsale.index') }}"
    >
    </x-admin.simple-search>

    @if($products->count())
        <div class="bg-white shadow-sm overflow-hidden border border-gray-100 rounded-2xl">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sale Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Compare Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Original Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">% Off</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-900">
                                {{ $product->id }}
                            </td>
                            <td class="px-6 py-4 text-indigo-700">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full font-bold text-sm">
                                    ${{ number_format($product->sale_price, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-bold text-sm">
                                    ${{ number_format($product->compare_price, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full font-bold text-sm">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->discount_percent)
                                    <span class="inline-block bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">
                                        -{{ $product->discount_percent }}%
                                    </span>
                                @else
                                    <span class="text-xs text-gray-500">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Edit Button --}}
                                    <x-admin.table-edit-button :href="route('admin.onsale.edit', $product)" />
                                    
                                    {{-- Remove Button --}}
                                    <x-admin.table-delete-button 
                                        :action="route('admin.products.removeFromSale', $product)" 
                                        method="PATCH" 
                                        title="Remove" 
                                        confirm="Are you sure you want to remove this from sale?" 
                                    />
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-white">
                {{ $products->links() }}
            </div>
        </div>
    @else
        <div class="flex flex-col items-center justify-center h-48 bg-[#23263a] rounded-lg shadow mt-4">
            <x-icon-dashboard name="tag" class="h-10 w-10 text-gray-400 mb-2" />
            <p class="text-gray-400 text-lg font-medium">No products on sale.</p>
        </div>
    @endif
</div>
@endsection