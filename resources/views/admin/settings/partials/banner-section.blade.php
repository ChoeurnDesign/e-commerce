<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Homepage Banners</h2>

    {{-- Feedback Messages --}}
    @if ($errors->any())
        <div class="bg-red-50/20 text-red-600 p-4 rounded-lg mb-6 border border-red-200">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif
    
    @if (session('success'))
        <div class="bg-green-50/20 text-green-600 p-4 rounded-lg mb-6 border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add Banner Form --}}
    <form action="{{ route('admin.settings.add_banner') }}" method="POST" enctype="multipart/form-data" class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
        @csrf
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <x-input-label for="banner_image" value="Upload New Banner" class="mb-1" />
                <input type="file" id="banner_image" name="image" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition" />
            </div>
            <x-admin.btn-submit>Add Banner</x-admin.btn-submit>
        </div>
    </form>

    {{-- List Banners --}}
    <div class="space-y-4">
        @forelse($banners as $banner)
            <div class="flex items-center justify-between p-4 border border-gray-100 rounded-lg hover:bg-gray-50 transition">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/'.$banner->image_path) }}" class="h-16 w-32 object-cover rounded border border-gray-200 shadow-sm" />
                    <span class="text-gray-700 font-medium">Banner ID: {{ $banner->id }}</span>
                </div>
                <div class="flex gap-2">
                    <x-admin.table-edit-button :href="route('admin.settings.edit_banner', $banner)" />
                    <x-admin.table-delete-button :action="route('admin.settings.delete_banner', $banner)" />
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">No banners found.</p>
        @endforelse
    </div>
</div>