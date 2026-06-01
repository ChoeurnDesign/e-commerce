@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="space-y-6 min-h-screen">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Edit Category</h2>
        <a href="{{ route('admin.categories.index') }}" class="bg-gray-50 hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg transition duration-200">
            &larr; Back to Categories
        </a>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT') {{-- method spoofing for resource update --}}

            <div>
                <x-input-label for="name" value="Category Name" class="block text-sm font-medium" />
                <x-text-input type="text" name="name" id="name" :value="old('name', $category->name)" required
                    class="mt-1 block w-full border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('name')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-input-label for="description" value="Description" class="block text-sm font-medium" />
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-input-label for="parent_id" value="Parent Category" class="block text-sm font-medium" />
                <select name="parent_id" id="parent_id"
                    class="mt-1 block w-full border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">None</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" @if(old('parent_id', $category->parent_id) == $parent->id) selected @endif>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Commission Rate Override --}}
            <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4">
                <x-input-label for="commission_rate" value="Commission Rate Override (%)" class="block text-sm font-semibold text-indigo-900" />
                <div class="mt-2 flex items-center gap-3">
                    <input type="number" step="0.01" min="0" max="100" name="commission_rate" id="commission_rate"
                        value="{{ old('commission_rate', $category->commission_rate) }}"
                        placeholder="Leave blank to use seller/platform default"
                        class="block w-48 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="text-xs text-gray-500">Examples: Electronics 5–8%, Fashion 12–15%, Digital 15–20%</span>
                </div>
                <p class="text-[11px] text-indigo-700 mt-2">
                    If set, this rate applies to ALL products in this category, overriding the seller's rate. Leave blank to inherit from seller/platform.
                </p>
                @error('commission_rate')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-input-label for="image" value="Category Image" class="block text-sm font-medium" />
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full text-sm border border-gray-300 text-gray-700">
                @if($category->image_url ?? false)
                    <img src="{{ $category->image_url }}" alt="{{ $category->image_alt ?? $category->name }}" class="h-24 w-24 mt-2 object-cover border border-gray-300"
                         onerror="this.onerror=null;this.src='{{ asset('/img/default-category.png') }}';">
                @endif
                @error('image')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Checkbox to Remove Old Image -->
            <div>
                <div class="flex items-center mt-4">
                    <input type="checkbox" name="remove_image" id="remove_image"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remove_image" class="ml-2 block text-sm text-gray-700">
                        Remove current image
                    </label>
                </div>
            </div>

            <div class="pt-4 flex space-x-4">
                <x-admin.form-submit-button :action="route('admin.categories.update', $category->id)">Update Category</x-admin.form-submit-button>
                <x-admin.form-cancel-button :href="route('admin.categories.index')">Cancel</x-admin.form-cancel-button>
            </div>
        </form>
    </div>
</div>
@endsection