@extends('layouts.admin')

@section('content')

<div class="space-y-6 min-h-screen">
    <h2 class="text-2xl font-bold mb-6 text-gray-900">Edit On Sale Product</h2>
    <div class="max-w-full mx-auto bg-white rounded-2xl shadow-sm p-6 border border-gray-100 mt-10">

        <form action="{{ route('admin.onsale.update', ['product' => $product->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <x-input-label value="Product ID" />
                <div class="mt-1 block w-full bg-gray-100 px-4 py-2 text-gray-600 border border-gray-300 rounded">
                    #{{ $product->id }}
                </div>
            </div>

            <div class="mb-4">
                <x-input-label value="Product Name" />
                <div class="mt-1 block w-full bg-gray-100 px-4 py-2 text-gray-900 border border-gray-300 rounded">
                    {{ $product->name }}
                </div>
            </div>

            <div class="mb-4">
                <x-input-label value="Original Price ($)" />
                <x-text-input type="number" :value="$product->price" readonly
                    class="mt-1 block w-full border border-gray-300 bg-gray-100 text-gray-900 shadow-sm" />
            </div>

            <div class="mb-4">
                <x-input-label value="On Sale?" />
                <label class="flex items-center mt-2">
                    <input type="checkbox" name="on_sale" value="1" {{ old('on_sale', $product->on_sale) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Yes, this product is on sale</span>
                </label>
            </div>

            <div class="mb-4">
                <x-input-label for="sale_price" value="Sale Price ($)" />
                <x-text-input type="number" name="sale_price" id="sale_price" :value="old('sale_price', $product->sale_price)" step="0.01" min="0"
                    class="mt-1 block w-full border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('sale_price')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <x-input-label for="compare_price" value="Compare Price ($)" />
                <x-text-input type="number" name="compare_price" id="compare_price" :value="old('compare_price', $product->compare_price)" step="0.01" min="0"
                    class="mt-1 block w-full border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('compare_price')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
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