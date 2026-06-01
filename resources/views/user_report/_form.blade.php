@csrf

<div class="space-y-4">
    <div>
        <label for="title" class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
            Title <span class="text-red-500">*</span>
        </label>
        <input
            type="text"
            name="title"
            id="title"
            required
            maxlength="255"
            value="{{ old('title') }}"
            placeholder="Briefly describe the issue"
            class="w-full rounded-xl border border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
        />
        @error('title')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
            Description
        </label>
        <textarea
            name="description"
            id="description"
            rows="4"
            maxlength="2000"
            placeholder="Please provide as much detail as possible..."
            class="w-full rounded-xl border border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition resize-none"
        >{{ old('description') }}</textarea>
        @error('description')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="images" class="block text-xs font-semibold text-gray-700 mb-1.5 uppercase tracking-wide">
            Screenshots <span class="font-normal normal-case text-gray-400">(optional, up to 5)</span>
        </label>
        <label for="images"
            class="flex items-center gap-3 w-full px-4 py-3 rounded-xl border border-dashed border-gray-300 bg-gray-50 cursor-pointer hover:border-indigo-400 transition-colors group">
            <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="text-sm text-gray-500 group-hover:text-indigo-600 transition-colors" id="file-label">
                Click to upload images
            </span>
            <input
                type="file"
                name="images[]"
                id="images"
                multiple
                accept="image/*"
                class="hidden"
                onchange="document.getElementById('file-label').textContent = this.files.length > 0 ? this.files.length + ' file(s) selected' : 'Click to upload images'"
            >
        </label>
        <p class="text-xs text-gray-400 mt-1.5">JPEG, PNG, GIF, SVG — max 4MB each</p>
        @error('images')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button
        type="submit"
        class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 rounded-xl text-sm transition-colors shadow-md hover:shadow-lg mt-1"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
        </svg>
        Submit Report
    </button>
</div>
