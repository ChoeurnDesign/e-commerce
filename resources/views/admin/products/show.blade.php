@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="max-w-full mx-auto space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Product Details</h2>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-50 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg transition duration-200">
            &larr; Back to Products
        </a>
    </div>

    <!-- Product Card -->
    @include('products.partials._details', ['product' => $product])

    <!-- Product Actions -->
    <div class="flex space-x-4">
        <a href="{{ route('admin.products.edit', $product) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg transition duration-200">Edit Product</a>
        <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button"
                    onclick="confirmDelete(event, this)"
                    data-confirm="This product will be permanently deleted."
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">
                Delete Product
            </button>
        </form>
    </div>
</div>
@endsection

