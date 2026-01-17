<!-- Banner Slider -->
<div x-data="{
        active: 0,
        count: {{ count($banners) }},
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
    }" class="relative w-full overflow-hidden h-[420px] md:h-[600px]">

    @if(count($banners) > 0)
    <!-- Sliding images only -->
    <div class="flex h-full w-full"
        :class="{ 'transition-transform duration-1000 ease-in-out': isAnimating }"
        :style="'transform: translateX(-' + active * 100 + '%)'">

        @foreach($banners as $i => $banner)
            <div class="flex-none w-full h-full bg-cover bg-center"
                style="background-image: url('{{ asset('storage/'.$banner->image_path) }}');"></div>
        @endforeach

        <!-- Clone first banner for seamless loop -->
        <div class="flex-none w-full h-full bg-cover bg-center"
            style="background-image: url('{{ asset('storage/'.$banners[0]->image_path) }}');"></div>
    </div>

    <!-- Fixed CTA/Text Overlay (not sliding) -->
    <div class="absolute inset-0 flex items-center justify-center z-10 bg-black/30 pointer-events-none">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center text-white pointer-events-auto">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 drop-shadow-lg">
                {{ (isset($storefrontTitle) && trim($storefrontTitle) !== '') ? $storefrontTitle : 'Welcome to Our Store' }}
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                {{ (isset($welcomeMessage) && trim($welcomeMessage) !== '') 
                    ? $welcomeMessage 
                    : __('Discover amazing products at unbeatable prices. Your one-stop shop for everything you need.') }}
            </p>
            <div class="flex flex-col items-center gap-0 mt-6">
                <div class="flex flex-row gap-4 mb-4">
                    <a href="#categories"
                        class="inline-block bg-white text-indigo-600 hover:bg-indigo-50 font-bold py-2 px-6 rounded-full text-lg transition duration-300">
                        {{ __('Browse Categories') }}
                    </a>
                    <a href="#featured-products"
                        class="inline-block border-2 border-white text-white hover:bg-white hover:text-indigo-600 font-bold py-2 px-6 rounded-full text-lg transition duration-300">
                        {{ __('Shop Featured') }}
                    </a>
                </div>
                <a href="{{ route('products.shops_on_sale', ['on_sale' => 1]) }}"
                    class="inline-block bg-pink-600 text-white font-bold py-2 px-6 rounded-full text-lg transition duration-300 shadow hover:bg-pink-700">
                    {{ __('Shop On Sale') }}
                </a>
            </div>
        </div>
    </div>
    @else
    <!-- Placeholder if no banners -->
    <div class="w-full h-full flex items-center justify-center text-white bg-gray-600"
        style="background-image: url('https://via.placeholder.com/1920x600.png?text=Add+Your+First+Banner');">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 drop-shadow-lg">
                {{ (isset($storefrontTitle) && trim($storefrontTitle) !== '') ? $storefrontTitle : 'Welcome to Our Store' }}
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                {{ (isset($welcomeMessage) && trim($welcomeMessage) !== '') 
                    ? $welcomeMessage 
                    : __('Discover amazing products at unbeatable prices.') }}
            </p>
            <a href="#categories"
                class="inline-block bg-white text-indigo-600 hover:bg-indigo-50 font-bold py-2 px-6 rounded-full text-lg transition duration-300">
                {{ __('Browse Categories') }}
            </a>
        </div>
    </div>
    @endif
</div> 