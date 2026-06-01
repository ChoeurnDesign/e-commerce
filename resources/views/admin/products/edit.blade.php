@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-full mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Edit Product</h2>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-50 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg transition duration-200">
            &larr; Back to Products
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        @include('products.partials._form', [
            'title' => 'Edit Product',  // ← ADD THIS LINE
            'formAction' => route('admin.products.update', $product),
            'formMethod' => 'PUT',
            'categories' => $categories,
            'product' => $product,
            'submitText' => 'Update Product',
            'cancelUrl' => route('admin.products.index'),
        ])
    </div>
</div>
@endsection