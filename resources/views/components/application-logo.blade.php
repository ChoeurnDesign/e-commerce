{{-- Store Logo --}}
@if(setting('store_logo'))
    <div class="flex justify-center mb-4">
        <div class="w-20 h-20 rounded-full overflow-hidden border border-gray-200 dark:border-gray-800 bg-white">
            <img
                src="{{ asset(setting('store_logo')) }}"
                alt="Logo"
                class="w-full h-full object-cover"
            />
        </div>
    </div>
@endif