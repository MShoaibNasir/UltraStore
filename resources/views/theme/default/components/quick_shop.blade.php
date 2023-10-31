<div class="row no-gutters">					
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		<!-- Product Slider -->
		<div class="product-gallery">
			<div class="quickview-slider-active">
				<div class="single-slider">
					<img src="{{ asset('storage/app/'. $product->image->file_path) }}" alt="#">
				</div>
				@if(isset($product->gallery_images))
					@foreach($product->gallery_images as $gallery_image)
						<div class="single-slider">
							<img src="{{ asset('storage/app/'. $gallery_image->file_path) }}" alt="#">
						</div>
					@endforeach
				@endif
			</div>
		</div>
		<!-- End Product slider -->
	</div>

	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		<div class="quickview-content">
			<h2>{{ $product->translation->name }}</h2>
			<div class="quickview-ratting-review">
				<div class="quickview-ratting-wrap">
					<div class="quickview-ratting">
						{!! xss_clean(show_rating($product->reviews->avg('rating'), 'i')) !!}
					</div>
					<a href="#"> ({{ $product->reviews->count().' '._lang('customer review') }})</a>
				</div>
				<div class="quickview-stock">
					@if($product->manage_stock == 1 && $product->in_stock == 1)
						<span><i class="fa fa-check-circle-o"></i> {{ _lang('in stock') }}</span>
					@endif

					@if($product->in_stock == 0)
						<span><i class="fa fa-times-circle"></i> {{ _lang('Out Of Stock') }}</span>
					@endif
				</div>
			</div>

			@if($product->product_type != 'variable_product')
				@if($product->special_price != '' || (int) $product->special_price != 0 )
					<h3>
						<s>{!! xss_clean(show_price($product->price)) !!}</s>&nbsp;&nbsp;
						<span class="ac-price">{!! xss_clean(show_price($product->special_price)) !!}</span>
					</h3>
				@else
					<h3 class="ac-price">{!! xss_clean(show_price($product->price)) !!}</h3>
				@endif
			@else
				@if($product->variation_prices[0]->special_price != '' || (int) $product->variation_prices[0]->special_price != 0 )
					<h3>
						<span class="ac-price">{!! xss_clean(show_price($product->variation_prices[0]->special_price)) !!}</span>
						<s>{!! xss_clean(show_price($product->variation_prices[0]->price)) !!}</s> 
					</h3>
				@else
					<h3 class="ac-price">{!! xss_clean(show_price($product->variation_prices[0]->price)) !!}</h3>
				@endif
			@endif

			<div class="quickview-peragraph">
				<p>{{ $product->translation->short_description }}</p>
			</div>

			<!-- Product Options -->
			@if(! $product->product_options->isEmpty())
				<div class="size">
					<form action="{{ url('products/get_variation_price/'.$product->id) }}" id="product-variation">
						@csrf
						@foreach($product->product_options as $product_option)	
							<div class="product_options">
								<h6>{{ $product_option->name }}</h6>
								<select name="product_option[]" class="select_product_option">
									@foreach($product_option->items as $item)
										<option value="{{ $item->id }}">{{ $item->name }}</option>
									@endforeach
								</select>
							</div>
						@endforeach
					</form>
				</div>
				<div class="clearfix"></div>
			@endif

			
			<div class="quantity">
				<!-- Input Order -->
				<div class="input-group">
					<div class="button minus">
						<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quantity">
							<i class="ti-minus"></i>
						</button>
					</div>
					<input type="text" name="quantity" class="input-number"  data-min="1" data-max="1000" value="1">
					<div class="button plus">
						<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quantity">
							<i class="ti-plus"></i>
						</button>
					</div>
				</div>
				<!--/ End Input Order -->
			</div>
			<div class="add-to-cart">
				@if($product->in_stock == 1)
					<a href="{{ url('add_to_cart/'.$product->id) }}" data-type="{{ $product->product_type }}" class="btn add_to_cart">{{ _lang('Add to Cart') }}</a>
				@else
					<a href="#" class="btn disabled">{{ _lang('Add to Cart') }}</a>
				@endif
				<a href="{{ wishlist_url($product) }}" class="btn min btn-wishlist"><i class="ti-heart"></i></a>
			</div>
		</div>
	</div>
</div>


<script src="{{ asset('public/theme/default/js/product-options.js?v=1.1') }}"></script>
<script src="{{ asset('public/theme/default/js/cart.js?v=1.1') }}"></script>
<script>
@if($product->gallery_images->count() > 0)
	$('.quickview-slider-active').owlCarousel({
		items:1,
		autoplay:true,
		autoplayTimeout:5000,
		smartSpeed: 400,
		autoplayHoverPause:true,
		nav:true,
		loop:true,
		merge:true,
		dots:false,
		navText: ['<i class=" ti-arrow-left"></i>', '<i class=" ti-arrow-right"></i>'],
	});
@endif
</script>
