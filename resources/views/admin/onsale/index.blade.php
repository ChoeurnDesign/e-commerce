@extends('layouts.admin')

@section('title', 'Products On Sale')

@section('content')
<div class="bg-[#202337] rounded-2xl shadow-lg p-8 border border-[#23263a] max-w-full mx-auto">
    <h3 class="text-2xl font-bold text-white mb-8">Products On Sale</h3>
    @if($products->count())
        <div class="overflow-x-auto">
            <table class="min-w-full rounded-xl overflow-hidden border-separate border-spacing-y-2">
                <thead>
                    <tr class="bg-[#292d40]">
                        <th class="px-5 py-4 text-left text-base font-semibold text-gray-300">#</th>
                        <th class="px-5 py-4 text-left text-base font-semibold text-gray-300">Name</th>
                        <th class="px-5 py-4 text-left text-base font-semibold text-gray-300">Sale Price</th>
                        <th class="px-5 py-4 text-left text-base font-semibold text-gray-300">Compare Price</th>
                        <th class="px-5 py-4 text-left text-base font-semibold text-gray-300">Original Price</th>
                        <th class="px-5 py-4 text-left text-base font-semibold text-gray-300">Status</th>
                        <th class="px-5 py-4 text-center text-base font-semibold text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="bg-[#23263a] hover:bg-[#262941] transition-all duration-150 rounded-lg shadow-sm">
                        <td class="px-5 py-4 text-white">{{ $loop->iteration }}</td>
                        <td class="px-5 py-4 text-white font-semibold">{{ $product->name }}</td>
                        <td class="px-5 py-4 text-white">
                            ${{ number_format($product->sale_price, 2) }}
                        </td>
                        <td class="px-5 py-4 text-white">
                            ${{ number_format($product->compare_price, 2) }}
                        </td>
                        <td class="px-5 py-4 text-white">
                            ${{ number_format($product->price, 2) }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center px-4 py-1 rounded-full bg-green-900 text-green-300 font-semibold text-sm shadow">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                On Sale
                            </span>
                        </td>
                        <td class="px-5 py-4 text-center">
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('admin.onsale.edit', ['product' => $product->id]) }}"
                                   class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-950 text-blue-400 hover:bg-blue-900 hover:text-blue-200 transition font-semibold text-sm shadow group">
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
                                        class="inline-flex items-center px-3 py-1 rounded-lg bg-red-950 text-red-400 hover:bg-red-900 hover:text-red-200 transition font-semibold text-sm shadow group ml-2">
                                        <svg class="h-4 w-4 mr-1 group-hover:text-red-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M6 18L18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                        Remove from Sale
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
@endsection
