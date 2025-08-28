<form action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if(isset($formMethod) && strtoupper($formMethod) === 'PUT')
        @method('PUT')
    @endif

    {{-- Product Name --}}
    <div>
        <x-input-label for="name" value="Product Name" />
        <x-text-input type="text" name="name" id="name" :value="old('name', $product->name ?? '')" required
            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
        @error('name')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- SKU --}}
    <div>
        <x-input-label for="sku" value="SKU" />
        <x-text-input type="text" name="sku" id="sku" :value="old('sku', $product->sku ?? '')" required
            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
        @error('sku')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Category --}}
    <div>
        <x-input-label for="category_id" value="Category" />
        <select name="category_id" id="category_id" class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">No Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(old('category_id', $product->category_id ?? '') == $category->id) selected @endif>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Price fields --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div>
            <x-input-label for="price" value="Price ($)" />
            <x-text-input type="number" name="price" id="price" :value="old('price', $product->price ?? '')" step="0.01" min="0" required
                class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('price')
                <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <x-input-label for="compare_price" value="Compare Price ($)" />
            <x-text-input type="number" name="compare_price" id="compare_price" :value="old('compare_price', $product->compare_price ?? '')" step="0.01" min="0"
                class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('compare_price')
                <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex items-center mt-6">
            <input type="checkbox" name="on_sale" value="1" {{ old('on_sale', $product->on_sale ?? false) ? 'checked' : '' }}>
            <label class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-200">On Sale?</label>
        </div>
        <div>
            <x-input-label for="sale_price" value="Sale Price ($)" />
            <x-text-input type="number" name="sale_price" id="sale_price" :value="old('sale_price', $product->sale_price ?? '')" step="0.01" min="0"
                class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('sale_price')
                <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Stock Quantity --}}
    <div>
        <x-input-label for="stock_quantity" value="Stock Quantity" />
        <x-text-input type="number" name="stock_quantity" id="stock_quantity" :value="old('stock_quantity', $product->stock_quantity ?? '')" step="1" min="0" required
            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
        @error('stock_quantity')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Main Image --}}
    <div>
        <x-input-label for="image" value="Product Image" />
        <input type="file" name="image" id="image" class="mt-1 block w-full text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:bg-[#23263a]">
        @if(!empty($product->image))
            <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/400x400/f3f4f6/9ca3af?text=' . urlencode($product->name) }}"
                class="h-24 w-24 mt-2 object-cover border border-gray-300 dark:border-gray-600"
                alt="{{ $product->name }}">
        @endif
        @error('image')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Gallery Images --}}
    <div>
        <x-input-label for="images" value="Product Gallery Images" />
        <input type="file" name="images[]" id="images" multiple
            class="mt-1 block w-full text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:bg-[#23263a]">
        @if(!empty($product->images) && is_array($product->images))
            <div class="flex gap-2 mt-2">
                @foreach($product->images as $img)
                    <img src="{{ asset($img) }}"
                         class="h-16 w-16 object-cover border border-gray-300 dark:border-gray-600 rounded"
                         alt="Gallery Image">
                @endforeach
            </div>
        @endif
        @error('images')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Short Description --}}
    <div>
        <x-input-label for="short_description" value="Short Description" />
        <textarea name="short_description" id="short_description" rows="2"
            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('short_description', $product->short_description ?? '') }}</textarea>
        @error('short_description')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <x-input-label for="description" value="Description" />
        <textarea name="description" id="description" rows="4"
            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Specifications --}}
    <div>
        <x-input-label for="specifications" value="Specifications (JSON format or key: value, one per line)" />
        <textarea name="specifications" id="specifications" rows="3"
            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('specifications', is_array($product->specifications ?? null) ? json_encode($product->specifications) : ($product->specifications ?? '')) }}</textarea>
        @error('specifications')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Is Featured --}}
    <div class="flex items-center space-x-4">
        <label class="flex items-center">
            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Featured</span>
        </label>
        <label class="flex items-center">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
            <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Active</span>
        </label>
    </div>

    {{-- Gallery field (optional, if you use it separately from images) --}}
    <div>
        <x-input-label for="gallery" value="Gallery (JSON array of URLs or paths)" />
        <textarea name="gallery" id="gallery" rows="2"
            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('gallery', is_array($product->gallery ?? null) ? json_encode($product->gallery) : ($product->gallery ?? '')) }}</textarea>
        @error('gallery')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Meta Title --}}
    <div>
        <x-input-label for="meta_title" value="Meta Title (SEO)" />
        <x-text-input type="text" name="meta_title" id="meta_title" :value="old('meta_title', $product->meta_title ?? '')"
            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
        @error('meta_title')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Meta Description --}}
    <div>
        <x-input-label for="meta_description" value="Meta Description (SEO)" />
        <textarea name="meta_description" id="meta_description" rows="2"
            class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
        @error('meta_description')
            <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="pt-4 flex space-x-4">
        <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition-all duration-150">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
            </svg>
            {{ $submitText ?? 'Save Product' }}
        </button>
        @if(isset($cancelUrl))
        <a href="{{ $cancelUrl }}" class="inline-flex items-center gap-2 bg-gray-300 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#262c47] text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition duration-200">
            Cancel
        </a>
        @endif
    </div>
</form>
