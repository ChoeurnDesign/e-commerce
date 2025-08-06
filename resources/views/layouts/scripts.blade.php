<script>
    // CSRF Token Setup
    window.Laravel = { csrfToken: '{{ csrf_token() }}' };

    // Search functionality
    document.getElementById('search-input')?.addEventListener('input', function(e) {
        const query = e.target.value;
        const suggestionsDiv = document.getElementById('search-suggestions');

        if (query.length < 2) {
            suggestionsDiv?.classList.add('hidden');
            return;
        }

        fetch(`/products/search-suggestions?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let html = '';
                    data.forEach(product => {
                        html += `
                            <div class="p-3 hover:bg-gray-300 border-b cursor-pointer" onclick="window.location.href='/products/${product.slug}'">
                                <div class="flex items-center">
                                    <img src="${product.image}" alt="${product.name}" class="w-10 h-10 object-cover rounded mr-3">
                                    <div>
                                        <div class="font-medium">${product.name}</div>
                                        <div class="text-sm text-gray-600">$${product.price}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    suggestionsDiv.innerHTML = html;
                    suggestionsDiv.classList.remove('hidden');
                } else {
                    suggestionsDiv?.classList.add('hidden');
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                suggestionsDiv?.classList.add('hidden');
            });
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#search-input') && !e.target.closest('#search-suggestions')) {
            document.getElementById('search-suggestions')?.classList.add('hidden');
        }
    });

    // Mobile menu toggle
    document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu?.classList.toggle('hidden');
    });

    // Language Switcher
    document.getElementById('language-switcher')?.addEventListener('change', function(e) {
        const locale = e.target.value;

        fetch('/language/switch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ locale: locale })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Language switch error:', error));
    });

    // Currency Switcher
    document.getElementById('currency-switcher')?.addEventListener('change', function(e) {
        const currency = e.target.value;

        fetch('/currency/switch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ currency: currency })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Currency switch error:', error));
    });

    // Global Cart Functions
    function addToCart(productId, quantity = 1) {
        if (!{{ auth()->check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }

        fetch('/cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount(data.cart_count);
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message || 'Error adding to cart', 'error');
            }
        })
        .catch(error => {
            console.error('Cart error:', error);
            showNotification('Something went wrong', 'error');
        });
    }

    // Global Wishlist Functions
    function toggleWishlist(productId, button) {
        if (!{{ auth()->check() ? 'true' : 'false' }}) {
            window.location.href = '/login';
            return;
        }

        fetch('/wishlist/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update button appearance
                if (button) {
                    button.classList.toggle('active');
                    button.textContent = data.in_wishlist ? '❤️' : '🤍';
                }

                // Update wishlist count
                updateWishlistCount(data.wishlist_count);

                // Show notification
                showNotification(data.message, 'success');
            }
        })
        .catch(error => {
            console.error('Wishlist error:', error);
            showNotification('Something went wrong', 'error');
        });
    }

    // Update Cart Count
    function updateCartCount(count) {
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            cartCount.textContent = count;
            cartCount.style.display = count > 0 ? 'block' : 'none';
        }
    }

    // Update Wishlist Count
    function updateWishlistCount(count) {
        const wishlistCount = document.getElementById('wishlist-count');
        if (wishlistCount) {
            wishlistCount.textContent = count;
            wishlistCount.style.display = count > 0 ? 'block' : 'none';
        }
    }

    // Global Notification System
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => notification.remove());

        const notification = document.createElement('div');
        notification.className =
            `notification fixed left-1/2 top-20 transform -translate-x-1/2 z-50 w-fit max-w-xl p-4 rounded-lg shadow-lg transition-all duration-300 text-center ${getNotificationClasses(type)}`;

        // The important part: add 'justify-center' to flex container
        notification.className =
         `notification fixed left-1/2 top-20 transform -translate-x-1/2 z-50 max-w-xl w-full p-4 rounded-lg shadow-lg transition-all duration-300 text-center ${getNotificationClasses(type)}`;

        notification.innerHTML = `
            <span class="text-lg">${getNotificationIcon(type)}</span>
            <span class="ml-2">${message}</span>
            <button onclick="this.parentElement.remove()" class="ml-2 inline-block align-middle hover:opacity-70" style="vertical-align:middle;">
                <svg class="w-4 h-4 inline" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        `;
        document.body.appendChild(notification);

        // Auto-hide after 5 seconds
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateY(-20px)';
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    function getNotificationClasses(type) {
        const classes = {
            'success': 'bg-green-500 text-white',
            'error': 'bg-red-500 text-white',
            'warning': 'bg-yellow-500 text-white',
            'info': 'bg-blue-500 text-white'
        };
        return classes[type] || classes.info;
    }

    function getNotificationIcon(type) {
        const icons = {
            'success': '✅',
            'error': '❌',
            'warning': '⚠️',
            'info': 'ℹ️'
        };
        return icons[type] || icons.info;
    }

    // Enter key search
    document.getElementById('search-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const query = e.target.value;
            if (query.trim()) {
                window.location.href = `/products?search=${encodeURIComponent(query)}`;
            }
        }
    });

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Hide loading indicators
        const loadingElements = document.querySelectorAll('.loading');
        loadingElements.forEach(element => element.style.display = 'none');

        // Initialize tooltips or other components if needed
        console.log('ShopExpress initialized successfully');
    });
</script>
