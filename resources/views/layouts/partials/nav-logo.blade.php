<a href="{{ route('home') }}" class="flex items-center space-x-2 min-w-0">
    <div class="w-12 h-12 rounded-full bg-white overflow-hidden flex items-center justify-center shrink-0">
        @if(!empty($settings['store_logo']))
            <img
                src="{{ asset($settings['store_logo']) }}"
                alt="Logo"
                class="w-full h-full object-cover object-center"
            />
        @endif
    </div>

    <span class="text-xl font-bold text-[#8b5cf6] dark:text-[#a78bfa] truncate">
        {{ $settings['store_name'] }}
    </span>
</a>