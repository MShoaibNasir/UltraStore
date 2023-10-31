<form action="{{ url('gateway/razorpay_payment_authorize/'.$order->id) }}" method="POST">
	@csrf
	<script
		src="https://checkout.razorpay.com/v1/checkout.js"
		data-key="{{ get_option('razorpay_key_id') }}"
		data-amount="{{ convert_currency_2(1, $order->currency_rate, ($order->total * 100)) }}"
		data-currency="{{ $order->currency }}"
		data-name="{{ _lang('Purchase from').' '.get_option('company_name') }}"
		data-image="{{ get_logo() }}"
		data-description="{{ _lang('Purchase from').' '.get_option('company_name') }}"
		data-prefill.name="{{ $order->customer_name }}"
		data-prefill.email="{{ $order->customer_email  }}"
		data-prefill.contact="{{ $order->customer_phone  }}"
		data-notes.shopping_order_id="{{ $order->id }}">
	</script>
</form>