@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="max-w-full mx-auto space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Product Details</h2>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#262c47] text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition duration-200">
            &larr; Back to Products
        </a>
    </div>

    <!-- Product Card -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 flex flex-col md:flex-row gap-6 border border-gray-100 dark:border-[#23263a]">
        <img class="h-40 w-auto rounded-lg object-cover border border-gray-100 dark:border-[#23263a]" src="{{ $product->image ? asset('img/products/' . $product->image) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name) }}" alt="{{ $product->name }}">
        <div class="flex-1 space-y-3">
            <h3 class="text-xl  text-gray-900 dark:text-gray-100">{{ $product->name }}</h3>
            <div class="text-sm text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-200">Category:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $product->category->name ?? 'No Category' }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-200">Price:</span>
                <span class="text-gray-900 dark:text-gray-100">${{ number_format($product->price, 2) }}</span>
                @if($product->sale_price)
                    <span class="ml-3 font-medium text-green-600 dark:text-green-400">Sale: ${{ number_format($product->sale_price, 2) }}</span>
                @endif
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-200">Stock:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $product->stock_quantity }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-200">Status:</span>
                <span class="inline-flex px-2 py-1 text-xs  rounded-full {{ $product->is_active ? 'bg-green-100 dark:bg-green-950 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-950 text-red-800 dark:text-red-300' }}">
                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-200">Description:</span>
                <span class="text-gray-800 dark:text-gray-200 ml-1">
                    {!! nl2br(e($product->description)) !!}
                </span>
            </div>
        </div>
    </div>

    <!-- Product Actions -->
    <div class="flex space-x-4">
        <a href="{{ route('admin.products.edit', $product) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg transition duration-200">Edit Product</a>
        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">Delete Product</button>
        </form>
    </div>
</div>
@endsection
