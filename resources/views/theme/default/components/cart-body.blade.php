<div class="container">
	<div class="row">
		<div class="col-12">
			<form id="shopping-cart-form" action="{{ url('/update_cart') }}" method="post">
			{{ csrf_field() }}
			<!-- Shopping Summery -->
			<table class="table shopping-summery">
				<thead>
					<tr class="main-hading">
						<th>{{ _lang('PRODUCT') }}</th>
						<th>{{ _lang('NAME') }}</th>
						<th class="text-center">{{ _lang('UNIT PRICE') }}</th>
						<th class="text-center">{{ _lang('QUANTITY') }}</th>
						<th class="text-center">{{ _lang('TOTAL') }}</th> 
						<th class="text-center"><i class="ti-trash remove-icon"></i></th>
					</tr>
				</thead>
				<tbody>
					@if(\Cart::isEmpty())
						<tr>
							<td colspan="6" class="text-center">{{ _lang('No Product added to cart !') }}</td>
						</tr>
					@endif

						@foreach(\Cart::getContent() as $cart)
							<tr>
								<td class="image" data-title="No">
									<img src="{{ asset('storage/app/'. $cart->associatedModel->image->file_path) }}" alt="#">
								</td>
								<td class="product-des" data-title="Description">
									<input type="hidden" name="cart_id[{{ $loop->index }}]" value="{{ $cart->id }}"> 
									<p class="product-name">
										<a href="{{ url('product/'.$cart->associatedModel->slug) }}">{{ $cart->associatedModel->translation->name }}</a>
									</p>
									<p class="product-des">
										@foreach($cart->attributes as $key => $val)
											<b>{{ $key }}</b> : {{ $val }} 

											{{ $loop->last ? '' : '|' }} 
										@endforeach
									</p>
								</td>
								<td class="price" data-title="Price">
									<span>{!! xss_clean(show_price($cart->price)) !!}</span>
								</td>
								<td class="qty" data-title="Qty"><!-- Input Order -->
									<div class="input-group">
										<div class="button minus">
											<button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quantity[{{ $loop->index }}]">
												<i class="ti-minus"></i>
											</button>
										</div>
										<input type="text" name="quantity[{{ $loop->index }}]" class="input-number" data-min="1" data-max="100" value="{{ $cart->quantity }}">
										<div class="button plus">
											<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quantity[{{ $loop->index }}]">
												<i class="ti-plus"></i>
											</button>
										</div>
									</div>
									<!--/ End Input Order -->
								</td>
								<td class="total-amount" data-title="Total">
									@if(! empty($cart->conditions))
										<small><s>{!! xss_clean(show_price($cart->getPriceSum())) !!}</s></small>
										<span>{!! xss_clean(show_price($cart->getPriceSumWithConditions())) !!}</span><br>
									@else
										<span>{!! xss_clean(show_price($cart->getPriceSum())) !!}</span>
									@endif
									
								</td>
								<td class="action" data-title="{{ _lang('Remove') }}">
									<a href="{{ url('/remove_cart_item/'.$cart->id) }}" class="remove-cart-item"><i class="ti-trash remove-icon"></i></a>
								</td>
							</tr>					
						@endforeach
					</tbody>
				</table>
			</form>
			<!--/ End Shopping Summery -->
		</div>
	</div>
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

			<!-- Total Amount -->
			<div class="total-amount">
				<div class="row">
					<div class="col-lg-8 col-md-5 col-12">
						<div class="left">

							@if(! Cart::isEmpty())

								<div class="coupon">
									<form id="apply_coupon" action="{{ url('/apply_coupon') }}" method="POST">
										@csrf
										<input type="text" name="coupon" placeholder="{{ _lang('Enter Your Coupon') }}" required>
										<button class="btn">{{ _lang('Apply') }}</button>

										@if(! \Cart::isEmpty())
											<button type="button" class="btn update-cart-btn" id="update-cart">{{ _lang('Update Cart') }}</button>
										@endif
									</form>
								</div>

							
								<div class="shipping_methods mt-4">
									<h4>{{ _lang('Shipping Methods') }}</h4>
									@if(get_option('free_shipping_active') == 'Yes' && \Cart::getSubTotal() >= get_option('free_shipping_minimum_amount',0))
										<div class="custom-control custom-radio">
											<input type="radio" id="free_shipping" value="free_shipping" name="customRadio" class="custom-control-input select-shipping-method" {{ empty(Cart::getCondition(get_option('free_shipping_label'))) ? '' : 'checked' }}>
											<label class="custom-control-label" for="free_shipping">{{ get_option('free_shipping_label') }} ({!! xss_clean(_lang('Minimum Spend')).' '.xss_clean(show_price(get_option('free_shipping_minimum_amount',0))) !!})</label>
										</div>
									@endif

									@if(get_option('flat_rate_active') == 'Yes')
										<div class="custom-control custom-radio">
											<input type="radio" id="flat_rate" value="flat_rate" name="customRadio" class="custom-control-input select-shipping-method" {{ empty(Cart::getCondition(get_option('flat_rate_label'))) ? '' : 'checked' }}>
											<label class="custom-control-label" for="flat_rate">{{ get_option('flat_rate_label') }} + <b>{!! xss_clean(show_price(get_option('flat_rate_cost'))) !!}</b></label>
										</div>
									@endif

									@if(get_option('local_pickup_active') == 'Yes')
										<div class="custom-control custom-radio">
											<input type="radio" id="local_pickup" value="local_pickup" name="customRadio" class="custom-control-input select-shipping-method" {{ empty(Cart::getCondition(get_option('local_pickup_label'))) ? '' : 'checked' }}>
											<label class="custom-control-label" for="local_pickup">{{ get_option('local_pickup_label') }} + <b>{!! xss_clean(show_price(get_option('local_pickup_cost'))) !!}</b></label>
										</div>
									@endif
								</div>
							@endif

						</div>
					</div>
					<div class="col-lg-4 col-md-7 col-12">
						<div class="right">
							<ul>
								<li>{{ _lang('Cart Subtotal') }}<span>{!! xss_clean(show_price(\Cart::getSubTotal())) !!}</span></li>
								<!--<li>{{ _lang('Shipping') }}<span>Free</span></li>-->

								@foreach(Cart::getConditions() as $condition)
								<li>
									{{ $condition->getName() }}
									<span>
										@if($condition->getType() == 'shipping')
											+ {!! xss_clean(show_price(str_replace(array("+","-"),"",$condition->getValue()))) !!}
										@elseif($condition->getType() == 'coupon')
											- {!! xss_clean(show_price(str_replace(array("+","-"),"",$condition->getValue()))) !!}
										@elseif($condition->getType() == 'tax')
											+ {!! xss_clean(show_price(str_replace(array("+","-"),"",$condition->getValue()))) !!}
										@endif
									</span>

									@if($condition->getType() == 'coupon')
										<a href="{{ url('/remove_coupon/'.$condition->getName()) }}">
											<small class="text-danger">{{ _lang('Remove') }}</small>
										</a>
									@endif
								</li>
								@endforeach
								
								<li class="last">{{ _lang('Total') }}<span>{!! xss_clean(show_price(\Cart::getTotal())) !!}</span></li>
							</ul>
							<div class="button5">
								@if(! Cart::isEmpty())
								<a href="{{ url('/checkout') }}" class="btn">{{ _lang('Checkout') }}</a>
								@endif
								<a href="{{ url('/shop') }}" class="btn">{{ _lang('Continue shopping') }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Total Amount -->
		</div>
	</div>
</div>

		