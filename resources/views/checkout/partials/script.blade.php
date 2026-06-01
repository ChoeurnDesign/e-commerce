<script src="https://js.stripe.com/v3/"></script>
@if(config('services.paypal.client_id'))
<script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form          = document.getElementById('checkout-form');
    const step1         = document.getElementById('step-1');
    const step2         = document.getElementById('step-2');
    const nextBtn       = document.getElementById('next-step-btn');
    const prevBtn       = document.getElementById('prev-step-btn');
    const billingSame   = document.getElementById('billing_same');
    const billingFields = document.getElementById('billing-fields');
    const csrfToken     = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    if (!form) return;

    // ── Stripe ───────────────────────────────────────────────────────────────
    const stripe      = Stripe("{{ config('services.stripe.key') }}");
    const elements    = stripe.elements();
    const cardElement = elements.create('card', {
        style: {
            base:    { fontSize: '16px', color: '#32325d', fontFamily: '"Helvetica Neue", Helvetica, sans-serif', '::placeholder': { color: '#aab7c4' } },
            invalid: { color: '#fa755a', iconColor: '#fa755a' }
        }
    });

    const stripeContainer = document.getElementById('stripe-card-element-container');
    const cardErrors      = document.getElementById('card-errors');
    const processing      = document.getElementById('stripe-processing');
    const placeBtn        = document.getElementById('place-order-btn');

    cardElement.mount('#stripe-card-element');
    cardElement.on('change', e => { if (cardErrors) cardErrors.textContent = e.error ? e.error.message : ''; });

    function showCardError(msg) {
        if (cardErrors)  cardErrors.textContent = msg;
        if (processing)  processing.style.display = 'none';
        if (placeBtn) { placeBtn.disabled = false; placeBtn.textContent = 'Place Order'; }
    }

    // ── Billing toggle ────────────────────────────────────────────────────────
    function toggleBillingFields() {
        if (!billingSame || !billingFields) return;
        const show = !billingSame.checked;
        billingFields.style.display = show ? 'block' : 'none';
        billingFields.querySelectorAll('input,select,textarea').forEach(el => el.required = show);
    }
    if (billingSame) { billingSame.addEventListener('change', toggleBillingFields); toggleBillingFields(); }

    // ── Step navigation ───────────────────────────────────────────────────────
    // FIX: we remove 'required' from step 1 fields when advancing to step 2
    // so browser HTML5 validation doesn't block on hidden fields.
    // Fields remain ENABLED so they still get included in the form POST.
    function suspendStep1Required() {
        step1.querySelectorAll('input,select,textarea').forEach(el => {
            if (el.required) { el.dataset.wasRequired = '1'; el.required = false; }
        });
    }
    function restoreStep1Required() {
        step1.querySelectorAll('input,select,textarea').forEach(el => {
            if (el.dataset.wasRequired === '1') { el.required = true; delete el.dataset.wasRequired; }
        });
    }

    function validateStep(stepEl) {
        for (const el of stepEl.querySelectorAll('input,textarea,select')) {
            if (el.offsetParent !== null && !el.disabled && !el.checkValidity()) {
                el.reportValidity(); return false;
            }
        }
        return true;
    }

    // Step indicator elements
    const step2Circle = document.getElementById('step2-circle');
    const step2Label  = document.getElementById('step2-label');

    function activateStep2Indicator() {
        if (step2Circle) step2Circle.className = 'w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold bg-pink-500 text-white transition-colors';
        if (step2Label)  step2Label.className  = 'text-sm font-semibold text-pink-600 transition-colors';
    }
    function deactivateStep2Indicator() {
        if (step2Circle) step2Circle.className = 'w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold bg-rose-100 text-rose-400 transition-colors';
        if (step2Label)  step2Label.className  = 'text-sm font-medium text-gray-400 transition-colors';
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (!validateStep(step1)) return;
            suspendStep1Required();
            step1.style.display = 'none';
            step2.style.display = 'block';
            activateStep2Indicator();
        });
    }
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            restoreStep1Required();
            step2.style.display = 'none';
            step1.style.display = 'block';
            deactivateStep2Indicator();
        });
    }

    // ── Payment method toggle ─────────────────────────────────────────────────
    const paypalContainer = document.getElementById('paypal-button-container');
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function () {
            if (stripeContainer) stripeContainer.style.display = this.value === 'credit_card' ? 'block' : 'none';
            if (paypalContainer) paypalContainer.style.display = this.value === 'paypal'      ? 'block' : 'none';
        });
    });

    // Hide PayPal radio if SDK didn't load (client_id not configured)
    if (typeof paypal === 'undefined') {
        const paypalRadioLabel = document.querySelector('input[value="paypal"]')?.closest('label');
        if (paypalRadioLabel) paypalRadioLabel.style.display = 'none';
    }

    // ── Coupon ────────────────────────────────────────────────────────────────
    const applyBtn    = document.getElementById('apply-coupon-btn');
    const removeBtn   = document.getElementById('remove-coupon-btn');
    const couponInput = document.getElementById('coupon-input');
    const couponMsg   = document.getElementById('coupon-message');

    if (applyBtn) {
        applyBtn.addEventListener('click', async function () {
            const code = couponInput.value.trim().toUpperCase();
            if (!code) return;
            applyBtn.disabled = true; applyBtn.textContent = '…';
            try {
                const res  = await fetch('{{ route("coupon.apply") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ coupon_code: code })
                });
                const data = await res.json();
                if (data.success) {
                    window.location.reload(); // reload to recalculate totals
                } else {
                    couponMsg.className   = 'mt-1 text-xs text-red-500';
                    couponMsg.textContent = data.message;
                }
            } catch (e) {
                couponMsg.className   = 'mt-1 text-xs text-red-500';
                couponMsg.textContent = 'Failed to apply coupon.';
            }
            applyBtn.disabled = false; applyBtn.textContent = 'Apply';
        });
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', async function () {
            await fetch('{{ route("coupon.remove") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            window.location.reload();
        });
    }

    // ── PayPal ────────────────────────────────────────────────────────────────
    let isPayPalSubmit = false;
    if (paypalContainer && typeof paypal !== 'undefined') {
        paypal.Buttons({
            createOrder: (data, actions) => actions.order.create({
                purchase_units: [{ description: 'ShopExpress Order', amount: { value: '{{ $cartTotals["total"] }}' } }]
            }),
            onApprove: (data) => {
                // Append PayPal order ID and submit
                const input = Object.assign(document.createElement('input'), {
                    type: 'hidden', name: 'paypal_order_id', value: data.orderID
                });
                form.appendChild(input);
                isPayPalSubmit = true;
                // Restore step 1 required-state before submit so fields are valid
                restoreStep1Required();
                form.submit();
            },
            onError: (err) => {
                console.error('PayPal error', err);
                alert('PayPal encountered an error. Please try a different payment method.');
            }
        }).render('#paypal-button-container');
    }

    // ── Form submit ───────────────────────────────────────────────────────────
    form.addEventListener('submit', async function (e) {
        const selected = document.querySelector('input[name="payment_method"]:checked');

        if (!selected) {
            e.preventDefault();
            alert('Please select a payment method.');
            return;
        }

        // ── Credit Card (Stripe AJAX) ─────────────────────────────────────
        if (selected.value === 'credit_card') {
            e.preventDefault();
            placeBtn.disabled = true;
            if (processing) processing.style.display = 'flex';

            const { paymentMethod, error } = await stripe.createPaymentMethod({ type: 'card', card: cardElement });
            if (error) { showCardError(error.message); return; }

            // Build FormData — step 1 fields are still enabled (not disabled), just not required
            const formData = new FormData(form);
            formData.set('stripe_payment_method_id', paymentMethod.id);

            try {
                const res  = await fetch(form.action, {
                    method:  'POST',
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body:    formData,
                });
                const data = await res.json();

                if (data.requires_action) {
                    const { paymentIntent, error: actionError } = await stripe.handleCardAction(data.client_secret);
                    if (actionError) { showCardError(actionError.message); return; }

                    const confirmRes  = await fetch('{{ route("checkout.confirmStripe") }}', {
                        method:  'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                        body:    JSON.stringify({ payment_intent_id: paymentIntent.id, order_number: data.order_number }),
                    });
                    const confirmData = await confirmRes.json();
                    if (confirmData.success) {
                        window.location.href = confirmData.redirect;
                    } else {
                        showCardError(confirmData.message || 'Payment confirmation failed.');
                    }
                } else if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    showCardError(data.message || 'Payment failed. Please try again.');
                }
            } catch (err) {
                showCardError('An unexpected error occurred. Please try again.');
            }
            return;
        }

        // ── PayPal — buyer must use the PayPal button ─────────────────────
        if (selected.value === 'paypal' && !isPayPalSubmit) {
            e.preventDefault();
            if (paypalContainer) paypalContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        // ── COD / PayPal (after approval) ─────────────────────────────────
        if (!validateStep(step2)) {
            e.preventDefault();
            return;
        }

        // Prevent double-submission
        placeBtn.disabled = true;
        placeBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 inline" fill="none" viewBox="0 0 24 24">'
            + '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>'
            + '<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>Placing Order…';
    });
});
</script>

