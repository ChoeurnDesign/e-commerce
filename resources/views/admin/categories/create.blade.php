@extends('layouts.admin')
@section('title', 'Add Category')
@section('content')
<div class="min-h-screen">
    <div class="space-y-6 min-h-screen">
        <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
            <div class="flex items-center mb-8">
                <div class="bg-blue-100 rounded-full p-2 mr-3">
                    <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12M6 12h12" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Add Category</h1>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="name" value="Name" class="flex items-center gap-2 font-semibold mb-1" />
                        <x-text-input type="text" name="name" id="name"
                            :value="old('name')"
                            class="w-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-100" />
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-input-label for="slug" value="Slug" class="flex items-center gap-2 font-semibold mb-1" />
                        <x-text-input type="text" name="slug" id="slug"
                            :value="old('slug')"
                            class="w-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-100" />
                        @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <x-input-label for="parent_id" value="Parent Category" class="font-semibold mb-1" />
                    <select name="parent_id" id="parent_id"
                        class="w-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-100">
                        <option value="">None</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <x-input-label for="description" value="Description" class="font-semibold mb-1" />
                    <textarea name="description" id="description" rows="3"
                        class="w-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-100">{{ old('description') }}</textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <x-input-label for="image" value="Image" class="font-semibold mb-1" />
                        <input type="file" name="image" id="image"
                            class="w-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-100"
                            accept="image/*" onchange="showCategoryPreview(event)">
                        <div id="categoryImagePreview" class="mt-2"></div>
                        @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <x-input-label for="sort_order" value="Sort Order" class="font-semibold mb-1" />
                            <x-text-input type="number" name="sort_order" id="sort_order"
                                :value="old('sort_order', 0)"
                                class="w-full border border-gray-300 px-4 py-2 focus:ring focus:ring-blue-100" />
                            @error('sort_order') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex items-center h-full mt-7 md:mt-0">
                            <label class="inline-flex items-center font-semibold">
                                <input type="checkbox" name="is_active" value="1"
                                    class="border-gray-300 text-blue-600 shadow-sm focus:ring-2 focus:ring-blue-500 transition"
                                    {{ old('is_active', 1) ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Active</span>
                            </label>
                            @error('is_active') <span class="text-red-500 text-sm ml-3">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Commission Rate Override --}}
                <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4">
                    <x-input-label for="commission_rate" value="Commission Rate Override (%)" class="font-semibold text-indigo-900" />
                    <div class="mt-2 flex items-center gap-3">
                        <input type="number" step="0.01" min="0" max="100" name="commission_rate" id="commission_rate"
                            value="{{ old('commission_rate') }}"
                            placeholder="Optional — leave blank to use seller default"
                            class="block w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="text-xs text-gray-500">Examples: Electronics 5–8%, Fashion 12–15%</span>
                    </div>
                    <p class="text-[11px] text-indigo-700 mt-2">
                        If set, applies to all products in this category, overriding the seller's rate.
                    </p>
                    @error('commission_rate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition-all duration-150">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6"/>
                        </svg>
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<script>
function showCategoryPreview(event) {
    const preview = document.getElementById('categoryImagePreview');
    preview.innerHTML = '';
    if (event.target.files.length > 0) {
        const src = URL.createObjectURL(event.target.files[0]);
        const img = document.createElement('img');
        img.src = src;
        img.className = 'mt-2 shadow h-24';
        preview.appendChild(img);
    }
}
</script>
@endpush
@endsection
