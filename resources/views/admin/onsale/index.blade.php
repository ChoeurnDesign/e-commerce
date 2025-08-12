@extends('layouts.admin')

@section('title', 'Products On Sale')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="max-w-full mx-auto space-y-8">
        <!-- Header -->
        <div class="flex items-center mb-6">
            <span class="mr-2">
                <x-icon-dashboard name="onsale" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
            </span>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">On Sale</h1>
        </div>

        @if($products->count())
        <div class="bg-white dark:bg-[#23263a] rounded-xl shadow-lg border border-gray-200 dark:border-[#23263a] overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#292e45]">
                <thead>
                    <tr class="bg-gray-100 dark:bg-[#232c47]">
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">Sale Price</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">Compare Price</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">Original Price</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-200">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="bg-white dark:bg-[#23263a] hover:bg-indigo-50 dark:hover:bg-[#2a3350] transition rounded-xl shadow-sm">
                        <td class="px-6 py-4 text-gray-900 dark:text-gray-100 font-semibold">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 text-indigo-700 dark:text-indigo-300 font-semibold">
                            {{ $product->name }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-300 px-3 py-1 rounded font-bold text-sm shadow">
                                ${{ number_format($product->sale_price, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded font-bold text-sm shadow">
                                ${{ number_format($product->compare_price, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-3 py-1 rounded font-bold text-sm shadow">
                                ${{ number_format($product->price, 2) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-4 py-1 rounded-full bg-green-900 text-green-300 font-semibold text-sm shadow">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                On Sale
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.onsale.edit', ['product' => $product->id]) }}"
                                   class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-950 text-blue-400 hover:bg-blue-900 hover:text-blue-200 transition font-semibold text-xs shadow group">
                                    <svg class="h-4 w-4 mr-1 group-hover:text-blue-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M15.232 5.232l3.536 3.536M9 13l6.364-6.364a2 2 0 112.828 2.828L11.828 15.828a2 2 0 01-2.828 0L9 13z"></path>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.removeFromSale', $product->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Are you sure you want to remove this product from sale?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1 rounded-lg bg-red-950 text-red-400 hover:bg-red-900 hover:text-red-200 transition font-semibold text-xs shadow group">
                                        <svg class="h-4 w-4 mr-1 group-hover:text-red-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
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
        @else
        <div class="flex flex-col items-center justify-center h-48 bg-[#23263a] rounded-xl shadow mt-4">
            <x-icon-dashboard name="tag" class="h-10 w-10 text-gray-400 mb-2" />
            <p class="text-gray-400 text-lg font-medium">No products on sale.</p>
        </div>
        @endif
    </div>
</div>
@endsection
