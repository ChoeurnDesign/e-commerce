@props([
    'seller',
    'isFollowing' => null,
    'buttonClass' => '',
    'showCount' => true,
])

@php
    if (is_null($isFollowing)) {
        $isFollowing = auth()->check() ? auth()->user()->isFollowingSeller($seller) : false;
    }
    $initialCount = $seller->followers_count ?? ($seller->followers()->count() ?? 0);
@endphp

<div
    x-data="{
        following: {{ $isFollowing ? 'true' : 'false' }},
        count: {{ $initialCount }},
        loading: false,
        async toggle() {
            if (this.loading) return;

            @if(!auth()->check())
                window.location = '{{ route('login') }}';
                return;
            @endif

            this.loading = true;
            const url = `/stores/{{ $seller->id }}/follow`;
            const method = this.following ? 'DELETE' : 'POST';

            try {
                const res = await fetch(url, {
                    method,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                });
                const data = await res.json().catch(() => null);

                if (res.ok && data) {
                    if (typeof data.followers_count !== 'undefined') {
                        this.count = data.followers_count;
                    } else {
                        this.count = this.following ? Math.max(0, this.count - 1) : this.count + 1;
                    }
                    this.following = !!data.following ?? !this.following;
                }
            } catch (err) {
                // optional: show error
            } finally {
                this.loading = false;
            }
        }
    }"
    class="inline-flex items-center gap-3 w-full"
>
    <button
        type="button"
        @click="toggle()"
        :disabled="loading"
        :aria-pressed="following.toString()"
        x-bind:class="[
            following
                ? 'bg-amber-400 text-slate-900'
                : 'bg-sky-600 text-white',
            loading ? 'opacity-70 cursor-not-allowed' : ''
        ]"
        class="{{ $buttonClass }} inline-flex items-center justify-center gap-2 px-4 py-1.5 rounded-full font-semibold transition focus:outline-none shadow-md"
    >
        <span x-show="!loading" x-text="following ? 'Following' : 'Follow'"></span>
        <span x-show="loading" aria-hidden="true">Updating…</span>
    </button>

    @if($showCount)
        <span class="text-sm text-slate-400" x-text="count + (count === 1 ? ' follower' : ' followers')"></span>
    @endif
</div>