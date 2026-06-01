{{--
    Global inline validation-error banner for the seller panel.
    Included once in layouts/seller.blade.php inside <main>.

    Session flash messages (success / error / warning / info) are handled separately
    by layouts/flash-messages.blade.php which fires SweetAlert2 toast notifications.
    This partial only renders inline banners for Laravel $errors (form validation),
    so users can see all field errors clearly without them auto-dismissing.
--}}

@if($errors->any())
<div x-data="{ show: true }"
     x-show="show"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 -translate-y-1"
     x-transition:enter-end="opacity-100 translate-y-0"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="mb-5 flex items-start gap-3 px-4 py-3 rounded-xl border bg-red-50 border-red-200 text-red-800 text-sm shadow-sm">

    <span class="shrink-0 mt-0.5 text-red-500">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </span>

    <div class="flex-1">
        <p class="font-semibold mb-1">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    <button @click="show = false"
            class="shrink-0 text-red-400 hover:text-red-600 transition"
            aria-label="Dismiss">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>
@endif
