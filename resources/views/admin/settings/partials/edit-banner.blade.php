@extends('layouts.admin')

@section('title', 'Edit Banner')

@section('content')
<div class="p-4 md:p-6 w-full">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Edit Banner</h2>
        <a href="{{ route('admin.settings.index') }}" class="text-sm bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition">
            &larr; Back to Settings
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.settings.banner.update', $banner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <x-input-label for="current_image" value="Current Image" class="mb-2" />
                <img id="current_image" src="{{ asset('storage/' . $banner->image_path) }}" class="h-32 rounded-lg shadow-sm border border-gray-200" alt="Current banner image" />
            </div>

            <div class="mb-6">
                <x-input-label for="banner_image" value="Replace Image" />
                <input type="file" id="banner_image" name="image" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700" />
                <p class="text-xs text-gray-500 mt-2">Leave blank to keep existing image.</p>
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <x-admin.btn-submit>Save Changes</x-admin.btn-submit>
                <a href="{{ route('admin.settings.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">Cancel</a>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100">
            <form action="{{ route('admin.settings.banner.destroy', $banner) }}" method="POST" data-confirm="Are you sure you want to delete this banner?">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-semibold">Delete Banner</button>
            </form>
        </div>
    </div>
</div>
@endsection