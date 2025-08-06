@extends('layouts.admin')
@section('title', 'Add Product')
@section('content')
<div class="min-h-screen bg-gray-300 dark:bg-[#181f31] p-8">
    <div class="max-w-full mx-auto">
        <div class="bg-white dark:bg-[#23263a] rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-600">
            <div class="flex items-center mb-8">
                <div class="bg-blue-100 dark:bg-blue-900 rounded-full p-2 mr-3">
                    <svg class="w-7 h-7 text-blue-500 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M6 12h12" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Add Product</h1>
            </div>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="flex items-center gap-2 text-gray-700 dark:text-gray-200 font-semibold mb-1">
                            Name
                        </label>
                        <input type="text" name="name" id="name" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900" value="{{ old('name') }}">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="slug" class="flex items-center gap-2 text-gray-700 dark:text-gray-200 font-semibold mb-1">
                            Slug
                        </label>
                        <input type="text" name="slug" id="slug" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900" value="{{ old('slug') }}">
                        @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Description</label>
                    <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="short_description" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Short Description</label>
                    <textarea name="short_description" id="short_description" rows="2" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900">{{ old('short_description') }}</textarea>
                    @error('short_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label for="price" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Price</label>
                        <input type="number" step="0.01" name="price" id="price" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900" value="{{ old('price') }}">
                        @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="compare_price" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Compare Price</label>
                        <input type="number" step="0.01" name="compare_price" id="compare_price" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900" value="{{ old('compare_price') }}">
                        @error('compare_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="sale_price" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Sale Price</label>
                        <input type="number" step="0.01" name="sale_price" id="sale_price" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900" value="{{ old('sale_price') }}">
                        @error('sale_price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="sku" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">SKU</label>
                        <input type="text" name="sku" id="sku" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900" value="{{ old('sku') }}">
                        @error('sku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="stock_quantity" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Stock Quantity</label>
                        <input type="number" name="stock_quantity" id="stock_quantity" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900" value="{{ old('stock_quantity', 0) }}">
                        @error('stock_quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="category_id" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Category</label>
                        <select name="category_id" id="category_id" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="image" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Main Image</label>
                        <input type="file" name="image" id="image" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900" accept="image/*" onchange="showPreview(event)">
                        <div id="imagePreview" class="mt-2"></div>
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="images" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Gallery Images</label>
                    <input type="file" name="images[]" id="images" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900" multiple accept="image/*">
                    @error('images') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="specifications" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Specifications (JSON)</label>
                    <textarea name="specifications" id="specifications" rows="2" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900">{{ old('specifications') }}</textarea>
                    @error('specifications') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="gallery" class="text-gray-700 dark:text-gray-200 font-semibold mb-1 block">Gallery (JSON)</label>
                    <textarea name="gallery" id="gallery" rows="2" class="w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 rounded-lg px-4 py-2 focus:ring focus:ring-blue-100 dark:focus:ring-blue-900">{{ old('gallery') }}</textarea>
                    @error('gallery') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label class="inline-flex items-center font-semibold">
                            <input type="checkbox" name="on_sale" value="1" {{ old('on_sale') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700 dark:text-gray-200">On Sale</span>
                        </label>
                        @error('on_sale') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="inline-flex items-center font-semibold">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700 dark:text-gray-200">Featured</span>
                        </label>
                        @error('is_featured') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <label class="inline-flex items-center font-semibold">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <span class="ml-2 text-gray-700 dark:text-gray-200">Active</span>
                    </label>
                    @error('is_active') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition-all duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                        </svg>
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
function showPreview(event) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    if (event.target.files.length > 0) {
        const src = URL.createObjectURL(event.target.files[0]);
        const img = document.createElement('img');
        img.src = src;
        img.className = 'mt-2 rounded shadow h-24';
        preview.appendChild(img);
    }
}
</script>
@endpush
@endsection
