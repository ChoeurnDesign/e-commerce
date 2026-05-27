<script>
document.addEventListener('DOMContentLoaded', function () {
    const TAX_RATE = {{ $cartTotals['tax_rate'] ?? 0.085 }};
    let cartChanged = false;

    // ─── Helpers ──────────────────────────────────────────────────
    function isDark() {
        return document.documentElement.classList.contains('dark');
    }

    function swalDefaults() {
        return {
            background: isDark() ? '#1f2937' : '#ffffff',
            color:      isDark() ? '#f9fafb' : '#111827',
            confirmButtonColor: '#dc2626',
            cancelButtonColor:  '#6b7280',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
        };
    }

    // ─── Confirm Remove Item ──────────────────────────────────────
    window.confirmRemove = function (event, btn) {
        event.preventDefault();
        Swal.fire({
            ...swalDefaults(),
            title: 'Remove item?',
            text: 'This item will be removed from your cart.',
            icon: 'warning',
            confirmButtonText: 'Yes, remove it',
        }).then(result => {
            if (result.isConfirmed) btn.closest('form').submit();
        });
    };

    // ─── Confirm Clear Cart ───────────────────────────────────────
    window.confirmClear = function (event, btn) {
        event.preventDefault();
        Swal.fire({
            ...swalDefaults(),
            title: 'Clear entire cart?',
            text: 'All items will be removed.',
            icon: 'warning',
            confirmButtonText: 'Yes, clear it',
        }).then(result => {
            if (result.isConfirmed) btn.closest('form').submit();
        });
    };

    // ─── Change Detection ─────────────────────────────────────────
    function checkForChanges() {
        cartChanged = false;
        document.querySelectorAll('.quantity-input').forEach(function (input) {
            if (parseInt(input.value) !== parseInt(input.getAttribute('data-original-quantity'))) {
                cartChanged = true;
            }
        });
        toggleUpdateButton();
    }

    function toggleUpdateButton() {
        const btn = document.getElementById('update-cart-btn');
        if (btn) btn.disabled = !cartChanged;
    }

    // ─── Quantity Buttons ─────────────────────────────────────────
    document.querySelectorAll('.quantity-btn').forEach(function (button) {
        button.addEventListener('click', function () {
            const action    = this.getAttribute('data-action');
            const productId = this.getAttribute('data-product-id');
            const input     = document.querySelector('input[data-product-id="' + productId + '"]');
            let currentValue = parseInt(input.value);

            if (action === 'increase') {
                const max = parseInt(this.getAttribute('data-max'));
                if (currentValue < max) {
                    input.value = currentValue + 1;
                    updateSubtotal(productId, input.value, input.getAttribute('data-price'));
                    checkForChanges();
                }
            } else if (action === 'decrease' && currentValue > 1) {
                input.value = currentValue - 1;
                updateSubtotal(productId, input.value, input.getAttribute('data-price'));
                checkForChanges();
            }
        });
    });

    // ─── Manual Input Change ──────────────────────────────────────
    document.querySelectorAll('.quantity-input').forEach(function (input) {
        input.addEventListener('change', function () {
            const productId = this.getAttribute('data-product-id');
            const price     = this.getAttribute('data-price');
            const max       = parseInt(this.getAttribute('max'));
            let quantity    = parseInt(this.value);

            if (isNaN(quantity) || quantity < 1) quantity = 1;
            if (quantity > max) quantity = max;
            this.value = quantity;

            updateSubtotal(productId, quantity, price);
            checkForChanges();
        });
    });

    // ─── Update Subtotal ──────────────────────────────────────────
    function updateSubtotal(productId, quantity, price) {
        const subtotal = quantity * price;
        const el = document.querySelector('.item-subtotal[data-product-id="' + productId + '"]');
        if (el) el.textContent = '$' + parseFloat(subtotal).toFixed(2);
        updateCartTotals();
    }

    // ─── Update Order Summary ─────────────────────────────────────
    function updateCartTotals() {
        let subtotal = 0, totalQuantity = 0;

        document.querySelectorAll('.quantity-input').forEach(function (input) {
            const quantity = parseInt(input.value);
            const price    = parseFloat(input.getAttribute('data-price'));
            subtotal       += quantity * price;
            totalQuantity  += quantity;
        });

        const tax   = subtotal * TAX_RATE;
        const total = subtotal + tax;

        const subtotalEl = document.getElementById('cart-subtotal');
        const taxEl      = document.getElementById('cart-tax');
        const totalEl    = document.getElementById('cart-total');

        if (subtotalEl) subtotalEl.textContent = '$' + subtotal.toFixed(2);
        if (taxEl)      taxEl.textContent      = '$' + tax.toFixed(2);
        if (totalEl)    totalEl.textContent     = '$' + total.toFixed(2);

        document.querySelectorAll('h2').forEach(function (h2) {
            if (h2.textContent.startsWith('Cart')) {
                h2.textContent = `Cart (${totalQuantity} items)`;
            }
        });
    }

    // ─── Update Cart Button ───────────────────────────────────────
    const updateBtn = document.getElementById('update-cart-btn');
    if (updateBtn) {
        updateBtn.addEventListener('click', function () {
            if (!cartChanged) return;

            const quantities = {};
            document.querySelectorAll('.quantity-input').forEach(function (input) {
                quantities[input.getAttribute('data-product-id')] = parseInt(input.value);
            });

            this.disabled = true;
            this.innerHTML = '<i class="ti ti-loader-2" style="animation:spin 1s linear infinite; display:inline-block;"></i> Updating...';

            fetch('{{ route("cart.update") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantities: quantities })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelectorAll('.quantity-input').forEach(function (input) {
                        input.setAttribute('data-original-quantity', input.value);
                    });
                    cartChanged = false;
                    toggleUpdateButton();
                    setTimeout(() => location.reload(), 800);
                } else {
                    showNotification(data.message || 'Failed to update cart.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Something went wrong.', 'error');
            })
            .finally(() => {
                this.disabled = false;
                this.innerHTML = 'Update Cart';
            });
        });
    }

    checkForChanges();
});
</script>