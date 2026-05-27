<script src="https://js.stripe.com/v3/"></script>
<script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    if (!form) return;

    // --- 1. STRIPE INITIALIZATION ---
    const stripe = Stripe("{{ config('services.stripe.key') }}");
    const elements = stripe.elements();
    const card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                '::placeholder': { color: '#aab7c4' }
            },
            invalid: { color: '#fa755a', iconColor: '#fa755a' }
        }
    });

    const stripeContainer = document.getElementById('stripe-card-element-container');
    if (stripeContainer) {
        card.mount('#stripe-card-element');
    }

    // --- 2. STEP NAVIGATION & BILLING TOGGLE ---
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const nextBtn = document.getElementById('next-step-btn');
    const prevBtn = document.getElementById('prev-step-btn');
    const billingSame = document.getElementById('billing_same');
    const billingFields = document.getElementById('billing-fields');

    function setBillingRequired(isRequired) {
        if (!billingFields) return;
        const billingInputs = billingFields.querySelectorAll('input, select, textarea');
        billingInputs.forEach(el => el.required = isRequired);
    }

    function toggleBillingFields() {
        if (!billingSame || !billingFields) return;
        const show = !billingSame.checked;
        billingFields.style.display = show ? 'block' : 'none';
        setBillingRequired(show);
    }

    if (billingSame) {
        billingSame.addEventListener('change', toggleBillingFields);
        toggleBillingFields();
    }

    function validateStep(stepEl) {
        const inputs = stepEl.querySelectorAll('input, textarea, select');
        for (const input of inputs) {
            if (input.offsetParent !== null && !input.disabled) {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    return false;
                }
            }
        }
        return true;
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            if (!validateStep(step1)) return;
            step1.style.display = 'none';
            step2.style.display = 'block';
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            step2.style.display = 'none';
            step1.style.display = 'block';
        });
    }

    // --- 3. PAYPAL LOGIC ---
    const paypalButtonContainer = document.getElementById('paypal-button-container');
    let isPayPalSubmit = false;
    const cartTotal = '{{ $cartTotals['total'] }}';

    if (paypalButtonContainer) {
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
    }

    // --- 4. PAYMENT METHOD TOGGLE ---
    document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (paypalButtonContainer) 
                paypalButtonContainer.style.display = (this.value === 'paypal') ? 'block' : 'none';
            
            if (stripeContainer)
                stripeContainer.style.display = (this.value === 'credit_card') ? 'block' : 'none';
        });
    });

    // --- 5. FORM SUBMISSION ---
    form.addEventListener('submit', async function(e) {
        const selected = document.querySelector('input[name="payment_method"]:checked');
        const step1Hidden = (step1.style.display === 'none');
        
        // Prevent step-1 required fields from blocking step-2 submission
        step1.querySelectorAll('input, select, textarea').forEach(el => el.disabled = step1Hidden);

        if (!selected) {
            e.preventDefault();
            alert('Please select a payment method');
            return;
        }

        // Handle Stripe
        if (selected.value === 'credit_card') {
            e.preventDefault();
            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
            });

            if (error) {
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
            } else {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'stripe_payment_method_id';
                input.value = paymentMethod.id;
                form.appendChild(input);
                form.submit();
            }
            return;
        }

        // Handle PayPal (Must use PayPal button)
        if (selected.value === 'paypal' && !isPayPalSubmit) {
            e.preventDefault();
            paypalButtonContainer.scrollIntoView({behavior: 'smooth', block: 'center'});
            return;
        }

        // Handle Cash on Delivery / Default
        if (!validateStep(step2)) {
            e.preventDefault();
        }
    });
});
</script>