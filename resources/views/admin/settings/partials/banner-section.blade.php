<div class="bg-white dark:bg-[#23263a] rounded-xl shadow-sm border border-gray-200 dark:border-[#23263a] p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6">Homepage Banners</h2>

    {{-- Feedback Messages --}}
    @if ($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 p-4 rounded-lg mb-6 border border-red-200 dark:border-red-800">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif
    
    @if (session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 p-4 rounded-lg mb-6 border border-green-200 dark:border-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add Banner Form --}}
    <form action="{{ route('admin.settings.add_banner') }}" method="POST" enctype="multipart/form-data" class="mb-8 p-4 bg-gray-50 dark:bg-[#1f2336] rounded-lg border border-gray-200 dark:border-[#181f31]">
        @csrf
        <div class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <x-input-label for="banner_image" value="Upload New Banner" class="mb-1" />
                <input type="file" id="banner_image" name="image" required class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-900/50 file:text-indigo-700 dark:file:text-indigo-300 hover:file:bg-indigo-100 transition" />
            </div>
            <x-admin.btn-submit>Add Banner</x-admin.btn-submit>
        </div>
    </form>

    {{-- List Banners --}}
    <div class="space-y-4">
        @forelse($banners as $banner)
            <div class="flex items-center justify-between p-4 border border-gray-100 dark:border-[#181f31] rounded-lg hover:bg-gray-50 dark:hover:bg-[#1f2336] transition">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('storage/'.$banner->image_path) }}" class="h-16 w-32 object-cover rounded border border-gray-200 dark:border-gray-700 shadow-sm" />
                    <span class="text-gray-700 dark:text-gray-300 font-medium">Banner ID: {{ $banner->id }}</span>
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