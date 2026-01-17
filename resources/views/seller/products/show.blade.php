@extends('layouts.seller')

@section('content')
<div class="max-w-full mx-auto space-y-8">

    <!-- Product Card -->
    @include('products.partials._details', [
        'title' => 'Product Details',
        'product' => $product,
    ])

    <!-- Product Actions -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('seller.products.edit', $product) }}"
           class="inline-flex items-center bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg transition duration-200">
            <x-icon-nav name="edit" class="w-4 h-4" />
            <span>Edit</span>
        </a>

        <form action="{{ route('seller.products.destroy', $product) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this product?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">
                <x-icon-nav name="delete" class="w-4 h-4" />
                <span>Delete</span>
            </button>
        </form>

        <a href="{{ route('seller.products.index') }}"
           class="inline-flex items-center gap-2 bg-gray-100 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#2c3250] text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg shadow-md transition">
            <x-icon-nav name="back" class="w-4 h-4" />
            <span>Back</span>
        </a>
    </div>
</div>
@endsection