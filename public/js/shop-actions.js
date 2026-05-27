window.IS_AUTH = window.IS_AUTH ?? false;

// ─── Inject styles (spin + dark mode notifications) ───────────────
(function injectStyles() {
    if (document.getElementById('shop-actions-style')) return;
    const style = document.createElement('style');
    style.id = 'shop-actions-style';
    style.textContent = `
        @keyframes spin {
            from { transform: rotate(0deg); }
            to   { transform: rotate(360deg); }
        }

        .js-notification { transition: opacity 0.4s ease, transform 0.4s ease; }

        /* Light mode */
        .js-notification.type-success { background:#f0fdf4; border-bottom:1px solid #86efac; color:#166534; }
        .js-notification.type-error   { background:#fef2f2; border-bottom:1px solid #fca5a5; color:#991b1b; }
        .js-notification.type-warning { background:#fffbeb; border-bottom:1px solid #fcd34d; color:#92400e; }
        .js-notification.type-info    { background:#eff6ff; border-bottom:1px solid #93c5fd; color:#1e40af; }

        .js-notification.type-success .js-bar { background:#16a34a; }
        .js-notification.type-error   .js-bar { background:#dc2626; }
        .js-notification.type-warning .js-bar { background:#d97706; }
        .js-notification.type-info    .js-bar { background:#2563eb; }

        /* Dark mode */
        .dark .js-notification.type-success { background:#052e16; border-color:#166534; color:#86efac; }
        .dark .js-notification.type-error   { background:#450a0a; border-color:#991b1b; color:#fca5a5; }
        .dark .js-notification.type-warning { background:#451a03; border-color:#92400e; color:#fcd34d; }
        .dark .js-notification.type-info    { background:#0c1a3a; border-color:#1e40af; color:#93c5fd; }

        .dark .js-notification.type-success .js-bar { background:#16a34a; }
        .dark .js-notification.type-error   .js-bar { background:#dc2626; }
        .dark .js-notification.type-warning .js-bar { background:#d97706; }
        .dark .js-notification.type-info    .js-bar { background:#2563eb; }

        .js-notification .js-close-btn { color: inherit; }
    `;
    document.head.appendChild(style);
})();


// ─── Add to Cart ──────────────────────────────────────────────────
function addToCart(productId, btn = null, quantity = 1) {
    if (!window.IS_AUTH) {
        redirectToLogin();
        return;
    }

    if (!btn) {
        btn = document.querySelector(`.add-to-cart-btn[data-product-id="${productId}"]`);
    }
    if (!btn) return;

    const originalHTML = btn.innerHTML;
    btn.innerHTML = '<i class="ti ti-loader-2" style="animation:spin 1s linear infinite; display:inline-block;"></i> Adding...';
    btn.disabled = true;

    fetch('/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity })
    })
    .then(async r => {
        const contentType = r.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            throw new Error('Not JSON');
        }
        return r.json();
    })
    .then(data => {
        if (data.success) {
            btn.innerHTML = '<i class="ti ti-check"></i> Added!';
            btn.classList.remove('bg-red-500', 'hover:bg-red-600', 'bg-green-600', 'hover:bg-green-700', 'bg-indigo-600', 'hover:bg-indigo-700');
            btn.classList.add('bg-green-500', 'hover:bg-green-600');
            updateCartCount(data.cart_count);
            showNotification('Product added to cart!', 'success');
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.classList.remove('bg-green-500', 'hover:bg-green-600');
                btn.classList.add('bg-red-500', 'hover:bg-red-600');
                btn.disabled = false;
            }, 2000);
        } else {
            showNotification(data.message || 'Error adding to cart', 'error');
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        }
    })
    .catch(() => {
        showNotification('Something went wrong', 'error');
        btn.innerHTML = originalHTML;
        btn.disabled = false;
    });
}


// ─── Toggle Wishlist ──────────────────────────────────────────────
function toggleWishlist(productId, button) {
    fetch('/wishlist/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            if (typeof data.in_wishlist !== 'undefined') {
                if (data.in_wishlist) {
                    button.classList.remove('text-gray-400');
                    button.classList.add('text-red-500');
                    button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>`;
                    showNotification('Added to favorites!', 'success');
                } else {
                    button.classList.remove('text-red-500');
                    button.classList.add('text-gray-400');
                    button.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-6 h-6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>`;
                    showNotification('Removed from favorites', 'success');
                }
                updateWishlistCount(data.wishlist_count);
            } else {
                const itemElement = button.closest('.bg-white');
                if (itemElement) {
                    itemElement.style.opacity = '0';
                    itemElement.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        itemElement.remove();
                        updateWishlistCount(data.wishlist_count);
                        if (document.querySelectorAll('.bg-white.rounded-lg.shadow-md').length === 0) {
                            setTimeout(() => location.reload(), 1000);
                        }
                    }, 300);
                }
                showNotification('Removed from wishlist', 'success');
            }
        }
    })
    .catch(() => showNotification('Something went wrong', 'error'));
}


// ─── Update Cart Count Badge ──────────────────────────────────────
function updateCartCount(count) {
    let badge = document.getElementById('cart-count');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    } else if (count > 0) {
        const cartLink = document.querySelector('a[href*="cart"]');
        if (cartLink) {
            badge = document.createElement('span');
            badge.id = 'cart-count';
            badge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium';
            badge.textContent = count;
            cartLink.appendChild(badge);
        }
    }
}


// ─── Update Wishlist Count Badge ──────────────────────────────────
function updateWishlistCount(count) {
    let badge = document.getElementById('wishlist-count');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    } else if (count > 0) {
        const heartLink = document.querySelector('a[href*="wishlist"]');
        if (heartLink) {
            badge = document.createElement('span');
            badge.id = 'wishlist-count';
            badge.className = 'absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-medium text-center';
            badge.style.lineHeight = '20px';
            badge.textContent = count;
            heartLink.appendChild(badge);
        }
    }
}


// ─── Show Notification ────────────────────────────────────────────
function showNotification(message, type = 'success') {
    const icons = {
        success: 'ti-circle-check',
        error:   'ti-circle-x',
        warning: 'ti-alert-triangle',
        info:    'ti-info-circle',
    };

    const titles = {
        success: 'Success',
        error:   'Error',
        warning: 'Warning',
        info:    'Info',
    };

    document.querySelectorAll('.js-notification').forEach(n => n.remove());

    const DURATION = 5000;

    const el = document.createElement('div');
    el.className = `js-notification type-${type}`;
    el.style.cssText = `
        position: fixed;
        top: 64px;
        left: 0;
        right: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px 48px;
        overflow: hidden;
    `;

    el.innerHTML = `
        <i class="ti ${icons[type] || icons.info}"
            style="font-size:20px; margin-right:10px; flex-shrink:0;"></i>
        <strong style="font-size:15px;">${titles[type] || titles.info}</strong>
        <span style="font-size:14px; margin-left:8px;">${message}</span>
        <button class="js-close-btn"
            onclick="this.closest('.js-notification').remove()"
            style="position:absolute; right:20px; top:50%; transform:translateY(-50%);
                   background:none; border:none; cursor:pointer; opacity:0.6; font-size:20px; line-height:1;">
            <i class="ti ti-x"></i>
        </button>
        <div class="js-bar"
            style="position:absolute; bottom:0; left:0; height:3px; width:100%;"></div>
    `;

    document.body.appendChild(el);

    const bar = el.querySelector('.js-bar');
    bar.style.transition = 'none';
    bar.style.width = '100%';

    requestAnimationFrame(() => requestAnimationFrame(() => {
        bar.style.transition = `width ${DURATION}ms linear`;
        bar.style.width = '0%';
    }));

    let timer = setTimeout(() => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(-100%)';
        setTimeout(() => el.remove(), 400);
    }, DURATION);

    el.addEventListener('mouseenter', () => {
        clearTimeout(timer);
        bar.style.transition = 'none';
    });

    el.addEventListener('mouseleave', () => {
        const remaining = (parseFloat(bar.style.width) / 100) * DURATION;
        bar.style.transition = `width ${remaining}ms linear`;
        bar.style.width = '0%';
        timer = setTimeout(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-100%)';
            setTimeout(() => el.remove(), 400);
        }, remaining);
    });
}


// ─── Redirect to Login ────────────────────────────────────────────
function redirectToLogin() {
    window.location.href = '/login';
}