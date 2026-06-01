@extends('layouts.seller')

@section('title', 'Image Gallery')

@section('content')
<div class="space-y-6">

    {{-- Page header --}}
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
                <svg class="w-5 h-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Image Gallery</h1>
                <p class="text-xs text-gray-500">Upload and manage images for your products</p>
            </div>
        </div>
        <a href="{{ route('seller.products.import.form') }}"
           class="inline-flex items-center gap-2 text-sm text-pink-600 border border-pink-200 px-4 py-2 rounded-xl hover:bg-pink-50 transition font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
            Import Products
        </a>
    </div>

    {{-- Info tip --}}
    <div class="bg-pink-50 border border-pink-100 rounded-xl px-5 py-4 flex items-start gap-3 text-sm text-pink-800">
        <svg class="w-5 h-5 text-pink-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div>
            <span class="font-semibold">How to use with CSV Import:</span>
            Upload your images here first, then <strong>copy the filename</strong> shown on each image card and paste it into the
            <code class="bg-white px-1 rounded border border-pink-200 text-pink-700">image</code> or
            <code class="bg-white px-1 rounded border border-pink-200 text-pink-700">gallery</code>
            column in your CSV file.
            <strong>Main Images</strong> → use in <code class="bg-white px-1 rounded border border-pink-200 text-pink-700">image</code> column.
            <strong>Gallery Images</strong> → use in <code class="bg-white px-1 rounded border border-pink-200 text-pink-700">gallery</code> column (pipe-separate multiple: <code class="bg-white px-1 rounded border border-pink-200 text-pink-700">file1.jpg|file2.jpg</code>).
        </div>
    </div>

    {{-- Upload cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Main Images Upload --}}
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                <h2 class="text-base font-semibold text-gray-900">Main Images</h2>
                <span class="text-xs text-gray-400">(used in <code class="bg-gray-50 px-1 rounded">image</code> column)</span>
            </div>
            <form action="{{ route('seller.images.uploadMain') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="main-drop-area"
                     class="relative border-2 border-dashed border-pink-200 rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer hover:border-pink-400 hover:bg-pink-50 transition group mb-4">
                    <input type="file" name="main_images[]" id="main_images" multiple required accept="image/*"
                           class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                    <svg class="w-8 h-8 text-pink-300 mb-2 group-hover:text-pink-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p id="main-prompt" class="text-sm text-pink-500 font-medium">Click or drag & drop main images</p>
                    <p id="main-selected" class="text-sm font-semibold text-gray-700 hidden"></p>
                    <p class="text-xs text-gray-400 mt-1">JPEG, PNG, WebP · max 4MB each · up to 20 files</p>
                </div>
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Upload Main Images
                </button>
            </form>
        </div>

        {{-- Gallery Images Upload --}}
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                <h2 class="text-base font-semibold text-gray-900">Gallery Images</h2>
                <span class="text-xs text-gray-400">(used in <code class="bg-gray-50 px-1 rounded">gallery</code> column)</span>
            </div>
            <form action="{{ route('seller.images.uploadGallery') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="gallery-drop-area"
                     class="relative border-2 border-dashed border-purple-200 rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer hover:border-purple-400 hover:bg-purple-50 transition group mb-4">
                    <input type="file" name="gallery_images[]" id="gallery_images" multiple required accept="image/*"
                           class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                    <svg class="w-8 h-8 text-purple-300 mb-2 group-hover:text-purple-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p id="gallery-prompt" class="text-sm text-purple-500 font-medium">Click or drag & drop gallery images</p>
                    <p id="gallery-selected" class="text-sm font-semibold text-gray-700 hidden"></p>
                    <p class="text-xs text-gray-400 mt-1">JPEG, PNG, WebP · max 4MB each · up to 20 files</p>
                </div>
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Upload Gallery Images
                </button>
            </form>
        </div>

    </div>

    {{-- Image grids --}}
    <x-images.grid title="Main Images" :images="$mainImages" delete-route="seller.images.delete" />
    <x-images.grid title="Gallery Images" :images="$galleryImages" delete-route="seller.images.delete" />

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function setupDropArea(dropId, inputId, promptId, selectedId) {
        const drop   = document.getElementById(dropId);
        const input  = document.getElementById(inputId);
        const prompt = document.getElementById(promptId);
        const sel    = document.getElementById(selectedId);
        if (!drop || !input) return;

        input.addEventListener('change', () => {
            if (input.files.length) {
                prompt.classList.add('hidden');
                sel.classList.remove('hidden');
                sel.textContent = input.files.length + ' file(s) selected';
            } else {
                prompt.classList.remove('hidden');
                sel.classList.add('hidden');
            }
        });
        ['dragenter','dragover'].forEach(ev => drop.addEventListener(ev, e => { e.preventDefault(); }));
        drop.addEventListener('drop', e => {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                try { input.files = e.dataTransfer.files; } catch(err) {}
                prompt.classList.add('hidden');
                sel.classList.remove('hidden');
                sel.textContent = e.dataTransfer.files.length + ' file(s) selected';
            }
        });
    }

    setupDropArea('main-drop-area',    'main_images',    'main-prompt',    'main-selected');
    setupDropArea('gallery-drop-area', 'gallery_images', 'gallery-prompt', 'gallery-selected');
});
</script>
@endpush
@endsection
