{{-- Store Logo --}}
@if(setting('store_logo'))
    <div class="flex justify-center mb-4">
        <img
            src="/{{ setting('store_logo') }}"
            alt="Logo"
            class="w-20 h-20 object-contain rounded-full border border-gray-200 dark:border-gray-800"
        />
    </div>
@endif
