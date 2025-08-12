<a href="{{ route('home') }}" class="flex items-center space-x-2">
    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-white">
        @if(!empty($settings['store_logo']))
            <img
                src="{{ asset($settings['store_logo']) }}"
                alt="Logo"
                class="w-full h-full object-contain rounded-full border border-violet-400"
            />
        @endif
    </div>
    <span class="text-xl font-bold text-[#8b5cf6] dark:text-[#a78bfa]">
        {{ $settings['store_name'] }}
    </span>
</a>
