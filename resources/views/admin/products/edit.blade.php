@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-full mx-auto space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Product</h2>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#262c47] text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition duration-200">
            &larr; Back to Products
        </a>
    </div>

    <!-- Edit Form -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-100 dark:border-[#23263a]">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                    class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('name')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">SKU</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required
                    class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('sku')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Category</label>
                <select name="category_id" class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">No Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @if(old('category_id', $product->category_id) == $category->id) selected @endif>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Price ($)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                        class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('price')
                        <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center mt-6">
                    <input type="checkbox" name="on_sale" value="1" {{ old('on_sale', $product->on_sale) ? 'checked' : '' }}>
                    <label class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-200">On Sale?</label>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Sale Price ($)</label>
                    <input type="number" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0"
                        class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('sale_price')
                        <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Stock Quantity</label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" step="1" min="0" required
                    class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('stock_quantity')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Product Image</label>
                <input type="file" name="image" class="mt-1 block w-full text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:bg-[#23263a]">
                @if($product->image)
                    <img src="{{ asset('img/products/' . $product->image) }}"
                        class="h-24 w-24 mt-2 rounded object-cover border border-gray-300 dark:border-gray-600">
                @endif
                @error('image')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                <textarea name="description" rows="4"
                    class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Active</span>
                </label>
            </div>

            <div class="pt-4 flex space-x-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                    Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-400 dark:hover:bg-[#262c47] text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg font-semibold transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
