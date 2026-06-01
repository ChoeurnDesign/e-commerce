{{-- Quick View Modal — triggered by showProductInfo(id) in shop-actions.js --}}
<div id="quick-view-overlay"
     onclick="if(event.target===this) closeQuickView()"
     class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm hidden">

    <div id="quick-view-modal"
         class="relative bg-white rounded-2xl shadow-2xl w-full max-w-3xl mx-4 overflow-hidden max-h-[90vh] overflow-y-auto">

        {{-- Close button --}}
        <button onclick="closeQuickView()"
                class="absolute top-4 right-4 z-10 w-9 h-9 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Loading state --}}
        <div id="qv-loading" class="flex items-center justify-center py-20">
            <svg class="animate-spin h-10 w-10 text-pink-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
        </div>

        {{-- Content (hidden until loaded) --}}
        <div id="qv-content" class="hidden grid md:grid-cols-2 gap-0">

            {{-- Image --}}
            <div class="bg-gray-50 flex items-center justify-center p-6 min-h-[280px]">
                <img id="qv-image" src="" alt=""
                     class="max-h-72 w-full object-contain rounded-xl"
                     onerror="this.onerror=null;this.src='https://placehold.co/400x400/e2e8f0/94a3b8?text=No+Image'">
            </div>

            {{-- Details --}}
            <div class="p-6 flex flex-col gap-3">

                {{-- Badges --}}
                <div id="qv-badges" class="flex flex-wrap gap-2"></div>

                {{-- Category / Seller --}}
                <div class="flex items-center justify-between">
                    <span id="qv-category" class="text-xs font-semibold text-pink-600 bg-pink-50 px-2 py-0.5 rounded-full"></span>
                    <a id="qv-seller" href="#" class="text-xs font-bold text-gray-500 hover:text-pink-600 uppercase tracking-tight transition-colors"></a>
                </div>

                {{-- Name --}}
                <h2 id="qv-name" class="text-xl font-bold text-gray-900 leading-tight"></h2>

                {{-- Price --}}
                <div class="flex items-center gap-3">
                    <span id="qv-price" class="text-2xl font-bold text-gray-900"></span>
                    <span id="qv-original-price" class="text-sm text-gray-400 line-through hidden"></span>
                </div>

                {{-- Rating --}}
                <div class="flex items-center gap-2">
                    <div id="qv-stars" class="flex text-yellow-400 gap-0.5"></div>
                    <span id="qv-reviews" class="text-sm text-gray-500"></span>
                </div>

                {{-- Description --}}
                <p id="qv-description" class="text-sm text-gray-600 leading-relaxed"></p>

                {{-- Stock --}}
                <div id="qv-stock" class="flex items-center gap-2 text-sm font-medium"></div>

                {{-- Action buttons --}}
                <div class="flex gap-3 mt-auto pt-2">
                    @auth
                        <button id="qv-add-cart"
                                onclick=""
                                type="button"
                                class="flex-1 flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white py-2.5 px-4 rounded-xl font-semibold transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Add to Cart
                        </button>
                    @else
                        <button onclick="closeQuickView(); redirectToLogin()"
                                class="flex-1 flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white py-2.5 px-4 rounded-xl font-semibold transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4"/>
                            </svg>
                            Add to Cart
                        </button>
                    @endauth
                    <a id="qv-view-link" href="#"
                       class="flex items-center justify-center gap-1.5 border border-gray-300 text-gray-700 hover:border-pink-400 hover:text-pink-600 py-2.5 px-4 rounded-xl font-semibold transition-colors text-sm">
                        View Details
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
const QV_URL = '/products/{id}/quick-view';

function showProductInfo(productId) {
    const overlay = document.getElementById('quick-view-overlay');
    const loading = document.getElementById('qv-loading');
    const content = document.getElementById('qv-content');

    // Reset state
    loading.classList.remove('hidden');
    content.classList.add('hidden');
    overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    fetch(`/products/${productId}/quick-view`, {
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(p => {
        // Image
        const img = document.getElementById('qv-image');
        img.src = p.image_url || 'https://placehold.co/400x400/e2e8f0/94a3b8?text=No+Image';
        img.alt = p.name;

        // Badges
        const badges = document.getElementById('qv-badges');
        badges.innerHTML = '';
        if (p.on_sale) badges.innerHTML += `<span class="bg-red-500 text-white text-xs px-2 py-0.5 rounded-full font-semibold">Sale</span>`;
        if (p.is_featured) badges.innerHTML += `<span class="bg-yellow-500 text-white text-xs px-2 py-0.5 rounded-full font-semibold">Featured</span>`;
        if (!p.in_stock) badges.innerHTML += `<span class="bg-gray-500 text-white text-xs px-2 py-0.5 rounded-full font-semibold">Out of Stock</span>`;

        // Category
        document.getElementById('qv-category').textContent = p.category || '';

        // Seller
        const sellerEl = document.getElementById('qv-seller');
        sellerEl.textContent = p.seller_name || '';
        sellerEl.href = p.seller_url || '#';

        // Name
        document.getElementById('qv-name').textContent = p.name;

        // Price
        const priceEl = document.getElementById('qv-price');
        const origEl  = document.getElementById('qv-original-price');
        const fmt = v => '$' + parseFloat(v).toFixed(2);
        if (p.on_sale && p.sale_price) {
            priceEl.textContent = fmt(p.sale_price);
            priceEl.className = 'text-2xl font-bold text-green-600';
            origEl.textContent = fmt(p.price);
            origEl.classList.remove('hidden');
        } else {
            priceEl.textContent = fmt(p.current_price || p.price);
            priceEl.className = 'text-2xl font-bold text-gray-900';
            origEl.classList.add('hidden');
        }

        // Stars
        const starsEl = document.getElementById('qv-stars');
        starsEl.innerHTML = '';
        for (let i = 1; i <= 5; i++) {
            const filled = i <= Math.round(p.average_rating);
            starsEl.innerHTML += `<svg class="w-4 h-4 ${filled ? 'text-yellow-400' : 'text-gray-300'}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>`;
        }
        const revText = p.reviews_count > 0
            ? `(${p.reviews_count} ${p.reviews_count === 1 ? 'review' : 'reviews'})`
            : '(No reviews yet)';
        document.getElementById('qv-reviews').textContent = revText;

        // Description
        document.getElementById('qv-description').textContent = p.short_description || '';

        // Stock status
        const stockEl = document.getElementById('qv-stock');
        if (p.in_stock) {
            stockEl.innerHTML = `<svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><span class="text-green-600">In Stock (${p.stock_quantity} available)</span>`;
        } else {
            stockEl.innerHTML = `<svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg><span class="text-red-500">Out of Stock</span>`;
        }

        // Add to cart button
        const cartBtn = document.getElementById('qv-add-cart');
        if (cartBtn) {
            cartBtn.onclick = () => { addToCart(p.id, cartBtn); };
            cartBtn.disabled = !p.in_stock;
            if (!p.in_stock) cartBtn.className = cartBtn.className.replace('bg-orange-500 hover:bg-orange-600', 'bg-gray-400 cursor-not-allowed');
        }

        // View details link
        document.getElementById('qv-view-link').href = p.url;

        // Show content
        loading.classList.add('hidden');
        content.classList.remove('hidden');
    })
    .catch(() => {
        closeQuickView();
        alert('Could not load product details. Please try again.');
    });
}

function closeQuickView() {
    document.getElementById('quick-view-overlay').classList.add('hidden');
    document.body.style.overflow = '';
}

// Close on Escape key
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeQuickView(); });
</script>

