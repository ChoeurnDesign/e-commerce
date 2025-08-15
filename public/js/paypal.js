paypal.Buttons({
  createOrder: function(data, actions) {
    return fetch('/paypal/order/create', { method: 'post' })
      .then(res => res.json())
      .then(order => order.id);
  },
  onApprove: function(data, actions) {
    alert('Payment approved: ' + data.orderID);
  }
}).render('#paypal-button-container');
