@php
    $products = $products ?? collect();
@endphp

<div class="mb-8">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Seller Products</h3>
    @if($products->count())
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Created At</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 text-gray-900 font-semibold">#{{ $product->id }}</td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $product->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($product->is_active)
                                    <span class="inline-block px-2 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-1 rounded-full text-xs bg-red-100 text-red-700">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $product->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.products.show', $product->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs rounded transition"
                                   title="View Product"
                                   target="_blank">
                                   View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-gray-500 text-center py-8">No products found for this seller.</div>
    @endif
</div>