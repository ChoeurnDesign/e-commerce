
@props([
    'banners'         => null,
    'storefrontTitle' => '',
    'welcomeMessage'  => '',
    'compact'         => false,
])

@php
    $fallbackBanners = collect([
        (object)[
            'image_path' => 'banners/banner_01.jpg',
            'title' => null,
            'subtitle' => null,
            'button_text' => null,
            'button_link' => null
        ],
        (object)[
            'image_path' => 'banners/banner_02.png',
            'title' => null,
            'subtitle' => null,
            'button_text' => null,
            'button_link' => null
        ],
    ]);

    $validBanners = collect($banners ?? [])
        ->filter(fn($b) =>
            !empty($b->image_path) &&
            file_exists(public_path('storage/' . $b->image_path))
        )
        ->values();

    $sliderBanners = $validBanners->isNotEmpty()
        ? $validBanners
        : $fallbackBanners;

    $slideCount = $sliderBanners->count();

    $themes = [
        [
            'bg' => '#FFF7ED',
            'badgeBg' => '#FED7AA',
            'badgeText' => '#EA580C',
            'btnBg' => '#F97316',
        ],
        [
            'bg' => '#EFF6FF',
            'badgeBg' => '#DBEAFE',
            'badgeText' => '#2563EB',
            'btnBg' => '#2563EB',
        ],
        [
            'bg' => '#F0FDF4',
            'badgeBg' => '#DCFCE7',
            'badgeText' => '#16A34A',
            'btnBg' => '#16A34A',
        ],
        [
            'bg' => '#FAF5FF',
            'badgeBg' => '#E9D5FF',
            'badgeText' => '#7C3AED',
            'btnBg' => '#7C3AED',
        ],
    ];
@endphp

<section
    x-data="{
        cur: 0,
        n: {{ $slideCount }},
        paused: false,
        tid: null,
        MS: 6000,

        init() {
            if (this.n > 1) {
                this.start();
            }
        },

        start() {
            clearInterval(this.tid);

            this.tid = setInterval(() => {
                if (!this.paused) {
                    this.go((this.cur + 1) % this.n);
                }
            }, this.MS);
        },

        go(i) {
            this.cur = i;

            if (this.n > 1) {
                this.start();
            }
        }
    }"
    @mouseenter="paused = true"
    @mouseleave="paused = false"
    class="relative overflow-hidden rounded-2xl
           h-[220px] sm:h-[260px] lg:h-[320px]
           bg-white border border-gray-100"
>

    {{-- SLIDES --}}
    @foreach($sliderBanners as $i => $banner)

        @php
            $ttl = trim($banner->title ?? '');
            $sub = trim($banner->subtitle ?? '');
            $btn = trim($banner->button_text ?? '');
            $url = trim($banner->button_link ?? '');

            if (!$ttl) {
                $ttl = ($i === 0 && $storefrontTitle)
                    ? $storefrontTitle
                    : __('Discover Quality Products');
            }

            if (!$sub) {
                $sub = ($i === 0 && $welcomeMessage)
                    ? $welcomeMessage
                    : __('Shop from trusted multi-vendor stores with secure payments and fast delivery.');
            }

            if (!$btn) {
                $btn = __('Shop Now');
            }

            if (!$url) {
                $url = route('products.index');
            }

            $theme = $themes[$i % count($themes)];

            $imgUrl = asset('storage/' . $banner->image_path);
        @endphp

        <div
            class="absolute inset-0 transition-all duration-700 ease-in-out"
            :class="{{ $i }} === cur
                ? 'opacity-100 z-10'
                : 'opacity-0 z-0'"
            style="background: {{ $theme['bg'] }}"
        >

            {{-- IMAGE --}}
            <img
                src="{{ $imgUrl }}"
                alt="{{ $ttl }}"
                class="absolute inset-0 w-full h-full object-cover
                       transition-transform duration-[7000ms] ease-linear"
                :class="{{ $i }} === cur
                    ? 'scale-105'
                    : 'scale-100'"
                loading="{{ $i === 0 ? 'eager' : 'lazy' }}"
                onerror="this.style.display='none'"
            >

            {{-- LIGHT OVERLAY --}}
            <div
                class="absolute inset-0"
                style="
                    background:
                    linear-gradient(
                        to right,
                        rgba(255,255,255,0.95) 0%,
                        rgba(255,255,255,0.88) 28%,
                        rgba(255,255,255,0.65) 48%,
                        rgba(255,255,255,0.20) 70%,
                        rgba(255,255,255,0) 100%
                    );
                "
            ></div>

            {{-- CONTENT --}}
            <div class="absolute inset-y-0 left-0 z-20 flex items-center">

                <div class="max-w-[420px] px-6 lg:px-10">

                    {{-- BADGE --}}
                    <span
                        class="inline-flex items-center gap-2
                               text-[11px] font-bold uppercase tracking-wide
                               px-3 py-1 rounded-full mb-4"
                        style="
                            background: {{ $theme['badgeBg'] }};
                            color: {{ $theme['badgeText'] }};
                        "
                    >
                        <span
                            class="w-1.5 h-1.5 rounded-full animate-pulse"
                            style="background: {{ $theme['badgeText'] }}"
                        ></span>

                        Featured Collection
                    </span>

                    {{-- TITLE --}}
                    <h2
                        class="text-2xl lg:text-4xl
                               leading-tight font-extrabold
                               text-gray-900 mb-3"
                    >
                        {{ $ttl }}
                    </h2>

                    {{-- SUBTITLE --}}
                    <p
                        class="text-sm lg:text-base
                               text-gray-500 leading-relaxed mb-6"
                    >
                        {{ $sub }}
                    </p>

                    {{-- BUTTONS --}}
                    <div class="flex items-center gap-3">

                        <a
                            href="{{ $url }}"
                            class="inline-flex items-center gap-2
                                   px-5 py-2.5 rounded-2xl
                                   text-sm font-bold text-white
                                   shadow-sm hover:shadow-md
                                   hover:-translate-y-0.5
                                   transition-all duration-200"
                            style="background: {{ $theme['btnBg'] }}"
                        >
                            {{ $btn }}

                            <svg
                                class="w-4 h-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>
                        </a>

                        <a
                            href="{{ route('categories.index') }}"
                            class="px-5 py-2.5 rounded-2xl
                                   border border-gray-200
                                   bg-white/80 backdrop-blur-sm
                                   text-sm font-medium text-gray-700
                                   hover:bg-white
                                   transition-all duration-200"
                        >
                            Explore
                        </a>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

    {{-- DOTS --}}
    @if($slideCount > 1)

        <div
            class="absolute bottom-4 inset-x-0 z-30
                   flex items-center justify-center gap-2"
        >

            @foreach($sliderBanners as $i => $banner)

                <button
                    @click="go({{ $i }})"
                    class="rounded-full transition-all duration-300"

                    :class="{{ $i }} === cur
                        ? 'w-7 h-2 bg-orange-500'
                        : 'w-2 h-2 bg-white/70 hover:bg-white'"
                ></button>

            @endforeach

        </div>

        {{-- PREV --}}
        <button
            @click="go((cur - 1 + n) % n)"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-30
                   w-10 h-10 rounded-full
                   bg-white/90 backdrop-blur-sm
                   border border-gray-200
                   flex items-center justify-center
                   shadow-md text-gray-700
                   opacity-0 group-hover:opacity-100
                   transition-all duration-200"
        >
            <svg
                class="w-4 h-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2.5"
                    d="M15 19l-7-7 7-7"
                />
            </svg>
        </button>

        {{-- NEXT --}}
        <button
            @click="go((cur + 1) % n)"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-30
                   w-10 h-10 rounded-full
                   bg-white/90 backdrop-blur-sm
                   border border-gray-200
                   flex items-center justify-center
                   shadow-md text-gray-700
                   opacity-0 group-hover:opacity-100
                   transition-all duration-200"
        >
            <svg
                class="w-4 h-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2.5"
                    d="M9 5l7 7-7 7"
                />
            </svg>
        </button>

    @endif

</section>

