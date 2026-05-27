@php
    // 1) Fallback banners (must exist in storage/app/public/banners/)
    $fallbackBanners = collect([
        (object) ['image_path' => 'banners/banner_01.jpg'],
        (object) ['image_path' => 'banners/banner_02.png'],
    ]);

    // 2) DB banners that have real files (public/storage/<image_path>)
    $validBanners = collect($banners ?? [])
        ->filter(fn ($b) => !empty($b->image_path) && file_exists(public_path('storage/' . $b->image_path)))
        ->values();

    // 3) Decide which to use
    $sliderBanners = $validBanners->isNotEmpty() ? $validBanners : $fallbackBanners;

    // 4) Safe count
    $slideCount = $sliderBanners->count();
@endphp

<!-- Banner Slider -->
<div
    x-data="{
        active: 0,
        count: {{ $slideCount }},
        isAnimating: true,
        init() {
            if (this.count > 1) {
                setInterval(() => {
                    this.active++;
                    if (this.active > this.count) {
                        this.isAnimating = false;
                        this.active = 0;
                        this.$nextTick(() => {
                            this.isAnimating = true;
                            this.active++;
                        });
                    }
                }, 4000);
            }
        }
    }"
    class="relative w-full overflow-hidden h-[260px] sm:h-[380px] md:h-[560px]"
>
    <!-- Sliding images -->
    <div
        class="flex h-full w-full"
        :class="{ 'transition-transform duration-1000 ease-in-out': isAnimating }"
        :style="'transform: translateX(-' + active * 100 + '%)'"
    >
        @foreach($sliderBanners as $banner)
            <div
                class="flex-none w-full h-full bg-cover bg-center"
                style="background-image: url('{{ asset('storage/' . $banner->image_path) }}');"
            ></div>
        @endforeach

        @if($slideCount > 1)
            <!-- Clone first banner for seamless loop -->
            <div
                class="flex-none w-full h-full bg-cover bg-center"
                style="background-image: url('{{ asset('storage/' . $sliderBanners[0]->image_path) }}');"
            ></div>
        @endif
    </div>

    <!-- Fixed CTA/Text Overlay -->
    <div class="absolute inset-0 flex items-center justify-center z-10 bg-black/35 pointer-events-none">
        <div class="w-full max-w-7xl mx-auto px-5 sm:px-8 lg:px-8 py-6 sm:py-14 md:py-24 text-center text-white pointer-events-auto">

            <h1 class="text-xl sm:text-4xl md:text-5xl font-bold mb-2 sm:mb-4 drop-shadow-lg leading-tight">
                {{ (isset($storefrontTitle) && trim($storefrontTitle) !== '') ? $storefrontTitle : 'Welcome to Our Store' }}
            </h1>

            <p class="text-xs sm:text-base md:text-xl mb-4 sm:mb-7 max-w-2xl mx-auto opacity-95 leading-relaxed hidden sm:block">
                {{ (isset($welcomeMessage) && trim($welcomeMessage) !== '')
                    ? $welcomeMessage
                    : __('Discover amazing products at unbeatable prices. Your one-stop shop for everything you need.') }}
            </p>

            <div class="flex flex-col items-center gap-2 sm:gap-3 mt-2 sm:mt-4">
                <div class="flex flex-row gap-2 sm:gap-4">
                    <a href="#categories"
                       class="inline-block bg-white text-indigo-600 hover:bg-indigo-50 font-semibold
                              py-1.5 px-3 sm:py-2 sm:px-6 rounded-full
                              text-xs sm:text-sm md:text-base
                              transition duration-300 shadow-md">
                        {{ __('Browse Categories') }}
                    </a>

                    <a href="#featured-products"
                       class="inline-block border-2 border-white text-white hover:bg-white hover:text-indigo-600 font-semibold
                              py-1.5 px-3 sm:py-2 sm:px-6 rounded-full
                              text-xs sm:text-sm md:text-base
                              transition duration-300">
                        {{ __('Shop Featured') }}
                    </a>
                </div>

                <a href="{{ route('products.shops_on_sale', ['on_sale' => 1]) }}"
                   class="inline-block bg-pink-600 text-white font-semibold
                          py-1.5 px-4 sm:py-2 sm:px-6 rounded-full
                          text-xs sm:text-sm md:text-base
                          transition duration-300 shadow hover:bg-pink-700">
                    {{ __('Shop On Sale') }}
                </a>
            </div>
        </div>
    </div>
</div>
