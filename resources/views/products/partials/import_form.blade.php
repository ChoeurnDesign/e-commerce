@php
    // Expected inputs passed in: $formAction, $backRoute
    $title         = $title         ?? 'Import Products';
    $buttonText    = $buttonText    ?? 'Import Products';
    $templateRoute = $templateRoute ?? (Route::has('admin.products.import.template')
                        ? route('admin.products.import.template')
                        : asset('sample-products-template.csv'));
    $maxSizeMB     = $maxSizeMB     ?? 2;
    $acceptTxt     = $acceptTxt     ?? true; // if controller allows txt
    $acceptAttr    = $acceptTxt ? '.csv,.txt,text/csv' : '.csv,text/csv';
@endphp

<div class="flex items-center mb-6 flex-wrap gap-4">
    <span class="bg-green-100 dark:bg-green-900 rounded-full p-2 mr-3">
        <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
        </svg>
    </span>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $title }}</h1>
</div>

<div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
    <div class="p-6">

        <ol class="list-decimal list-inside mb-8 text-gray-700 dark:text-gray-200 space-y-1">
            <li>
                Download the
                <a href="{{ $templateRoute }}" class="text-indigo-600 dark:text-indigo-300 underline">sample CSV template</a>.
            </li>
            <li>Fill in your product data following the column format.</li>
            <li>Upload your completed file below.</li>
        </ol>

        <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="products_file" class="block font-semibold text-gray-800 dark:text-gray-200 mb-2">
                    Your CSV File
                    <span class="text-xs font-normal text-gray-500 dark:text-gray-400"> (max {{ $maxSizeMB }}MB)</span>
                </label>
                <div id="file-drop-area"
                    class="relative border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer transition hover:border-blue-400 dark:hover:border-blue-500">
                    <svg class="w-10 h-10 text-gray-400 dark:text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <input type="file"
                           name="products_file"
                           id="products_file"
                           accept="{{ $acceptAttr }}"
                           class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                           required>
                    <span id="file-prompt" class="text-blue-600 dark:text-blue-400">Drag & drop or click to choose file</span>
                    <span id="file-name" class="text-blue-600 dark:text-blue-400 font-medium hidden"></span>
                </div>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                    Allowed: CSV{{ $acceptTxt ? '/TXT' : '' }} (UTF‑8). Multiple gallery images can be pipe (|) or comma separated.
                </p>
                @error('products_file')
                    <span class="text-red-600 dark:text-red-400 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-4">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition flex items-center justify-center gap-2">
                    <x-icon-nav name="download" />
                    {{ $buttonText }}
                </button>
                <a href="{{ $backRoute }}" 
                    class="inline-flex items-center gap-2 bg-gray-100 dark:bg-[#23263a] hover:bg-gray-300 dark:hover:bg-[#2c3250] text-gray-600 dark:text-gray-300 border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg shadow-md transition">
                    <x-icon-nav name="back" />
                    Back
                </a>
            </div>
        </form>

        <div class="mt-10">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Tips for a Successful Import</h2>
            <ul class="list-disc ml-5 text-gray-700 dark:text-gray-200 text-sm space-y-1">
                <li>Required columns: <code>name, price, category_id</code> (or <code>category_name</code>).</li>
                <li>Optional: slug, short_description, on_sale, sale_price, compare_price, sku, stock_quantity, image (or image_url), <strong>gallery</strong>, specifications, is_active, is_featured, meta_title, meta_description.</li>
                <li>Specifications: JSON OR multiline key:value OR key=value,key=value.</li>
                <li>Ensure sale_price &lt; price when on_sale=1; compare_price &gt; price if provided.</li>
                <li>Leave slug / sku blank to auto-generate unique values.</li>
                <li>UTF-8 encoding. Prefer a text editor (VS Code) to avoid Excel delimiter changes.</li>
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

    function showFileName(name) {
        fileNameSpan.textContent = name;
        fileNameSpan.classList.remove('hidden');
        filePromptSpan.classList.add('hidden');
        dropArea.classList.add('border-blue-500','dark:border-blue-500');
    }
    function reset() {
        fileNameSpan.textContent = '';
        fileNameSpan.classList.add('hidden');
        filePromptSpan.classList.remove('hidden');
        dropArea.classList.remove('border-blue-500','dark:border-blue-500');
    }

    fileInput.addEventListener('change', function () {
        if (fileInput.files.length > 0) {
            showFileName(fileInput.files[0].name);
        } else {
            reset();
        }
    });

    ['dragenter','dragover'].forEach(ev => {
        dropArea.addEventListener(ev, e => {
            e.preventDefault();
            dropArea.classList.add('border-blue-500','dark:border-blue-500');
        });
    });
    ['dragleave','drop'].forEach(ev => {
        dropArea.addEventListener(ev, e => {
            e.preventDefault();
            if (ev === 'drop' && e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                showFileName(fileInput.files[0].name);
            }
            if (!fileInput.files.length) {
                reset();
            }
        });
    });
});
</script>
@endpush