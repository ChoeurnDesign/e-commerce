@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="max-w-full mx-auto space-y-8 bg-gray-300 dark:bg-[#181f31] min-h-screen p-10">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Edit Category</h2>
        <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#262c47] text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition duration-200">
            &larr; Back to Categories
        </a>
    </div>

    <!-- Edit Form -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 border border-gray-100 dark:border-[#23263a]">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                    class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('name')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                <textarea name="description" rows="4"
                    class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Parent Category</label>
                <select name="parent_id" class="mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-[#23263a] dark:text-gray-100 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">None</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" @if(old('parent_id', $category->parent_id) == $parent->id) selected @endif>
                            {{ $parent->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Category Image</label>
                <input type="file" name="image" class="mt-1 block w-full text-sm border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 dark:bg-[#23263a]">
                @if($category->image)
                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="h-24 w-24 mt-2 rounded object-cover border border-gray-300 dark:border-gray-600"
                         onerror="this.onerror=null;this.src='{{ asset('/img/default-category.png') }}';">
                @endif
                @error('image')
                    <p class="text-red-600 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex space-x-4">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-200">
                    Update Category
                </button>
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-400 dark:hover:bg-[#262c47] text-gray-800 dark:text-gray-200 px-6 py-2 rounded-lg font-semibold transition duration-200">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
