  <!-- PayPal JS SDK: Your real client ID is inserted below -->
    <script src="https://www.paypal.com/sdk/js?client-id=AeF52zaWC0TqpiYeU21V72cSG8FtH9JsfwrKqqVG_ZC77LHlA_H74NsPu6hLV2ibNkzSq77LshdfCXbG&currency=USD"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            paypal.Buttons({
                createOrder: function(data, actions) {
                    // Replace with your dynamic total if available, e.g. {{ $orderTotal }}
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '{{ $orderTotal ?? "10.00" }}'
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        alert('Transaction completed by ' + details.payer.name.given_name);
                        // Optional: send details to your backend here if needed
                    });
                }
            }).render('#paypal-button-container');
        });
    </script>
