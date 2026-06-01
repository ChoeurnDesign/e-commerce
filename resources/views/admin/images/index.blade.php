@extends('layouts.admin')

@section('title', 'Admin Product Images')

@section('content')
<div class="container mx-auto py-8 space-y-8">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <h1 class="text-2xl font-bold text-gray-900">Admin Product Images</h1>
        @if(session('success'))
            <div class="px-3 py-1.5 rounded bg-green-100 text-green-800">
                {{ session('success') }}
            </div>
        @endif
    </div>

    @if($errors->any())
        <div class="mb-4 text-red-700 bg-red-50/30 border border-red-200 rounded p-3">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">Upload Main Images</h2>
        <form action="{{ route('admin.images.uploadMain') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start gap-3">
            @csrf
            <input type="file" name="main_images[]" multiple required class="text-sm">
            <button type="submit" class="inline-flex items-center px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white text-sm shadow">
                Upload Main Images
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-6">
        <h2 class="text-lg font-semibold text-gray-900">Upload Gallery Images</h2>
        <form action="{{ route('admin.images.uploadGallery') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start gap-3">
            @csrf
            <input type="file" name="gallery_images[]" multiple required class="text-sm">
            <button type="submit" class="inline-flex items-center px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white text-sm shadow">
                Upload Gallery Images
            </button>
        </form>
    </div>

    {{-- Grids using the component (server-side pagination by default) --}}
    <x-images.grid title="Main Images" :images="$mainImages" delete-route="admin.images.delete" cols="4" />

    <x-images.grid title="Gallery Images" :images="$galleryImages" delete-route="admin.images.delete" cols="4" />
</div>
@endsection