@php
    $docPath = $seller->business_document;
@endphp

<div class="mb-6 bg-white dark:bg-[#23263a] p-6 rounded shadow">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Business Document</h3>

    @if($docPath && Storage::disk('public')->exists($docPath))
        <a href="{{ Storage::disk('public')->url($docPath) }}"
           target="_blank"
           class="text-indigo-600 hover:underline text-sm">
            View / Download
        </a>
    @else
        <div class="text-gray-500 text-sm">No document uploaded.</div>
    @endif
</div>