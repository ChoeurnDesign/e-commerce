{{-- Homepage Banner Management --}}
<div class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8">
    <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">Homepage Banners</h2>
    {{-- Add Banner Form --}}
    <form action="{{ route('admin.settings.add_banner') }}" method="POST" enctype="multipart/form-data" class="mb-8">
        @csrf
        <div class="grid grid-cols-1 gap-6 mb-4">
            <div>
                <x-input-label for="banner_image" value="Image: (Recommended: 515 x 1515 px)" />
                <x-text-input
                    id="banner_image"
                    name="image"
                    type="file"
                    required
                    class="bg-gray-700 border-none text-gray-100 px-2 py-1 "
                />
            </div>
        </div>
        <x-admin.btn-submit>Add Banner</x-admin.btn-submit>
    </form>

    {{-- List Banners --}}
    <div class="space-y-4">
        @foreach($banners as $banner)
        <div class="bg-gray-700 p-4  flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img src="{{ asset('storage/'.$banner->image_path) }}" class="h-16  shadow" />
                <div>
                    <div class="text-white font-bold">Banner ID: {{ $banner->id }}</div>
                </div>
            </div>
            <div class="flex gap-4">
                {{-- Edit as link to edit page --}}
                <x-admin.table-edit-button :href="route('admin.settings.edit_banner', $banner)" />
                {{-- Delete button --}}
                <x-admin.table-delete-button :action="route('admin.settings.delete_banner', $banner)" />
            </div>
        </div>
        @endforeach
    </div>
</div>
