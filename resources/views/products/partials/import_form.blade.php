@php
    $title         = $title         ?? 'Import Products';
    $buttonText    = $buttonText    ?? 'Import Products';
    $templateRoute = $templateRoute ?? asset('sample-template-seller.csv');
    $maxSizeMB     = $maxSizeMB     ?? 10;
    $acceptTxt     = $acceptTxt     ?? true;
    $acceptAttr    = $acceptTxt ? '.csv,.txt,text/csv' : '.csv,text/csv';
@endphp

{{-- ══ Page header ══ --}}
<div class="flex items-center justify-between mb-6 flex-wrap gap-4">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center">
            <svg class="w-5 h-5 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
    </div>
    <a href="{{ $backRoute }}"
       class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-pink-600 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Products
    </a>
</div>

{{-- ══ Import result: success summary ══ --}}
@if(session('import_summary'))
    @php $summary = session('import_summary'); @endphp
    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-semibold text-green-800">Import Complete</span>
        </div>
        <div class="grid grid-cols-3 gap-4 text-center">
            <div class="bg-white rounded-lg py-3 px-2 border border-green-100">
                <div class="text-2xl font-bold text-green-600">{{ $summary['rows'] ?? 0 }}</div>
                <div class="text-xs text-gray-500 mt-0.5">Total Rows</div>
            </div>
            <div class="bg-white rounded-lg py-3 px-2 border border-green-100">
                <div class="text-2xl font-bold text-pink-600">{{ $summary['imported'] ?? 0 }}</div>
                <div class="text-xs text-gray-500 mt-0.5">Imported</div>
            </div>
            <div class="bg-white rounded-lg py-3 px-2 border border-green-100">
                <div class="text-2xl font-bold text-amber-500">{{ $summary['skipped'] ?? 0 }}</div>
                <div class="text-xs text-gray-500 mt-0.5">Skipped</div>
            </div>
        </div>
    </div>
@endif

{{-- ══ Import result: row errors ══ --}}
@if(session('import_errors') && count(session('import_errors')))
    <div class="mb-6 bg-amber-50 border border-amber-200 rounded-xl p-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            <span class="font-semibold text-amber-800">Skipped rows — please review:</span>
        </div>
        <ul class="space-y-1.5">
            @foreach(session('import_errors') as $err)
                <li class="flex items-start gap-2 text-sm text-amber-800">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $err }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ══ Left col: steps + upload form ══ --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Steps --}}
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-4">How to Import</h2>
            <ol class="space-y-3">
                <li class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-pink-100 text-pink-700 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">1</span>
                    <span class="text-sm text-gray-700">
                        Download the <a href="{{ $templateRoute }}" class="text-pink-600 underline font-medium hover:text-pink-700">sample CSV template</a> and open it in a text editor (VS Code recommended).
                    </span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-pink-100 text-pink-700 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">2</span>
                    <span class="text-sm text-gray-700">
                        Upload your product images first via the <a href="{{ route('seller.images.index') }}" class="text-pink-600 underline font-medium hover:text-pink-700">Image Gallery</a>. Then copy the filenames shown there into your CSV <code class="bg-pink-50 px-1 rounded text-pink-700">image</code> and <code class="bg-pink-50 px-1 rounded text-pink-700">gallery</code> columns.
                    </span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-pink-100 text-pink-700 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">3</span>
                    <span class="text-sm text-gray-700">Fill in all required columns: <code class="bg-pink-50 px-1 rounded text-pink-700">name</code>, <code class="bg-pink-50 px-1 rounded text-pink-700">price</code>, <code class="bg-pink-50 px-1 rounded text-pink-700">category_id</code>.</span>
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-6 h-6 rounded-full bg-pink-100 text-pink-700 text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">4</span>
                    <span class="text-sm text-gray-700">Upload your completed CSV file below and click <strong>Import Products</strong>.</span>
                </li>
            </ol>
        </div>

        {{-- Upload form --}}
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-4">Upload CSV File</h2>

            <form action="{{ $formAction }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Drop zone --}}
                <div id="file-drop-area"
                     class="relative border-2 border-dashed border-pink-200 rounded-xl p-8 flex flex-col items-center justify-center cursor-pointer transition-colors hover:border-pink-400 hover:bg-pink-50 group">

                    <input type="file"
                           name="products_file"
                           id="products_file"
                           accept="{{ $acceptAttr }}"
                           class="absolute inset-0 opacity-0 cursor-pointer w-full h-full"
                           required>

                    <div id="drop-icon" class="mb-3 w-14 h-14 rounded-full bg-pink-100 flex items-center justify-center group-hover:bg-pink-200 transition-colors">
                        <svg class="w-7 h-7 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                    </div>

                    <p id="file-prompt" class="text-sm font-medium text-pink-600">Click or drag & drop your CSV file here</p>
                    <p class="text-xs text-gray-400 mt-1">CSV or TXT · UTF-8 encoding · max {{ $maxSizeMB }}MB</p>

                    <div id="file-selected" class="hidden items-center gap-3 mt-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span id="file-name" class="text-sm font-semibold text-gray-800"></span>
                        <button type="button" id="file-clear" class="text-xs text-red-500 hover:underline">Remove</button>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-pink-600 hover:bg-pink-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-sm transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                        {{ $buttonText }}
                    </button>
                    <a href="{{ $templateRoute }}"
                       class="inline-flex items-center gap-2 text-sm text-pink-600 hover:text-pink-700 font-medium border border-pink-200 px-4 py-2.5 rounded-xl hover:bg-pink-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Template
                    </a>
                </div>
            </form>
        </div>

        {{-- Tips --}}
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-3">Column Reference</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-pink-50 text-left">
                            <th class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase rounded-tl-lg">Column</th>
                            <th class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">Required</th>
                            <th class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase rounded-tr-lg">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-pink-50">
                        @foreach([
                            ['name',              true,  'Product title'],
                            ['price',             true,  'Numeric, e.g. 29.99'],
                            ['category_id',       true,  'Numeric ID or use category_name'],
                            ['category_name',     false, 'Alternative to category_id'],
                            ['description',       false, 'Full product description'],
                            ['short_description', false, 'Short summary'],
                            ['sku',               false, 'Auto-generated if blank'],
                            ['slug',              false, 'Auto-generated if blank'],
                            ['stock_quantity',    false, 'Integer, default 0'],
                            ['on_sale',           false, '1 = yes, 0 = no'],
                            ['sale_price',        false, 'Must be less than price when on_sale=1'],
                            ['compare_price',     false, 'Must be greater than price'],
                            ['image',             false, 'Filename from Image Gallery (main)'],
                            ['gallery',           false, 'Pipe-separated filenames from Image Gallery'],
                            ['specifications',    false, 'JSON or Key:Value per line'],
                            ['is_active',         false, '1 = active (default), 0 = inactive'],
                            ['is_featured',       false, '1 = featured, 0 = normal'],
                        ] as [$col, $req, $note])
                        <tr class="hover:bg-pink-50">
                            <td class="px-3 py-2 font-mono text-xs text-pink-700 bg-pink-50/50">{{ $col }}</td>
                            <td class="px-3 py-2">
                                @if($req)
                                    <span class="text-xs font-semibold text-red-500">Required</span>
                                @else
                                    <span class="text-xs text-gray-400">Optional</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-gray-600 text-xs">{{ $note }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ══ Right col: image gallery quick-reference ══ --}}
    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-pink-100 shadow-sm p-5 sticky top-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-semibold text-gray-800">Your Uploaded Images</h2>
                <a href="{{ route('seller.images.index') }}"
                   class="text-xs text-pink-600 hover:underline font-medium">Manage →</a>
            </div>
            <p class="text-xs text-gray-500 mb-4">Click <strong>Copy</strong> on any filename and paste it into your CSV's <code class="bg-pink-50 px-1 rounded text-pink-700">image</code> or <code class="bg-pink-50 px-1 rounded text-pink-700">gallery</code> column.</p>

            @php
                $myImages = \App\Models\Image::where('user_id', auth()->id())
                    ->latest()->limit(20)->get();
            @endphp

            @if($myImages->isEmpty())
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-2 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p class="text-xs">No images uploaded yet.</p>
                    <a href="{{ route('seller.images.index') }}" class="mt-2 inline-block text-xs text-pink-600 underline">Upload Images</a>
                </div>
            @else
                <div class="space-y-2 max-h-[520px] overflow-y-auto pr-1">
                    @foreach($myImages as $img)
                    @php $filename = basename($img->path); @endphp
                    <div class="flex items-center gap-2 p-2 rounded-lg hover:bg-pink-50 border border-transparent hover:border-pink-100 transition group">
                        <img src="{{ asset($img->path) }}" alt="{{ $filename }}"
                             class="w-10 h-10 object-cover rounded-lg border border-pink-100 shrink-0"
                             onerror="this.src='https://placehold.co/80x80/fce7f3/db2777?text=?'">
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-mono text-gray-700 truncate" title="{{ $filename }}">{{ $filename }}</p>
                            <span class="text-[10px] {{ $img->type === 'main' ? 'text-blue-500' : 'text-purple-500' }}">
                                {{ ucfirst($img->type) }}
                            </span>
                        </div>
                        <button type="button"
                                data-copy="{{ $filename }}"
                                class="shrink-0 text-[11px] px-2 py-1 rounded-lg bg-pink-100 text-pink-700 hover:bg-pink-200 transition font-medium opacity-0 group-hover:opacity-100">
                            Copy
                        </button>
                    </div>
                    @endforeach
                </div>
                @if($myImages->count() === 20)
                    <p class="text-xs text-gray-400 mt-3 text-center">Showing latest 20 · <a href="{{ route('seller.images.index') }}" class="text-pink-600 underline">See all</a></p>
                @endif
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fileInput    = document.getElementById('products_file');
    const dropArea     = document.getElementById('file-drop-area');
    const filePrompt   = document.getElementById('file-prompt');
    const fileSelected = document.getElementById('file-selected');
    const fileNameEl   = document.getElementById('file-name');
    const fileClear    = document.getElementById('file-clear');

    function showFile(name) {
        filePrompt.classList.add('hidden');
        fileSelected.classList.remove('hidden');
        fileSelected.classList.add('flex');
        fileNameEl.textContent = name;
        dropArea.classList.add('border-pink-400', 'bg-pink-50');
    }

    function clearFile() {
        fileInput.value = '';
        filePrompt.classList.remove('hidden');
        fileSelected.classList.add('hidden');
        fileSelected.classList.remove('flex');
        fileNameEl.textContent = '';
        dropArea.classList.remove('border-pink-400', 'bg-pink-50');
    }

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length) showFile(fileInput.files[0].name);
        else clearFile();
    });

    fileClear.addEventListener('click', (e) => { e.stopPropagation(); clearFile(); });

    ['dragenter', 'dragover'].forEach(ev => {
        dropArea.addEventListener(ev, e => { e.preventDefault(); dropArea.classList.add('border-pink-400', 'bg-pink-50'); });
    });
    ['dragleave', 'drop'].forEach(ev => {
        dropArea.addEventListener(ev, e => {
            e.preventDefault();
            if (ev === 'drop' && e.dataTransfer.files.length) {
                // Assign files to input via DataTransfer
                try { fileInput.files = e.dataTransfer.files; } catch(err) {}
                showFile(e.dataTransfer.files[0].name);
            } else if (ev === 'dragleave' && !fileInput.files.length) {
                dropArea.classList.remove('border-pink-400', 'bg-pink-50');
            }
        });
    });

    // Copy filename buttons
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-copy]');
        if (!btn) return;
        const text = btn.dataset.copy;
        const copy = () => {
            const ta = document.createElement('textarea');
            ta.value = text; document.body.appendChild(ta); ta.select();
            try { document.execCommand('copy'); } catch(err) {}
            document.body.removeChild(ta);
        };
        navigator.clipboard ? navigator.clipboard.writeText(text).catch(copy) : copy();
        const original = btn.textContent;
        btn.textContent = 'Copied!';
        btn.classList.add('bg-green-100', 'text-green-700');
        setTimeout(() => { btn.textContent = original; btn.classList.remove('bg-green-100', 'text-green-700'); }, 1200);
    });
});
</script>
@endpush
