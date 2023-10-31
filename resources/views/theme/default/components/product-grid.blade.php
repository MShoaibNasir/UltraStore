@foreach($products as $product)
	<div class="col-lg-4 col-md-6 col-12 {{ isset($class) ? $class : '' }}">
		<div class="single-product">
			<div class="product-img">
				<a href="{{ url('product/'.$product->slug) }}">
					<img class="default-img" src="{{ asset('storage/app/'. $product->image->file_path) }}" alt="{{ $product->translation->name }}">
					@if($product->in_stock == 0)
						<span class="out-of-stock">{{ _lang('Out Of Stock') }}</span>
					@elseif($product->featured_tag != NULL)
						<span class="{{ $product->featured_tag }}">{{ _dlang(str_replace('_',' ',$product->featured_tag)) }}</span>
					@endif
				</a>
				<div class="button-head">
					<div class="product-action">
						<a href="{{ url('product/'.$product->slug) }}" title="{{ _lang('Quick View') }}" class="quick-shop">
							<i class=" ti-eye"></i><span>{{ _lang('Quick Shop') }}</span>
						</a>
						
						<a title="{{ _lang('Wishlist') }}" class="btn-wishlist" href="{{ wishlist_url($product) }}"><i class=" ti-heart "></i><span>{{ _lang('Add to Wishlist') }}</span></a>
					</div>
					<div class="product-action-2">
						@if($product->product_type != 'variable_product')
						    @if($product->in_stock == 1)
								<a title="Add to cart" class="add_to_cart" data-type="{{ $product->product_type }}" href="{{ url('add_to_cart/'.$product->id) }}">{{ _lang('Add to cart') }}</a>
							@else
								<a title="Add to cart" class="btn-link disabled" href="#">{{ _lang('Add to cart') }}</a>
							@endif
						@else
							<a title="View Options" href="{{ url('product/'.$product->slug) }}">{{ _lang('View Options') }}</a>
						@endif
					</div>
				</div>
			</div>

			<div class="product-content">
				<h3><a href="{{ url('product/'.$product->slug) }}">{{ $product->translation->name }}</a></h3>
				
				@if($product->product_type != 'variable_product')
					<div class="product-price">		
						@if($product->special_price != '' || (int) $product->special_price != 0 )
							<span class="text-danger">
								<s>{!! xss_clean(show_price($product->price)) !!}</s>
							</span>
							<span class="text-success">{!! xss_clean(show_price($product->special_price)) !!}</span>
						@else
							<span>{!! xss_clean(show_price($product->price)) !!}</span>	
						@endif
					</div>
				@else
					<div class="product-price">		
						@if($product->variation_prices[0]->special_price != '' || (int) $product->variation_prices[0]->special_price != 0 )
							<span class="text-danger">
								<s>{!! xss_clean(show_price($product->variation_prices[0]->price)) !!}</s>
							</span>
							<span class="text-success">
								{!! xss_clean(show_price($product->variation_prices[0]->special_price)) !!} 
								- 
								{!! xss_clean(show_price($product->variation_prices[count($product->variation_prices) - 1]->special_price)) !!}
							</span>
						@else
							<span>
								{!! xss_clean(show_price($product->variation_prices[0]->price)) !!}
								- 
								{!! xss_clean(show_price($product->variation_prices[count($product->variation_prices) - 1]->price)) !!}
							</span>	
						@endif
					</div>
				@endif

				<div class="product-rating">
					<ul class="reviews">
						{!! xss_clean(show_rating($product->reviews->avg('rating'))) !!}
					</ul>
				</div>

			</div>
		</div>
	</div>
	@endforeach