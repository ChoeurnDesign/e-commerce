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

        <form action="{{ route('seller.products.destroy', $product) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="button"
                    onclick="confirmDelete(event, this)"
                    data-confirm="This product will be permanently deleted."
                    class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">
                <x-icon-nav name="delete" class="w-4 h-4" />
                <span>Delete</span>
            </button>
        </form>

        <a href="{{ route('seller.products.index') }}"
           class="inline-flex items-center gap-2 bg-white hover:bg-pink-50 text-gray-600 border border-pink-100 px-4 py-2 rounded-lg shadow-sm transition">
            <x-icon-nav name="back" class="w-4 h-4" />
            <span>Back</span>
        </a>
    </div>
</div>
@endsection