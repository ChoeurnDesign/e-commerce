<script>
document.addEventListener('DOMContentLoaded', function() {
    const TAX_RATE = {{ $cartTotals['tax_rate'] ?? 0.085 }};
    let cartChanged = false;

    function checkForChanges() {
        cartChanged = false;
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            if (parseInt(input.value) !== parseInt(input.getAttribute('data-original-quantity'))) {
                cartChanged = true;
            }
        });
        toggleUpdateButton();
    }

    function toggleUpdateButton() {
        const btn = document.getElementById('update-cart-btn');
        if (btn) {
            btn.disabled = !cartChanged;
        }
    }

    // Quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(function(button) {
        button.addEventListener('click', function() {
            const action = this.getAttribute('data-action');
            const productId = this.getAttribute('data-product-id');
            const input = document.querySelector('input[data-product-id="' + productId + '"]');
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

    // Input change
    document.querySelectorAll('.quantity-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const productId = this.getAttribute('data-product-id');
            const price = this.getAttribute('data-price');
            const max = parseInt(this.getAttribute('max'));
            let quantity = parseInt(this.value);

            if (isNaN(quantity) || quantity < 1) quantity = 1;
            if (quantity > max) quantity = max;
            this.value = quantity;

            updateSubtotal(productId, quantity, price);
            checkForChanges();
        });
    });

    function updateSubtotal(productId, quantity, price) {
        const subtotal = quantity * price;
        const subtotalElement = document.querySelector('.item-subtotal[data-product-id="' + productId + '"]');
        if (subtotalElement) {
            subtotalElement.textContent = '$' + subtotal.toFixed(2);
        }
        updateCartTotals();
    }

    function updateCartTotals() {
        let subtotal = 0, totalQuantity = 0;

        document.querySelectorAll('.quantity-input').forEach(function(input) {
            const quantity = parseInt(input.value);
            const price = parseFloat(input.getAttribute('data-price'));
            subtotal += quantity * price;
            totalQuantity += quantity;
        });

        const tax = subtotal * TAX_RATE;
        const total = subtotal + tax;

        document.getElementById('cart-subtotal').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('cart-tax').textContent = '$' + tax.toFixed(2);
        document.getElementById('cart-total').textContent = '$' + total.toFixed(2);
        // Update cart item count in the summary
        document.querySelectorAll('h2').forEach(function(h2) {
            if (h2.textContent.startsWith('Cart')) {
                h2.textContent = `Cart (${totalQuantity} items)`;
            }
        });
    }

    // Update Cart button
    document.getElementById('update-cart-btn').addEventListener('click', function() {
        if (!cartChanged) return;

        const quantities = {};
        document.querySelectorAll('.quantity-input').forEach(function(input) {
            quantities[input.getAttribute('data-product-id')] = parseInt(input.value);
        });

        this.disabled = true;
        this.textContent = 'Updating...';

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
                document.querySelectorAll('.quantity-input').forEach(function(input) {
                    input.setAttribute('data-original-quantity', input.value);
                });
                cartChanged = false;
                toggleUpdateButton();
                setTimeout(() => location.reload(), 800);
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => {
            this.disabled = false;
            this.textContent = 'Update Cart';
        });
    });

    checkForChanges();
});
</script>
