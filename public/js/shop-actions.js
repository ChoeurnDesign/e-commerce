function addToCart(productId, btn = null, quantity = 1) {
    if (typeof window.IS_AUTH !== "undefined" && !window.IS_AUTH) {
        redirectToLogin();
        return;
    }
    if (!btn) {
        btn = document.querySelector(`.add-to-cart-btn[data-product-id="${productId}"]`);
    }
    if (!btn) return;
    const originalHTML = btn.innerHTML;
    btn.innerHTML = '⏳ Adding...';
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
            btn.innerHTML = '✅ Added!';
            btn.classList.remove('bg-red-500', 'hover:bg-red-600', 'bg-green-600', 'hover:bg-green-700', 'bg-indigo-600', 'hover:bg-indigo-700');
            btn.classList.add('bg-green-500', 'hover:bg-green-600');
            updateCartCount(data.cart_count);
            showNotification('Product added to cart! 🛒', 'success');
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
    .catch(error => {
        showNotification('Something went wrong', 'error');
        btn.innerHTML = originalHTML;
        btn.disabled = false;
    });
}

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
            if (typeof data.in_wishlist !== "undefined") {
                // For product cards
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
                // For wishlist page (remove card)
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

function showNotification(message, type = 'success') {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };

    document.querySelectorAll('.notification').forEach(n => n.remove());

    // Adjust top value to match your navbar height
    const notification = document.createElement('div');
    notification.className =
      `notification fixed left-0 right-0 z-50 w-full p-3 shadow-lg transition-all duration-300 ${colors[type] || colors.info} text-black text-center`;

    notification.innerHTML = `
      <span>${message}</span>
      <button onclick="this.parentElement.remove()" class="ml-4 text-xl font-bold leading-none hover:opacity-70">×</button>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
      notification.style.opacity = '0';
      notification.style.transform += ' scale-95';
      setTimeout(() => notification.remove(), 300);
    }, 3000);
}
function redirectToLogin() {
    window.location.href = '/login';
}
