@extends('layouts.admin')

@section('title', 'Category Details')

@section('content')
<div class="p-4 md:p-6 w-full">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Category #{{ $category->id }} Details</h2>
        <a href="{{ route('admin.categories.index') }}" class="text-sm bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition">
            &larr; Back to Categories
        </a>
    </div>

    {{-- Main Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        
        {{-- Header Section --}}
        <div class="p-6 border-b border-gray-100">
            <h3 class="text-xl font-bold text-gray-900">{{ $category->name }}</h3>
        </div>

        <div class="p-6">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="flex-shrink-0">
                    <img class="w-48 h-48 rounded-lg object-cover border border-gray-200 shadow-sm"
                         src="{{ $category->image_url }}" 
                         alt="{{ $category->name }}">
                </div>

                <div class="flex-1 space-y-4">
                    <p class="text-gray-600 leading-relaxed">{{ $category->description }}</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-gray-100">
                        <div>
                            <span class="block text-xs font-semibold uppercase text-gray-400">Parent Category</span>
                            <span class="text-gray-900 font-medium">{{ $category->parent?->name ?? 'None' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold uppercase text-gray-400">Total Products</span>
                            <span class="text-indigo-600 font-medium">{{ $category->products()->count() }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold uppercase text-gray-400">Created At</span>
                            <span class="text-gray-900 font-medium">{{ $category->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
            <a href="{{ route('admin.categories.edit', $category) }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                Edit
            </a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" data-confirm="Are you sure?">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm font-medium">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection