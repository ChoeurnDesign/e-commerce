@extends('layouts.admin')

@section('title', 'Categories Management')

@section('content')
<div class="space-y-6 min-h-screen">
    <div class="flex justify-between items-center">
        <div class="flex items-center">
            <span class="mr-2">
                <x-icon-dashboard name="categories" class="w-7 h-7 text-indigo-600"/>
            </span>
            <h1 class="text-2xl font-bold text-gray-900">Categories</h1>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add New Category
        </a>
    </div>

    <div class="bg-white shadow-sm overflow-hidden border border-gray-100 rounded-2xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parent</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Commission</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        {{-- Fixed: Changed harsh hover:bg-gray-50 to subtle hover:bg-gray-50 for light mode --}}
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4">
                                @php
                                    // Use PlaceholderAvatar for SVG placeholders
                                    $imgSrc = $category->image_url ?? \App\Helpers\PlaceholderAvatar::svgDataUri($category->name);
                                    $alt = $category->image_alt ?? $category->name;
                                @endphp

                                <div class="h-20 w-20 rounded-full overflow-hidden border border-indigo-200 bg-gray-100">
                                    <img src="{{ $imgSrc }}"
                                        alt="{{ $alt }}"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                        {{-- Fixed: Changed static asset call to your dynamic fallback method to remove extension warnings --}}
                                        onerror="this.onerror=null;this.src='{{ \App\Helpers\PlaceholderAvatar::svgDataUri($category->name) }}';">
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-900 font-medium">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ Str::limit($category->description, 50) }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $category->parent?->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($category->commission_rate !== null)
                                    <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 px-2.5 py-0.5 rounded-full text-xs font-bold">
                                        {{ number_format($category->commission_rate, 2) }}%
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">Default</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-block bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full text-xs font-semibold">{{ $category->products_count ?? 0 }}</span>
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
                            <td colspan="7" class="py-12 text-center text-gray-500 text-lg">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 bg-white">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection