<div class="max-w-full mx-auto">
    <div class="bg-white dark:bg-[#23263a] shadow-xl rounded-xl overflow-hidden p-8 border border-gray-200 dark:border-[#23263a]">
        <div class="flex items-center mb-6">
            <span class="bg-green-100 dark:bg-green-900 rounded-full p-2 mr-3">
                <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
            </span>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $title ?? 'Import Products' }}</h1>
        </div>

        <ol class="list-decimal list-inside mb-8 text-gray-700 dark:text-gray-200">
            <li>Download the <a href="{{ asset('sample-products-template.csv') }}" class="text-indigo-600 dark:text-indigo-300 underline">sample CSV template</a>.</li>
            <li>Fill in your product data following the sample column format.</li>
            <li>Upload your completed CSV file below.</li>
        </ol>

        <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="products_file" class="block font-semibold text-gray-800 dark:text-gray-200 mb-2">Your CSV File</label>
                <div id="file-drop-area"
                    class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer transition hover:border-blue-400 dark:hover:border-blue-500">
                    <svg class="w-10 h-10 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <input type="file" name="products_file" id="products_file" accept=".csv"
                        class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                    <span id="file-prompt" class="text-blue-600 dark:text-blue-400">Drag & drop or click to choose file</span>
                    <span id="file-name" class="text-blue-600 dark:text-blue-400 font-medium" style="display:none"></span>
                </div>
                @error('products_file')
                    <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-4">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition flex items-center justify-center gap-2">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    {{ $buttonText ?? 'Import Products' }}
                </button>
                <a href="{{ $backRoute }}" class="text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-300 transition">Back to Products</a>
            </div>
        </form>

        @if(session('success'))
            <div class="mt-6 px-4 py-3 bg-green-50 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 rounded-lg">
                <strong>Success:</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mt-6 px-4 py-3 bg-red-50 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 rounded-lg">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        @endif

        <div class="mt-10">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Tips for a Successful Import</h2>
            <ul class="list-disc ml-5 text-gray-700 dark:text-gray-200">
                <li>Ensure your file is in CSV format and all columns are correctly labeled.</li>
                <li>
                    Recommended columns:
                    <span class="font-mono bg-gray-300 dark:bg-[#181f31] rounded px-2 py-1 text-xs text-gray-800 dark:text-gray-100">
                        name, description, price, sku, stock_quantity, category_id, image_url, is_active
                    </span>
                </li>
                <li>Maximum file size: 2MB.</li>
                <li>For large imports, split files and import in batches.</li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput = document.getElementById('products_file');
    const fileNameSpan = document.getElementById('file-name');
    const filePromptSpan = document.getElementById('file-prompt');
    const dropArea = document.getElementById('file-drop-area');

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            fileNameSpan.textContent = fileInput.files[0].name;
            fileNameSpan.style.display = '';
            filePromptSpan.style.display = 'none';
            dropArea.classList.remove('border-gray-300', 'dark:border-gray-600');
            dropArea.classList.add('border-blue-500', 'dark:border-blue-500');
        } else {
            fileNameSpan.textContent = '';
            fileNameSpan.style.display = 'none';
            filePromptSpan.style.display = '';
            dropArea.classList.remove('border-blue-500', 'dark:border-blue-500');
            dropArea.classList.add('border-gray-300', 'dark:border-gray-600');
        }
    });
});
</script>
@endpush
