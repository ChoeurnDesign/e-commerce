<script src="https://www.paypal.com/sdk/js?client-id=<?php echo e(config('services.paypal.client_id')); ?>&currency=USD"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Step navigation
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    document.getElementById('next-step-btn').onclick = function() {
        // Validation can be added here
        step1.style.display = 'none';
        step2.style.display = 'block';
    };
    document.getElementById('prev-step-btn').onclick = function() {
        step2.style.display = 'none';
        step1.style.display = 'block';
    };

    // Billing address toggle
    const billingSame = document.getElementById('billing_same');
    const billingFields = document.getElementById('billing-fields');
    billingSame.addEventListener('change', function() {
        billingFields.style.display = billingSame.checked ? 'none' : 'block';
    });

    // PayPal button logic
    const form = document.getElementById('checkout-form');
    const paypalButtonContainer = document.getElementById('paypal-button-container');
    let isPayPalSubmit = false;

    // Pass total from backend to JS
    const cartTotal = '<?php echo e($cartTotals['total']); ?>';

    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    description: "Order at ShopExpress",
                    amount: { value: cartTotal }
                }]
            });
        },
        onApprove: function(data, actions) {
            let input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'paypal_order_id';
            input.value = data.orderID;
            form.appendChild(input);
            isPayPalSubmit = true;
            form.submit();
        }
    }).render('#paypal-button-container');

    // Only show PayPal button if PayPal selected
    document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === 'paypal') {
                paypalButtonContainer.style.display = 'block';
            } else {
                paypalButtonContainer.style.display = 'none';
            }
        });
    });

    // Intercept submit for PayPal
    form.addEventListener('submit', function(e) {
        const selected = document.querySelector('input[name="payment_method"]:checked');
        if (selected && selected.value === 'paypal' && !isPayPalSubmit) {
            e.preventDefault();
            paypalButtonContainer.style.display = 'block';
            paypalButtonContainer.scrollIntoView({behavior: 'smooth', block: 'center'});
            return false;
        }
    });
});
</script>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/checkout/partials/script.blade.php ENDPATH**/ ?>