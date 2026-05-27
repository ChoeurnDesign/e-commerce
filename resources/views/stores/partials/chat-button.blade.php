@auth
    @if (auth()->id() !== $seller->user_id)
        <a href="{{ route('chat.startWithSeller', ['seller' => $seller->user_id]) }}"
           aria-label="Chat with {{ $seller->store_name ?? $seller->name }}"
           class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-full font-semibold shadow transition text-sm">
            <x-icon-nav name="chat" class="w-5 h-5 flex-shrink-0" />
            <span>Chat</span>
        </a>
    @endif
@else
    <a href="{{ route('login') }}"
       class="inline-flex items-center gap-2 bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-full font-semibold shadow transition text-sm">
        <x-icon-nav name="chat" class="w-5 h-5 flex-shrink-0" />
        <span>Chat</span>
    </a>
@endauth