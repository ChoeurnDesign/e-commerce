@props(['route' => '#', 'label' => 'Chat', 'badge' => null, 'unreadUrl' => null])

@php
    // Priority: explicit prop -> seller unread -> user unread -> 0
    $initial = (int) ($badge ?? $unreadSellerChats ?? $unreadUserChats ?? 0);

    // unreadUrl kept for backwards-compatibility if you later want client polling
    $unreadUrl = $unreadUrl ?? (Route::has('chat.unread-count') ? route('chat.unread-count') : '/chat/unread-count');
@endphp

<a href="{{ $route ?? '#' }}" class="relative group" aria-label="{{ $label ?? 'Chat' }}">
    <!-- Chat SVG -->
    <x-icon-nav name="chat" class="w-6 h-6 text-gray-400 group-hover:text-indigo-500 transition"/>

    <!-- Server-rendered badge: hidden when 0 -->
    <span class="chat-unread-badge absolute -top-3 -right-2 bg-red-500 text-xs text-white rounded-full w-5 h-5 inline-flex items-center justify-center leading-none {{ $initial === 0 ? 'hidden' : '' }}"
      role="status" aria-live="polite"
      data-unread="{{ $initial }}"
      data-unread-url="{{ $unreadUrl }}">
    <span class="sr-only">
        {{ $initial === 0 ? 'No unread messages' : ($initial > 99 ? '99+ unread messages' : $initial . ' unread messages') }}
    </span>
    <span aria-hidden="true" class="chat-unread-visible">{{ $initial > 99 ? '99+' : $initial }}</span>
</span>
</a>