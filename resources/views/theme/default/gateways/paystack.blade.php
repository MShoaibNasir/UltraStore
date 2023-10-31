<button type="button" class="pay-now-btn" onclick="payWithPaystack()"> {{ _lang('Pay Now') }}</button>
<script src="https://js.paystack.co/v1/inline.js"></script> 

<script type="text/javascript">

function payWithPaystack(e) {
  let handler = PaystackPop.setup({
    key: '{{ get_option('paystack_public_key') }}',
    email: '{{ $order->customer_email }}',
    amount: {{ convert_currency_2(1, $order->currency_rate, ($order->total * 100)) }},
    currency: '{{ $order->currency }}',
    firstname: '{{ $order->customer_name }}',
    ref: '{{ $order->id }}', 
    callback: function(response){
    	window.location = "{{ url('gateway/paystack_payment_authorize/'.$order->id) }}/" + response.reference;
    }
  });
  handler.openIframe();
}

</script>

