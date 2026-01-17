<div class="flex justify-between items-center mb-6 flex-wrap gap-4">
    <div class="flex items-center justify-between">
        <span class="mr-2">
            <x-icon-dashboard name="products" class="w-7 h-7 text-indigo-600 dark:text-yellow-400" />
        </span>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{$title}}</h1>
    </div>
</div>

<div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
    <div class="p-6">
        <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if (isset($formMethod) && strtoupper($formMethod) === 'PUT')
                <input type="hidden" name="_method" value="">
            @endif

            {{-- Product Name --}}
            <div>
                <x-input-label for="name" value="Product Name" />
                <x-text-input type="text" name="name" id="name" :value="old('name', $product->name ?? '')" required
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100" />
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- SKU --}}
            <div>
                <x-input-label for="sku" value="SKU" />
                <x-text-input type="text" name="sku" id="sku" :value="old('sku', $product->sku ?? '')" required
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100" />
                @error('sku')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Category --}}
            <div>
                <x-input-label for="category_id" value="Category" />
                <select name="category_id" id="category_id"
                    class="mt-1 block w-full border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100">
                    <option value="">No Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Prices / Sale --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <x-input-label for="price" value="Price ($)" />
                    <x-text-input type="number" name="price" id="price" :value="old('price', $product->price ?? '')" step="0.01"
                        min="0" required class="mt-1 block w-full border dark:bg-[#23263a] dark:text-gray-100" />
                    @error('price')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-input-label for="compare_price" value="Compare Price ($)" />
                    <x-text-input type="number" name="compare_price" id="compare_price" :value="old('compare_price', $product->compare_price ?? '')"
                        step="0.01" min="0"
                        class="mt-1 block w-full border dark:bg-[#23263a] dark:text-gray-100" />
                    @error('compare_price')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center mt-6">
                    <input type="checkbox" name="on_sale" value="1"
                        {{ old('on_sale', $product->on_sale ?? false) ? 'checked' : '' }}>
                    <label class="ml-2 text-sm text-gray-700 dark:text-gray-200">On Sale?</label>
                </div>
                <div>
                    <x-input-label for="sale_price" value="Sale Price ($)" />
                    <x-text-input type="number" name="sale_price" id="sale_price" :value="old('sale_price', $product->sale_price ?? '')" step="0.01"
                        min="0" class="mt-1 block w-full border dark:bg-[#23263a] dark:text-gray-100" />
                    @error('sale_price')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Stock --}}
            <div>
                <x-input-label for="stock_quantity" value="Stock Quantity" />
                <x-text-input type="number" name="stock_quantity" id="stock_quantity" :value="old('stock_quantity', $product->stock_quantity ?? '')" step="1"
                    min="0" required class="mt-1 block w-full border dark:bg-[#23263a] dark:text-gray-100" />
                @error('stock_quantity')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Main Image --}}
            <div>
                <x-input-label for="image" value="Product Image" />
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full text-sm border dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-200">
                @if (!empty($product->image))
                    <img src="{{ asset($product->image) }}"
                        class="h-24 w-24 mt-2 object-cover border dark:border-gray-600" alt="{{ $product->name }}">
                @endif
                @error('image')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Gallery --}}
            <div>
                <x-input-label for="gallery" value="Gallery Images" />
                <input type="file" name="gallery[]" id="gallery" multiple
                    class="mt-1 block w-full text-sm border dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-200">
                @if (!empty($product->gallery) && is_array($product->gallery))
                    <div class="flex gap-2 mt-2 flex-wrap">
                        @foreach ($product->gallery as $img)
                            <img src="{{ asset($img) }}"
                                class="h-16 w-16 object-cover border dark:border-gray-600 rounded" alt="Gallery">
                        @endforeach
                    </div>
                @endif
                @error('gallery')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Short Description --}}
            <div>
                <x-input-label for="short_description" value="Short Description" />
                <textarea name="short_description" id="short_description" rows="2"
                    class="mt-1 block w-full border dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100">{{ old('short_description', $product->short_description ?? '') }}</textarea>
                @error('short_description')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <x-input-label for="description" value="Description" />
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full border dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Specifications --}}
            <div>
                <x-input-label for="specifications" value="Specifications (JSON or key: value per line)" />
                <textarea name="specifications" id="specifications" rows="3"
                    class="mt-1 block w-full border dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100">{{ old('specifications', is_array($product->specifications ?? null) ? json_encode($product->specifications) : $product->specifications ?? '') }}</textarea>
                @error('specifications')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Flags --}}
            <div class="flex items-center space-x-4">
                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1"
                        {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Featured</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-200">Active</span>
                </label>
            </div>

            {{-- SEO --}}
            <div>
                <x-input-label for="meta_title" value="Meta Title (SEO)" />
                <x-text-input type="text" name="meta_title" id="meta_title" :value="old('meta_title', $product->meta_title ?? '')"
                    class="mt-1 block w-full border dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100" />
                @error('meta_title')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <x-input-label for="meta_description" value="Meta Description (SEO)" />
                <textarea name="meta_description" id="meta_description" rows="2"
                    class="mt-1 block w-full border dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100">{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                @error('meta_description')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex space-x-4">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                    </svg>
                    {{ $submitText ?? 'Save Product' }}
                </button>
                @if (isset($cancelUrl))
                    <a href="{{ $cancelUrl }}"
                        class="inline-flex items-center gap-2 bg-gray-100 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#2c3250] text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg shadow-md transition">
                        <x-icon-nav name="back" />
                        Back
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

