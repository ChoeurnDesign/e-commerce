<script>
        function toggleBillingAddress(checkbox) {
            const billingFields = document.getElementById('billing-address-fields');
            if (checkbox.checked) {
                billingFields.classList.add('hidden');
                billingFields.querySelectorAll('input, textarea, select').forEach(field => {
                    field.value = '';
                    field.removeAttribute('required');
                });
            } else {
                billingFields.classList.remove('hidden');
                billingFields.querySelectorAll('input[name*="billing_"], textarea[name*="billing_"], select[name*="billing_"]').forEach(field => {
                    if (field.name !== 'billing_phone') {
                        field.setAttribute('required', 'required');
                    }
                });
            }
        }
    </script>
