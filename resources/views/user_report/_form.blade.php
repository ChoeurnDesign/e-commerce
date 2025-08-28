@csrf

<div class="mb-4">
    <x-input-label for="title" class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">
        Title <span class="text-red-500">*</span>
    </x-input-label>
    <x-text-input
        type="text"
        name="title"
        id="title"
        required
        maxlength="255"
        :value="old('title')"
        class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-400 dark:focus:border-indigo-400"
    />
</div>

<div class="mb-4">
    <x-input-label for="description" class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">
        Description
    </x-input-label>
    <textarea
        name="description"
        id="description"
        rows="4"
        maxlength="2000"
        class="w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-400 dark:focus:border-indigo-400"
    >{{ old('description') }}</textarea>
</div>

<div class="mb-4">
    <x-input-label for="images" class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">
        Images (optional, up to 5)
    </x-input-label>
    <input
        type="file"
        name="images[]"
        id="images"
        multiple
        accept="image/*"
        class="block w-full text-sm text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded"
    >
    <span class="text-xs text-gray-400 dark:text-gray-500 block mt-1">
        You may select multiple images (jpeg, png, gif, svg, max 4MB each).
    </span>
</div>

<button
    type="submit"
    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded transition dark:bg-blue-700 dark:hover:bg-blue-600"
>
    Submit Report
</button>
