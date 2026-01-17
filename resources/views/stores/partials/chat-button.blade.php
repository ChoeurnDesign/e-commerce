@auth
    {{-- Only show button if NOT seller themselves --}}
    @if (auth()->id() !== $seller->user_id)
        <a href="{{ route('chat.startWithSeller', ['seller' => $seller->id]) }}"
           aria-label="Chat with {{ $seller->store_name ?? $seller->name }}"
           class="inline-flex flex-col items-center justify-center bg-sky-600 hover:bg-sky-700 px-1 py-1 rounded-xl font-semibold shadow transition text-sm">
            <x-icon-nav name="chat" class="w-12 h-12 flex-shrink-0" />
        </a>
    @endif
@else
    <a href="{{ route('login') }}"
       class="inline-flex flex-col items-center justify-center bg-sky-600 hover:bg-sky-700 px-1 py-1 rounded-xl font-semibold shadow transition text-sm">
        <x-icon-nav name="chat" class="w-12 h-12 flex-shrink-0" />
    </a>
@endauth