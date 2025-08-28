@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
<div class="space-y-6 min-h-screen">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <span class="mr-2">
                <x-icon-dashboard name="categories" class="w-7 h-7 text-indigo-600 dark:text-yellow-400"/>
            </span>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Categories</h1>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Category
        </a>
    </div>

    <!-- Categories Table -->
    <div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead>
                    <tr class="bg-gray-300 dark:bg-[#232c47]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Category Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Parent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Products</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-300 dark:hover:bg-[#262c47]">
                            <td class="px-6 py-4">
                                <img src="{{ $category->image ? asset($category->image) : asset('/img/default-category.png') }}"
                                    alt="{{ $category->name }}"
                                    class="h-20 w-20 rounded-full object-cover border border-indigo-200 dark:border-indigo-700"
                                    onerror="this.onerror=null;this.src='{{ asset('/img/default-category.png') }}';">
                            </td>
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ Str::limit($category->description, 50) }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ $category->parent?->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300 px-2 py-1 rounded-full text-xs">{{ $category->products_count ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center space-x-3">
                                    <x-admin.table-view-button :href="route('admin.categories.show', $category)" />
                                    <x-admin.table-edit-button :href="route('admin.categories.edit', $category)" />
                                    <x-admin.table-delete-button :action="route('admin.categories.destroy', $category)" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 dark:text-gray-300 text-lg">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection
