@props(['seller', 'isFollowing' => null])

@php
    if (is_null($isFollowing)) {
        $isFollowing = auth()->check() ? auth()->user()->isFollowingSeller($seller) : false;
    }
@endphp

@auth
    @if($isFollowing)
        <form action="{{ route('stores.unfollow', $seller) }}" method="POST" class="inline" aria-live="polite">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                aria-pressed="true"
                title="Unfollow {{ $seller->store_name ?? $seller->name }}"
                class="inline-flex items-center gap-2 text-amber-400 dark:text-amber-300 transition text-lg leading-none"
            >
                Following
            </button>
        </form>
    @else
        <form action="{{ route('stores.follow', $seller) }}" method="POST" class="inline" aria-live="polite">
            @csrf
            <button
                type="submit"
                aria-pressed="false"
                title="Follow {{ $seller->store_name ?? $seller->name }}"
                class="inline-flex items-center gap-2 text-sky-500 dark:text-sky-400 transition hover:text-gray-600 dark:hover:text-gray-500 text-lg leading-none"
            >
                Follow
            </button>
        </form>
    @endif
@else
    <a
        href="{{ route('login') }}"
        aria-pressed="false"
        title="Sign in to follow {{ $seller->store_name ?? $seller->name }}"
        class="inline-flex items-center gap-2 text-sky-500 dark:text-sky-400 hover:text-gray-600 dark:hover:text-gray-500 transition text-lg leading-none"
    >

        Follow
    </a>
@endauth