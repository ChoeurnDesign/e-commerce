@extends('layouts.admin')

@section('content')

<div class="space-y-6 min-h-screen">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Edit On Sale Product</h2>
    <div class="max-w-full mx-auto bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-100 dark:border-gray-600 mt-10">

        <form action="{{ route('admin.onsale.update', ['product' => $product->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <x-input-label value="Product Name" />
                <div class="mt-1 block w-full bg-gray-100 dark:bg-[#23263a] px-4 py-2 text-gray-900 dark:text-gray-100">{{ $product->name }}</div>
            </div>
            <!-- Original Price (readonly) -->
            <div class="mb-4">
                <x-input-label value="Original Price ($)" />
                <x-text-input type="number" :value="$product->price" readonly
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-[#23263a] text-gray-900 dark:text-gray-100 shadow-sm" />
            </div>
            <div class="mb-4">
                <x-input-label value="On Sale?" />
                <input type="checkbox" name="on_sale" value="1" {{ old('on_sale', $product->on_sale) ? 'checked' : '' }}>
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Yes</span>
            </div>
            <div class="mb-4">
                <x-input-label for="sale_price" value="Sale Price ($)" />
                <x-text-input type="number" name="sale_price" id="sale_price" :value="old('sale_price', $product->sale_price)" step="0.01" min="0"
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('sale_price')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <x-input-label for="compare_price" value="Compare Price ($)" />
                <x-text-input type="number" name="compare_price" id="compare_price" :value="old('compare_price', $product->compare_price)" step="0.01" min="0"
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('compare_price')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="pt-4 flex space-x-4">
                <x-admin.form-submit-button :action="route('admin.onsale.update', $product->id)">Update On Sale Product</x-admin.form-submit-button>
                <x-admin.form-cancel-button :href="route('admin.onsale.index')">Cancel</x-admin.form-cancel-button>
            </div>
        </form>
    </div>
</div>
@endsection
