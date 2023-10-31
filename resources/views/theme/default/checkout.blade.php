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
						<li class="active"><a href="">{{ _lang('Checkout') }}</a></li>
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
			<div class="col-lg-8 col-12">

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

				<div class="checkout-form">

					<div class="alert-box"></div>

					<h2>{{ _lang('Make Your Checkout Here') }}</h2>
					
					@if(! Auth::check())
						<p>{{ _lang('You have an account already?') }} <a href="{{ url('/sign_in') }}" class="btn-link"><b>{{ _lang('Login to your account') }}</b></a></p>

						<!-- Form -->
						<form id="checkout-form" method="post" action="{{ url('/make_order') }}">
							@csrf
							<div class="row">
								<div class="col-12">
									<div class="form-group">
										<label>{{ _lang('Name') }}<span>*</span></label>
										<input type="text" name="name" placeholder="{{ _lang('Name') }}" required">
										
										@if($errors->has('name'))
											<div class="invalid-feedback">
									          {{ $errors->first('name') }}
									        </div>
								        @endif
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ _lang('Email Address') }}<span>*</span></label>
										<input type="email" name="email" placeholder="{{ _lang('Email Address') }}" required>
										@if($errors->has('email'))
											<div class="invalid-feedback">
									          {{ $errors->first('email') }}
									        </div>
								        @endif
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ _lang('Phone Number') }}<span>*</span></label>
										<input type="number" name="phone" placeholder="{{ _lang('Phone Number') }}" required>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ _lang('Country') }}<span>*</span></label>
										<select name="country" class="customer-country" id="country" required>
											@php $supported_countries = get_option('supported_countries'); @endphp
							                <option value="">{{ _lang('Select Country') }}</option>   	
											@if(!empty($supported_countries))
					                    	    @foreach(get_all_country() as $country)
														@if(in_array($country->name, $supported_countries))
															<option value="{{ $country->sortname }}" data-id="{{ $country->id }}" {{ old('country') == $country->sortname ? 'selected' : '' }}>
																{{ $country->name }}
															</option>
														@endif
					                    	    @endforeach
				                    	    @endif
										</select>
										@if($errors->has('country'))
											<div class="invalid-feedback">
									          {{ $errors->first('country') }}
									        </div>
								        @endif
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ _lang('State / Divition') }}<span>*</span></label>
										<select name="state" class="select-state-no-auth" id="state" required>
											<option value="">{{ _lang('Select State') }}</option>
										</select>
										@if($errors->has('state'))
											<div class="invalid-feedback">
									          {{ $errors->first('state') }}
									        </div>
								        @endif
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ _lang('City') }}<span>*</span></label>
										<input type="text" name="city" placeholder="{{ _lang('City') }}" required="required">
										@if($errors->has('city'))
											<div class="invalid-feedback">
									          {{ $errors->first('city') }}
									        </div>
								        @endif
									</div>
								</div>

								<div class="col-lg-6 col-md-6 col-12">
									<div class="form-group">
										<label>{{ _lang('Postal Code') }}<span>*</span></label>
										<input type="text" name="post_code" placeholder="{{ _lang('Postal Code') }}" required="required">
										@if($errors->has('post_code'))
											<div class="invalid-feedback">
									          {{ $errors->first('post_code') }}
									        </div>
								        @endif
									</div>
								</div>

								<div class="col-12">
									<div class="form-group">
										<label>{{ _lang('Address') }}<span>*</span></label>
										<input type="text" name="address" placeholder="{{ _lang('Address') }}" required>
										@if($errors->has('address'))
											<div class="invalid-feedback">
									          {{ $errors->first('address') }}
									        </div>
								        @endif
									</div>
								</div>
								
								
								<div class="col-12 mb-3">
									<div class="form-group create-account">	
										<label><input id="create_account" name="create_account" value="1" type="checkbox"> {{ _lang('Create an account?') }}</label>
									</div>
								</div>

								<div class="col-md-6 create_account {{ old('create_account') == 1 ? '' : 'd-none'  }}">
									<div class="form-group">
										<label>{{ _lang('Password') }}<span>*</span></label>
										<input type="password" name="password" placeholder="{{ _lang('Password') }}" required="required">

										@if($errors->has('password'))
											<div class="invalid-feedback">
									          {{ $errors->first('password') }}
									        </div>
								        @endif
									</div>
								</div>

								<div class="col-md-6 create_account d-none">
									<div class="form-group">
										<label>{{ _lang('Password Confirmation') }}<span>*</span></label>
										<input type="password" name="password_confirmation" placeholder="{{ _lang('Password Confirmation') }}" required="required">

										@if($errors->has('password_confirmation'))
											<div class="invalid-feedback">
									          {{ $errors->first('password_confirmation') }}
									        </div>
								        @endif
									</div>
								</div>					 

							</div>
						</form>
						<!--/ End Form -->
					@else
						<p>{{ _lang('You are now logged in') }}</p>
						@php $address_list = \App\CustomerAddress::where('customer_id',Auth::id())->get(); @endphp
						
						<form id="checkout-form" method="post" action="{{ url('/make_order') }}">
							@csrf
							<div class="row">
								<div class="col-md-6 col-12">
									<div class="form-group">
										<label>{{ _lang('Shipping Address') }}<span>*</span></label>
										<select name="shipping_address" id="select-shipping-address" required>
											@foreach($address_list as $shipping_address)
												<option value="{{ $shipping_address->id }}" data-state="{{ $shipping_address->state }}" {{ $shipping_address->is_default == 1 ? 'selected' : '' }}>{{ $shipping_address->address }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-md-6 col-12">
									<div class="form-group">
										<label>{{ _lang('Billing Address') }}<span>*</span></label>
										<select name="billing_address" id="select-billing-address" required>
											@foreach($address_list as $billing_address)
												<option value="{{ $billing_address->id }}" data-state="{{ $billing_address->state }}" {{ $billing_address->is_default == 1 ? 'selected' : '' }}>{{ $billing_address->address }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group">
										<div class="form-group">
											<label>{{ _lang('Order Note') }}</label>
											<textarea name="note" placeholder="{{ _lang('Order Note') }}"></textarea>
										</div>
									</div>
								</div>
							</div>
						</form>

						<a href="" id="add_new_address"><i class="fa fa-plus"></i> {{ _lang('Add New Address') }}</a>
						
						<div class="account_details d-none mt-3">
							<h5>{{ _lang('Add New Address') }}</h5>
							<form action="{{ url('/add_new_address') }}" id="create_address_form" method="post">
								@csrf
								<div class="row">
									<div class="col-md-12">
										<input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="{{ _lang('Name') }}" required>
								    </div>

								    <div class="col-md-6">
										 @php $supported_countries = get_option('supported_countries'); @endphp
					                    	    
										<select class="form-control customer-country" data-selected="{{ old('country') }}" name="country" required>
							                <option value="">{{ _lang('Select Country') }}</option>	
				                    	    @if(!empty($supported_countries))
					                    	    @foreach(get_all_country() as $country)
														@if(in_array($country->name, $supported_countries))
															<option value="{{ $country->sortname }}" data-id="{{ $country->id }}" {{ old('country') == $country->sortname ? 'selected' : '' }}>
																{{ $country->name }}
															</option>
														@endif
					                    	    @endforeach
				                    	    @endif
										</select>
								    </div>

								    <div class="col-md-6">
								    	<select class="form-control" id="state" name="state" required>
								    		<option value="">{{ _lang('Select State') }}</option>	
								    	</select>
								    </div>

								    <div class="col-md-6">
										<input type="text" name="city"  value="{{ old('city') }}" class="form-control" placeholder="{{ _lang('City') }}" required>
								    </div>

								    <div class="col-md-6">
										<input type="text" name="post_code" value="{{ old('post_code') }}" class="form-control" placeholder="{{ _lang('Post Code') }}" required>
								    </div>

								    <div class="col-md-12">
										<textarea class="form-control" name="address" placeholder="{{ _lang('Address') }}" required>{{ old('address') }}</textarea>
								    </div>

								    <input type="hidden" name="is_default" value="0">

								
									<div class="col-md-12">
										<button type="submit" class="btn-login">{{ _lang('Save Address') }}</button>
									</div>
								</div>
							</form>
						</div>
					@endif
					
				</div>
			</div>
			<div class="col-lg-4 col-12">
				<div class="order-details">
					
					<!-- Order Widget -->
					<div class="single-widget">
						<h2>{{ _lang('CART  TOTALS') }}</h2>
						<div class="content" id="cart-contents">
							@include('theme.default.components.checkout-cart')
						</div>
					</div>
					<!--/ End Order Widget -->

					<div class="single-widget">
						<h2>{{ _lang('Apply Coupon') }}</h2>
						<div class="content">
							<ul>
								<li>
									<form id="apply_coupon" action="{{ url('/apply_coupon') }}" method="POST">
										@csrf
										<input type="text" name="coupon" placeholder="{{ _lang('Enter Coupon Code') }}" required>
										<button class="btn">{{ _lang('Apply Coupon') }}</button>
									</form>
								</li>
							</ul>
						</div>
					</div>	

					<div class="single-widget">
						<h2>{{ _lang('Shipping Methods') }}</h2>
						<div class="content">
							@if(! Cart::isEmpty())						
								<ul>	
									@if(get_option('free_shipping_active') == 'Yes' && \Cart::getSubTotal() >= get_option('free_shipping_minimum_amount',0))
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" id="free_shipping" value="free_shipping" name="shipping_method" class="custom-control-input select-shipping-method" {{ empty(Cart::getCondition(get_option('free_shipping_label'))) ? '' : 'checked' }}>
												<label class="custom-control-label" for="free_shipping">{{ get_option('free_shipping_label') }}</label>
											</div>
										</li>
									@endif

									@if(get_option('flat_rate_active') == 'Yes')
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" id="flat_rate" value="flat_rate" name="shipping_method" class="custom-control-input select-shipping-method" {{ empty(Cart::getCondition(get_option('flat_rate_label'))) ? '' : 'checked' }}>
												<label class="custom-control-label" for="flat_rate">{{ get_option('flat_rate_label') }} + <b>{!! xss_clean(show_price(get_option('flat_rate_cost'))) !!}</b></label>
											</div>
										</li>
									@endif

									@if(get_option('local_pickup_active') == 'Yes')
										<li>
											<div class="custom-control custom-radio">
												<input type="radio" id="local_pickup" value="local_pickup" name="shipping_method" class="custom-control-input select-shipping-method" {{ empty(Cart::getCondition(get_option('local_pickup_label'))) ? '' : 'checked' }}>
												<label class="custom-control-label" for="local_pickup">{{ get_option('local_pickup_label') }} + <b>{!! xss_clean(show_price(get_option('local_pickup_cost'))) !!}</b></label>
											</div>
										</li>
									@endif
								</ul>
							@endif
						</div>
					</div>


					<!-- Button Widget -->
					<div class="single-widget get-button">
						<div class="content">
							<div class="button">
								<a href="" id="proceed_to_checkout" class="btn">{{ _lang('Proceed to Payment') }}</a>
							</div>
						</div>
					</div>
					<!--/ End Button Widget -->
				</div>
			</div>
		</div>
	</div>
</section>
<!--/ End Checkout -->

@include('theme.default.components.services')
	
@endsection

@section('js-script')
<script src="{{ asset('public/theme/default/js/cart.js?v=1.1') }}"></script>
<script src="{{ asset('public/theme/default/js/checkout.js?v=1.1') }}"></script>
@endsection