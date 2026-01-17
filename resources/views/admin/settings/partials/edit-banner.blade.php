@extends('layouts.admin')

@section('content')
<div class="container min-h-screen font-sans">
    <div class="bg-gray-800 p-8 rounded-xl shadow-lg w-full max-w-full mx-auto">
        <h3 class="text-2xl font-bold text-white mb-4">Edit Banner</h3>
        <form action="{{ route('admin.settings.banner.update', $banner) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" value="">
            <div class="mb-4">
                <x-input-label for="current_image" value="Current Image" />
                <img id="current_image" src="{{ asset('storage/' . $banner->image_path) }}" class="h-24  shadow mb-2" />
            </div>
            <div class="mb-4">
                <x-input-label for="banner_image" value="New Image (leave blank to keep current)" />
                {{-- If you have a file input component, use it here. Otherwise, use your text-input with type="file" --}}
                <x-text-input
                    id="banner_image"
                    name="image"
                    type="file"
                    class="bg-gray-700 border-none text-gray-100 px-2 py-1  w-full"
                />
            </div>
            <div class="flex gap-2">
                <x-admin.btn-submit>Save Changes</x-admin.btn-submit>
                <a href="{{ route('admin.settings.index') }}" class="bg-gray-700 text-white -full px-5 py-2 font-bold">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

