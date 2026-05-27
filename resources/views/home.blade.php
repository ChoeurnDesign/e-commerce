<x-app-layout>

    <x-home.banner-slider
        :banners="$banners"
        :storefront-title="$storefrontTitle"
        :welcome-message="$welcomeMessage"
    />

    <x-home.categories-preview :parentCategories="$parentCategories" />

    <x-home.featured-products :featuredProducts="$featuredProducts" />

    <x-home.trust-section />

    {{-- Customer support chatbot --}}
    <x-chatbot />

</x-app-layout>
