@extends('theme.default.website')

@section('content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="{{ url('') }}">{{ _lang('Home') }}<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="">{{ _lang('Make Payment') }}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Checkout -->
<section class="shop checkout section">
	<div class="container">
		<div class="row"> 
			<div class="col-12">
				@if(\Session::has('success'))
					<div class="alert alert-success mt-4">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<span>{!! xss_clean(session('success')) !!}</span>
					</div>
				@endif

				@if(\Session::has('error'))
					<div class="alert alert-danger mt-4">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<span>{!! xss_clean(session('error')) !!}</span>
					</div>
				@endif
			</div>

			<div class="col-lg-6 col-12">

				<div class="order-details">
					<div class="single-widget">
						<h2>{{ _lang('Payment Methods') }}</h2>
						<div class="content">
							<div class="payment-methods">
								<ul>
									@if(get_option('paypal_active') == 'Yes')
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" id="paypal-method" value="paypal" name="payment_method" class="custom-control-input select-payment-method" data-description="{{ get_option('paypal_description') }}">
												<label class="custom-control-label" for="paypal-method">{{ get_option('paypal_label') }}</label>
											</div>
										</li>
									@endif

									@if(get_option('stripe_active') == 'Yes')
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" id="stripe-box" value="stripe" name="payment_method" class="custom-control-input select-payment-method" data-description="{{ get_option('stripe_description') }}">
												<label class="custom-control-label" for="stripe-box">{{ get_option('stripe_label') }}</label>
											</div>
										</li>
									@endif

									@if(get_option('razorpay_active') == 'Yes')
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" id="razorpay-box" value="razorpay" name="payment_method" class="custom-control-input select-payment-method" data-description="{{ get_option('razorpay_description') }}">
												<label class="custom-control-label" for="razorpay-box">{{ get_option('razorpay_label') }}</label>
											</div>
										</li>
									@endif

									@if(get_option('paystack_active') == 'Yes')
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" id="paystack-box" value="paystack" name="payment_method" class="custom-control-input select-payment-method" data-description="{{ get_option('paystack_description') }}">
												<label class="custom-control-label" for="paystack-box">{{ get_option('paystack_label') }}</label>
											</div>
										</li>
									@endif

									@if(get_option('cod_active') == 'Yes')
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" id="cod" value="cod" name="payment_method" class="custom-control-input select-payment-method" data-description="{{ get_option('cod_description') }}">
												<label class="custom-control-label" for="cod">{{ get_option('cod_label') }}</label>
											</div>
										</li>
									@endif

									@if(get_option('bank_transfer_active') == 'Yes')
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" id="bank_transfer" value="bank_transfer" name="payment_method" class="custom-control-input select-payment-method" data-description="{{ get_option('bank_transfer_description') }}">
												<label class="custom-control-label" for="bank_transfer">{{ get_option('bank_transfer_label') }}</label>
											</div>
										</li>
									@endif
								</ul>
							</div>

						</div>
					</div>

					
					<!--Payment Descriptions-->
					<div class="col-md-12">
						<span id="payment-descriptions">{{ _lang('Select Payment Method') }}</span>
					</div>
					<!--End Payment Descriptions-->
					

				</div>

			</div>

			<div class="col-lg-6 col-12">
				<div class="order-details">
					
					<div class="single-widget">
						<h2>{{ _lang('CART  TOTALS') }}</h2>
						<div class="content" id="cart-contents">
							<ul>
								<li>{{ _lang('Sub Total') }}<span>{!! xss_clean(decimalPlace(convert_currency_2(1, $order->currency_rate, $order->sub_total), $order->currency)) !!}</span></li>
								
								<li>{{ _lang('Shipping Cost') }}<span>+ {!! xss_clean(decimalPlace(convert_currency_2(1, $order->currency_rate, $order->shipping_cost), $order->currency)) !!}</span></li>

								@if($order->coupon_id != null)
									<li>{{ _lang('Discount') }}<span>- {!! xss_clean(decimalPlace(convert_currency_2(1, $order->currency_rate, $order->discount), $order->currency)) !!}</span></li>
								@endif

								@foreach($order->taxes as $tax)
									<li>{{ $tax->translation->name }}<span>+ {!! xss_clean(decimalPlace(convert_currency_2(1, $order->currency_rate, $tax->order_tax->amount), $order->currency)) !!}</span></li>
								@endforeach

								<li class="last">{{ _lang('Total') }}<span><b>{!! xss_clean(decimalPlace(convert_currency_2(1, $order->currency_rate, $order->total), $order->currency)) !!}</b></span></li>
							</ul>
						</div>
					</div>	

					
					<div class="single-widget get-button">
						<div class="content">
							<div class="button" id="payment-button">
								<div id="paypal-container" class="d-none">
									@include('theme.default.gateways.paypal')
								</div>

								<div id="stripe-container" class="d-none">
									@include('theme.default.gateways.stripe')
								</div>

								<div id="razorpay-container" class="d-none">
									@include('theme.default.gateways.razorpay')
								</div>

								<div id="paystack-container" class="d-none">
									@include('theme.default.gateways.paystack')
								</div>

								<div id="cod-container" class="d-none">
									<a href="{{ url('gateway/confirm_order/cod/'.encrypt($order->id)) }}" id="confirm_order" class="btn">{{ _lang('Confirm Order') }}</a>
								</div>

								<div id="bank_transfer-container" class="d-none">
									<a href="{{ url('gateway/confirm_order/bank_transfer/'.encrypt($order->id)) }}" id="confirm_order" class="btn">{{ _lang('Confirm Order') }}</a>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</section>
<!--/ End Checkout -->

	
@endsection

@section('js-script')
<script src="{{ asset('public/theme/default/js/checkout.js') }}"></script>
@endsection