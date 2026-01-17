@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="space-y-6 min-h-screen">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Category Details</h2>
        <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#262c47] text-gray-700 dark:text-gray-200 px-4 py-2 rounded-lg transition duration-200">
            &larr; Back to Categories
        </a>
    </div>

    <!-- Category Card -->
    <div class="bg-white dark:bg-[#23263a] rounded-lg shadow p-6 flex flex-col md:flex-row gap-6 border border-gray-100 dark:border-[#23263a]">
        <img class="w-40 h-40 rounded-full object-cover border dark:border-[#23263a]"
            src="{{ $category->image ? asset($category->image) : asset('/img/default-category.png') }}"
            alt="{{ $category->name }}"
            onerror="this.onerror=null;this.src='{{ asset('/img/default-category.png') }}';">
        <div class="flex-1 space-y-3">
            <h3 class="text-xl  text-gray-900 dark:text-gray-100">{{ $category->name }}</h3>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-200">Description:</span>
                <div class="text-gray-800 dark:text-gray-200 mt-1">{{ $category->description }}</div>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-200">Parent Category:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $category->parent?->name ?? '-' }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-200">Total Products:</span>
                <span class="text-indigo-700 dark:text-indigo-300 ">{{ $category->products_count ?? $category->products()->count() }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-200">Created At:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $category->created_at?->format('Y-m-d H:i') }}</span>
            </div>
        </div>
    </div>

    <!-- Category Actions -->
    <div class="flex space-x-4">
        <a href="{{ route('admin.categories.edit', $category) }}" class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-lg transition duration-200">Edit Category</a>
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
            @csrf
            <input type="hidden" name="_method" value="">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">Delete Category</button>
        </form>
    </div>
</div>
@endsection

