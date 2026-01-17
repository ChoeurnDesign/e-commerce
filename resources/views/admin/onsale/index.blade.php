@extends('layouts.admin')

@section('title','Onsale Management')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="flex items-center mb-6">
        <span class="mr-2">
            <x-icon-dashboard name="onsale" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
        </span>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">On Sale</h1>
    </div>

    <x-admin.simple-search
        placeholder="ID / Name / SKU"
        hint="Search by product id, name or SKU"
        width="w-80"
        :autofocus="true"
        action="{{ route('admin.onsale.index') }}"
    >
        {{-- OPTIONAL extra filters (uncomment if you add query params)
        <div class="flex flex-col">
            <label class="text-xs font-medium mb-1 text-gray-600 dark:text-gray-300">Min % Off</label>
            <input type="number" min="1" max="95" name="discount_min"
                   value="{{ request('discount_min') }}"
                   class="w-24 border rounded px-2 py-2 text-sm bg-white dark:bg-[#1e2333] border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100">
        </div>
        --}}
    </x-admin.simple-search>

    @if($products->count())
        <div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-[#292e45]">
                    <thead>
                    <tr class="bg-gray-100 dark:bg-[#232c47]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Sale Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Compare Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Original Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">% Off</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-300 dark:hover:bg-[#262c47] transition">
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 text-indigo-700 dark:text-indigo-300">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 px-3 py-1 rounded-full font-bold text-sm">
                                    ${{ number_format($product->sale_price,2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full font-bold text-sm">
                                    ${{ number_format($product->compare_price,2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded-full font-bold text-sm">
                                    ${{ number_format($product->price,2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->discount_percent)
                                    <span class="inline-block bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 px-2 py-1 rounded-full text-xs font-semibold">
                                        -{{ $product->discount_percent }}%
                                    </span>
                                @else
                                    <span class="text-xs text-gray-500 dark:text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <x-admin.table-edit-button :href="route('admin.onsale.edit', $product)" />
                                    <form method="POST" action="{{ route('admin.products.removeFromSale', $product) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="">
                                        <button type="submit"
                                            class="px-2 py-1 text-xs rounded bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
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

