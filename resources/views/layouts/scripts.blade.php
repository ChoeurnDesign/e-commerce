<script>
// CSRF Token
window.Laravel = { csrfToken: '{{ csrf_token() }}' };
window.IS_AUTH = {{ auth()->check() ? 'true' : 'false' }};

document.addEventListener('DOMContentLoaded', function () {

    // ─── Search suggestions ────────────────────────────────────────
    const searchInput       = document.getElementById('search-input');
    const suggestionsDiv    = document.getElementById('search-suggestions');

    searchInput?.addEventListener('input', function () {
        const query = this.value.trim();
        if (query.length < 2) {
            suggestionsDiv?.classList.add('hidden');
            return;
        }

        fetch(`/products/search-suggestions?q=${encodeURIComponent(query)}`)
            .then(r => r.json())
            .then(data => {
                if (!suggestionsDiv) return;
                if (data.length > 0) {
                    suggestionsDiv.innerHTML = data.map(p => `
                        <div class="p-3 hover:bg-gray-100 dark:hover:bg-gray-700 border-b cursor-pointer transition-colors"
                             onclick="window.location.href='/products/${p.slug}'">
                            <div class="flex items-center gap-3">
                                <img src="${p.image}" alt="${p.name}" class="w-10 h-10 object-cover rounded">
                                <div>
                                    <div class="font-medium text-sm">${p.name}</div>
                                    <div class="text-xs text-gray-500">$${p.price}</div>
                                </div>
                            </div>
                        </div>
                    `).join('');
                    suggestionsDiv.classList.remove('hidden');
                } else {
                    suggestionsDiv.classList.add('hidden');
                }
            })
            .catch(() => suggestionsDiv?.classList.add('hidden'));
    });

    searchInput?.addEventListener('keypress', function (e) {
        if (e.key === 'Enter' && this.value.trim()) {
            window.location.href = `/products?search=${encodeURIComponent(this.value.trim())}`;
        }
    });

    document.addEventListener('click', function (e) {
        if (!e.target.closest('#search-input') && !e.target.closest('#search-suggestions')) {
            suggestionsDiv?.classList.add('hidden');
        }
    });

    // ─── Mobile menu ───────────────────────────────────────────────
    document.getElementById('mobile-menu-btn')?.addEventListener('click', function () {
        document.getElementById('mobile-menu')?.classList.toggle('hidden');
    });

    // ─── Language switcher ─────────────────────────────────────────
    document.getElementById('language-switcher')?.addEventListener('change', function () {
        fetch('/language/switch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            },
            body: JSON.stringify({ locale: this.value })
        })
        .then(r => r.json())
        .then(data => { if (data.success) location.reload(); })
        .catch(err => console.error('Language switch error:', err));
    });

    // ─── Currency switcher ─────────────────────────────────────────
    document.getElementById('currency-switcher')?.addEventListener('change', function () {
        fetch('/currency/switch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.Laravel.csrfToken
            },
            body: JSON.stringify({ currency: this.value })
        })
        .then(r => r.json())
        .then(data => { if (data.success) location.reload(); })
        .catch(err => console.error('Currency switch error:', err));
    });

    // ─── Timezone detect ───────────────────────────────────────────
    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
    localStorage.setItem('userTimezone', tz);

    // ─── Hide loading spinners ─────────────────────────────────────
    document.querySelectorAll('.loading').forEach(el => el.style.display = 'none');

    console.log('ShopExpress initialized | tz:', tz);
});

// ─── Timezone formatter (global) ──────────────────────────────────
window.formatTimeInUserTimezone = function (utcTime) {
    return new Date(utcTime).toLocaleString('en-US', {
        timeZone: localStorage.getItem('userTimezone') || 'UTC',
        hour12: false,
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>