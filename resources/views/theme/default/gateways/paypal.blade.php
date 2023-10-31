<!--PayPal Pay Now Button-->
<script src="https://www.paypal.com/sdk/js?client-id={{ get_option('paypal_client_id') }}&currency={{ $order->currency }}&disable-funding=credit,card"></script>

<div id="paypal-button-container"></div>

<script>
  paypal.Buttons({
	createOrder: function(data, actions) {
	  	return actions.order.create({
			purchase_units: [{
			  amount: {
				value: '{{ convert_currency_2(1, $order->currency_rate, $order->total) }}'
			  }
			}]
	 	});
	},
	onApprove: function(data, actions) {  
		window.location.href = "{{ url('gateway/paypal_payment_authorize') }}/" + data.orderID + "/{{ $order->id }}";
	},
	onCancel: function (data) {
		alert('{{ _lang('Payment Cancelled') }}');
	}
  }).render('#paypal-button-container');
  
</script>