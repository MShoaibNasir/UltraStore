@extends('theme.default.website')

@section('content')
<!-- Slider Area -->
<section class="hero-slider">
	<!-- Single Slider -->
	<div class="single-slider" style="background-image: url('{{ get_option('hero_banner') != '' ? asset('public/uploads/media/'.get_option('hero_banner')) : asset('public/theme/default/images/slider-image2.jpg') }}')">
		<div class="container">
			<div class="row no-gutters">
				<div class="col-lg-9 offset-lg-3 col-12">
					<div class="text-inner">
						<div class="row">
							<div class="col-lg-7 col-12">
								<div class="hero-text">
									<h1>{!! xss_clean(get_trans_option('hero_title')) !!}</h1>
									<p>{!! xss_clean(get_trans_option('hero_content')) !!}</p>
									@if(get_trans_option('hero_button_text') != '')
										<div class="button">
											<a href="{{ get_trans_option('hero_button_link') }}" class="btn">{{ get_trans_option('hero_button_text') }}</a>
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--/ End Single Slider -->
</section>
<!--/ End Slider Area -->

@if(get_option('enable_three_column_banner') == 1)
	<!-- Start Small Banner  -->
	<section class="small-banner section">
		<div class="container-fluid">
			<div class="row">

				<!-- Single Banner  -->
				<div class="col-lg-4 col-md-6 col-12">
					<div class="single-banner">
						<img src="{{ get_option('three_column_1_background_image') != '' ? asset('public/uploads/media/'.get_option('three_column_1_background_image')) : asset('public/theme/default/images/no-banner.jpg') }}" alt="#">
						<div class="content">
							<p>{{ get_trans_option('three_column_1_title') }}</p>
							<h3>{!! xss_clean(get_trans_option('three_column_1_sub_title')) !!}</h3>
							<a href="{{ get_trans_option('three_column_1_button_link') }}">{{ get_trans_option('three_column_1_button_text') }}</a>
						</div>
					</div>
				</div>
				<!-- /End Single Banner  -->


				<!-- Single Banner  -->
				<div class="col-lg-4 col-md-6 col-12">
					<div class="single-banner">
						<img src="{{ get_option('three_column_2_background_image') != '' ? asset('public/uploads/media/'.get_option('three_column_2_background_image')) : asset('public/theme/default/images/no-banner.jpg') }}" alt="#">
						<div class="content">
							<p>{{ get_trans_option('three_column_2_title') }}</p>
							<h3>{!! xss_clean(get_trans_option('three_column_2_sub_title')) !!}</h3>
							<a href="{{ get_trans_option('three_column_2_button_link') }}">{{ get_trans_option('three_column_2_button_text') }}</a>
						</div>
					</div>
				</div>
				<!-- /End Single Banner  -->

				<!-- Single Banner  -->
				<div class="col-lg-4 col-12">
					<div class="single-banner tab-height">
						<img src="{{ get_option('three_column_3_background_image') != '' ? asset('public/uploads/media/'.get_option('three_column_3_background_image')) : asset('public/theme/default/images/no-banner.jpg') }}" alt="#">
						<div class="content">
							<p>{{ get_trans_option('three_column_3_title') }}</p>
							<h3>{!! xss_clean(get_trans_option('three_column_3_sub_title')) !!}</h3>
							<a href="{{ get_trans_option('three_column_3_button_link') }}">{{ get_trans_option('three_column_3_button_text') }}</a>
						</div>
					</div>
				</div>
				<!-- /End Single Banner  -->

			</div>
		</div>
	</section>
	<!-- End Small Banner -->
@endif


@if(get_option('enable_trending_items') == 1)
<!-- Start Product Area -->
<div class="product-area section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h2>{{ get_trans_option('trending_items_title') }}</h2>
				</div>
			</div>
		</div>

		@php $trending_categories = \App\Entity\Category\Category::whereIn('id', get_option('trending_categories'))->get(); @endphp

		<div class="row">
			<div class="col-12">
				<div class="product-info">
					<div class="nav-main">
						<!-- Tab Nav -->
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							@foreach($trending_categories as $trending_category)
								<li class="nav-item"><a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#trending_category{{ $trending_category->id }}" role="tab">{{ $trending_category->translation->name }}</a></li>
							@endforeach
						</ul>
						<!--/ End Tab Nav -->
					</div>
					<div class="tab-content" id="myTabContent">
						<!-- Start Single Tab -->
						@foreach($trending_categories as $trending_category)
						<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="trending_category{{ $trending_category->id }}" role="tabpanel">
							<div class="tab-single">
								<div class="row">
									@php $products = $trending_category->products; @endphp
									@include('theme.default.components.product-grid',['class' => 'col-xl-3'])
								</div>
							</div>
						</div>
						@endforeach
						<!--/ End Single Tab -->
				
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Product Area -->
@endif

@if(get_option('enable_hot_items') == 1)
<!-- Start Most Popular -->
<div class="product-area most-popular section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h2>{{ get_trans_option('hot_items_title') }}</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="owl-carousel popular-slider">

					@php $hot_items = \App\Entity\Product\Product::whereIn('id', get_option('hot_items',[]))->get(); @endphp
					
					@foreach($hot_items as $hot_item)
						<!-- Start Single Product -->
						<div class="single-product">
							<div class="product-img">
								<a href="{{ url('product/'.$hot_item->slug) }}">
									<img class="default-img" src="{{ asset('storage/app/'. $hot_item->image->file_path) }}" alt="{{ $hot_item->translation->name }}">
									@if($hot_item->in_stock == 0)
										<span class="out-of-stock">{{ _lang('Out Of Stock') }}</span>
									@elseif($hot_item->featured_tag != NULL)
										<span class="{{ $hot_item->featured_tag }}">{{ _dlang(str_replace('_',' ',$hot_item->featured_tag)) }}</span>
									@endif
								</a>
								<div class="button-head">
									<div class="product-action">
										<a href="{{ url('product/'.$hot_item->slug) }}" title="{{ _lang('Quick View') }}" class="quick-shop">
											<i class=" ti-eye"></i><span>{{ _lang('Quick Shop') }}</span>
										</a>
										
										<a title="{{ _lang('Wishlist') }}" class="btn-wishlist" href="{{ wishlist_url($hot_item) }}"><i class=" ti-heart "></i><span>{{ _lang('Add to Wishlist') }}</span></a>
									</div>
									<div class="product-action-2">
										@if($hot_item->product_type != 'variable_product')
										    @if($hot_item->in_stock == 1)
												<a title="Add to cart" class="add_to_cart" data-type="{{ $hot_item->product_type }}" href="{{ url('add_to_cart/'.$hot_item->id) }}">{{ _lang('Add to cart') }}</a>
											@else
												<a title="Add to cart" class="btn-link disabled" href="#">{{ _lang('Add to cart') }}</a>
											@endif
										@else
											<a title="View Options" href="{{ url('product/'.$hot_item->slug) }}">{{ _lang('View Options') }}</a>
										@endif
									</div>
								</div>
							</div>

							<div class="product-content">
								<h3><a href="{{ url('product/'.$hot_item->slug) }}">{{ $hot_item->translation->name }}</a></h3>
								
								@if($hot_item->product_type != 'variable_product')
									<div class="product-price">		
										@if($hot_item->special_price != '' || (int) $hot_item->special_price != 0 )
											<span class="text-danger">
												<s>{!! xss_clean(show_price($hot_item->price)) !!}</s>
											</span>
											<span class="text-success">{!! xss_clean(show_price($hot_item->special_price)) !!}</span>
										@else
											<span>{!! xss_clean(show_price($hot_item->price)) !!}</span>	
										@endif
									</div>
								@else
									<div class="product-price">		
										@if($hot_item->variation_prices[0]->special_price != '' || (int) $hot_item->variation_prices[0]->special_price != 0 )
											<span class="text-danger">
												<s>{!! xss_clean(show_price($hot_item->variation_prices[0]->price)) !!}</s>
											</span>
											<span class="text-success">
												{!! xss_clean(show_price($hot_item->variation_prices[0]->special_price)) !!} 
												- 
												{!! xss_clean(show_price($hot_item->variation_prices[count($hot_item->variation_prices) - 1]->special_price)) !!}
											</span>
										@else
											<span>
												{!! xss_clean(show_price($hot_item->variation_prices[0]->price)) !!}
												- 
												{!! xss_clean(show_price($hot_item->variation_prices[count($hot_item->variation_prices) - 1]->price)) !!}
											</span>	
										@endif
									</div>
								@endif

								<div class="product-rating">
									<ul class="reviews">
										{!! xss_clean(show_rating($hot_item->reviews->avg('rating'))) !!}
									</ul>
								</div>

							</div>
						</div>
						<!-- End Single Product -->
					@endforeach
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Most Popular Area -->

<!-- Start Shop Home List  -->
<section class="shop-home-list section">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-6 col-12">
				<div class="row">
					<div class="col-12">
						<div class="shop-section-title">
							<h1>{{ get_trans_option('on_sale_items_title') }}</h1>
						</div>
					</div>
				</div>

				@php $on_sale_items = \App\Entity\Product\Product::whereIn('id', get_option('on_sale_items',[]))->get(); @endphp

				@foreach($on_sale_items as $on_sale_item)
					<!-- Start Single List  -->
					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="{{ asset('storage/app/'. $on_sale_item->image->file_path) }}" alt="#">
									<a href="{{ url('product/'.$on_sale_item->slug) }}" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h4 class="title"><a href="{{ url('product/'.$on_sale_item->slug) }}">{{ $on_sale_item->translation->name }}</a></h4>
										
									<div class="product-price">		
										@if($on_sale_item->special_price != '' || (int) $on_sale_item->special_price != 0 )
											<p class="price with-discount">{!! xss_clean(show_price($on_sale_item->special_price)) !!}</p>
										@else
											<p class="price with-discount">{!! xss_clean(show_price($on_sale_item->price)) !!}</p>	
										@endif
									</div>

								</div>
							</div>
						</div>
					</div>
					<!-- End Single List  -->
				@endforeach
				
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<div class="row">
					<div class="col-12">
						<div class="shop-section-title">
							<h1>{{ get_trans_option('best_seller_title') }}</h1>
						</div>
					</div>
				</div>

				@php 
					$best_seller_items = \App\Entity\Product\Product::whereIn('id', get_option('best_seller_items',[]))->get(); 
				@endphp

				@foreach($best_seller_items as $best_seller_item)
					<!-- Start Single List  -->
					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="{{ asset('storage/app/'. $best_seller_item->image->file_path) }}" alt="#">
									<a href="{{ url('product/'.$best_seller_item->slug) }}" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h4 class="title"><a href="{{ url('product/'.$best_seller_item->slug) }}">{{ $best_seller_item->translation->name }}</a></h4>
										
									<div class="product-price">		
										@if($best_seller_item->special_price != '' || (int) $best_seller_item->special_price != 0 )
											<p class="price with-discount">{!! xss_clean(show_price($best_seller_item->special_price)) !!}</p>
										@else
											<p class="price with-discount">{!! xss_clean(show_price($best_seller_item->price)) !!}</p>	
										@endif
									</div>

								</div>
							</div>
						</div>
					</div>
					<!-- End Single List  -->
				@endforeach
				
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<div class="row">
					<div class="col-12">
						<div class="shop-section-title">
							<h1>{{ get_trans_option('top_views_title') }}</h1>
						</div>
					</div>
				</div>

				@php 
					$top_views_items = \App\Entity\Product\Product::whereIn('id', get_option('top_views_items',[]))->get(); 
				@endphp

				@foreach($top_views_items as $top_views_item)
					<!-- Start Single List  -->
					<div class="single-list">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-12">
								<div class="list-image overlay">
									<img src="{{ asset('storage/app/'. $top_views_item->image->file_path) }}" alt="#">
									<a href="{{ url('product/'.$top_views_item->slug) }}" class="buy"><i class="fa fa-shopping-bag"></i></a>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-12 no-padding">
								<div class="content">
									<h4 class="title"><a href="{{ url('product/'.$top_views_item->slug) }}">{{ $top_views_item->translation->name }}</a></h4>
										
									<div class="product-price">		
										@if($top_views_item->special_price != '' || (int) $top_views_item->special_price != 0 )
											<p class="price with-discount">{!! xss_clean(show_price($top_views_item->special_price)) !!}</p>
										@else
											<p class="price with-discount">{!! xss_clean(show_price($top_views_item->price)) !!}</p>	
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End Single List  -->
				@endforeach
	
			</div>
		</div>
	</div>
</section>
<!-- End Shop Home List  -->
@endif

@include('theme.default.components.services')

@endsection

@section('js-script')
<script src="{{ asset('public/theme/default/js/cart.js?v=1.1') }}"></script>
@endsection