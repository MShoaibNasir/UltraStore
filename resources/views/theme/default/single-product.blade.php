@extends('theme.default.website')

@section('content')

<link rel="stylesheet" href="{{ asset('public/theme/default/css/css-stars.css') }}">

<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="{{ url('') }}">{{ _lang('Home') }}<i class="ti-arrow-right"></i></a></li>
						
						@foreach($product->categories as $category)
							<li>
								<a href="{{ url('/categories/'.$category->slug) }}">{{ $category->translation->name }}<i class="ti-arrow-right"></i></a>
							</li>
						@endforeach

						<li class="active">
							<a href="{{ url('/shop/'.$product->slug) }}">{{ $product->translation->name }}</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->
		
			
<section class="shop single section">
	<div class="container">
		<div class="row"> 
			<div class="col-12">
				<div class="row">
					<div class="col-lg-6 col-12">
						<!-- Product Slider -->
						<div class="product-gallery">
							<!-- Images slider -->
							<div class="flexslider-thumbnails">
								<ul class="slides">
									<li data-thumb="{{ asset('storage/app/'. $product->image->file_path) }}" rel="adjustX:10, adjustY:">
										<img src="{{ asset('storage/app/'. $product->image->file_path) }}" alt="#">
									</li>
									@if(isset($product->gallery_images))
										@foreach($product->gallery_images as $gallery_image)
											<li data-thumb="{{ asset('storage/app/'. $gallery_image->file_path) }}">
												<img src="{{ asset('storage/app/'. $gallery_image->file_path) }}" alt="#">
											</li>
										@endforeach
								    @endif
	
								</ul>
							</div>
							<!-- End Images slider -->
						</div>
						<!-- End Product slider -->
					</div>
					<div class="col-lg-6 col-12">
						<div class="product-des">
							<!-- Description -->
							<div class="short">
								<h4>{{ $product->translation->name }}</h4>
								
								<div class="rating-main">
									<ul class="rating">
										{!! xss_clean(show_rating($product->reviews->avg('rating'))) !!}
									</ul>
									<a href="#" class="total-review">({{ $product->reviews->count() }}) {{ _lang('Review') }}</a>
								</div>

								@if($product->product_type != 'variable_product')
									<p class="price">
										@if($product->special_price != '' || (int) $product->special_price != 0 )
											<span class="discount">{!! xss_clean(show_price($product->special_price)) !!}</span>
											<s>{!! xss_clean(show_price($product->price)) !!}</s> 
										@else
											<span class="discount">{!! xss_clean(show_price($product->price)) !!}</span>
										@endif
									</p>
								@else
									<p class="price">
										@if($product->variation_prices[0]->special_price != '' || (int) $product->variation_prices[0]->special_price != 0 )
											<span class="discount">{!! xss_clean(show_price($product->variation_prices[0]->special_price)) !!}</span>
											<s>{!! xss_clean(show_price($product->variation_prices[0]->price)) !!}</s> 
										@else
											<span class="discount">{!! xss_clean(show_price($product->variation_prices[0]->price)) !!}</span>
										@endif
									</p>
								@endif

								<p class="description">{{ $product->translation->short_description }}</p>
							</div>
							<!--/ End Description -->


							<!-- Product Options -->
							@if(! $product->product_options->isEmpty())
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
								<div class="clearfix"></div>
							@endif

							<!--/ End Product Options -->

							<!-- Product Buy -->
							<div class="product-buy">
								<div class="quantity">
									<h6>{{ _lang('Quantity') }} :</h6>
									<!-- Input Order -->
									<div class="input-group">
										<div class="button minus">
											<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quantity">
												<i class="ti-minus"></i>
											</button>
										</div>
										<input type="text" name="quantity" class="input-number" data-min="1" data-max="1000" value="1">
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



								<p class="cat">{{ _lang('Category') }} : {{ $product->categories->count() == 0 ? _lang('N/A') : '' }}
									@foreach($product->categories as $category)
									<a href="{{ url('/categories/'.$category->slug) }}">{{ $category->translation->name }}</a>
									@endforeach
								</p>

								@if($product->sku != '')
									<p class="sku">{{ _lang('SKU') }} : {{ $product->sku }}</p>
								@endif

								@if($product->manage_stock == 1 && $product->in_stock == 1)
									<p class="availability">{{ _lang('Availability') }} : {{ $product->qty.' '._lang('Product In Stock') }}</p>
								@endif

								@if($product->in_stock == 0)
									<p class="availability">{{ _lang('Availability') }} : <span class="text-danger">{{ _lang('Out Of Stock') }}</span></p>
								@endif

							</div>
							<!--/ End Product Buy -->
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="product-info">
							<div class="nav-main">
								<!-- Tab Nav -->
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">{{ _lang('Description') }}</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab">{{ _lang('Reviews') }} ({{ $product->reviews->count() }})</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#comments" role="tab">{{ _lang('Comments') }} ({{ $product->comments->count() }})</a></li>
								</ul>
								<!--/ End Tab Nav -->
							</div>
							<div class="tab-content" id="myTabContent">
								<!-- Description Tab -->
								<div class="tab-pane fade show active" id="description" role="tabpanel">
									<div class="tab-single">
										<div class="row">
											<div class="col-12">
												<div class="single-des">
													{!! xss_clean($product->translation->description) !!}
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--/ End Description Tab -->

								<!-- Reviews Tab -->
								<div class="tab-pane fade" id="reviews" role="tabpanel">
									<div class="tab-single review-panel">
										<div class="row">
											<div class="col-12">
												<div class="ratting-main">

													<div class="avg-ratting">
														<h5><span class="total-reviews">{{ $product->reviews->count() }}</span> {{ _lang('Reviews for').' '.$product->translation->name }}</h5>
													</div>

													@if(\Session::has('success'))
														<div class="alert alert-success mt-4">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<span>{!! xss_clean(session('success')) !!}</span>
														</div>
													@endif

													@foreach($product->reviews as $review)
													<!-- Single Rating -->
													<div class="single-rating">
														<div class="rating-author">
															<img src="{{ profile_picture($review->user->profile_picture) }}" alt="{{ _lang('Profile Picture') }}">
														</div>
														<div class="rating-des">
															<h6>{{ $review->user->name }}</h6>
															<div class="ratings">
																<ul class="rating">
																	{!! xss_clean(show_rating($review->rating)) !!}
																</ul>
																<div class="rate-count">(<span>{{ $review->rating }}</span>)</div>
															</div>
															<p>{{ $review->comment }}</p>
														</div>
													</div>
													<!--/ End Single Rating -->
													@endforeach

												</div>
												<!-- Review -->
												<div class="comment-review">
													<div class="add-review">
														<h5>{{ _lang('Add A Review') }}</h5>

														@if(! auth()->check())
															<p>{{ _lang('You need to login for writing a review.') }} <a href="{{ url('sign_in') }}" class="btn-link">{{ _lang('Login to your account') }}</a></p>
														@endif
													</div>

												</div>
												<!--/ End Review -->
												<!-- Form -->
												<form class="form reviews-form" method="post" action="{{ route('reviews.store') }}">
													@csrf
													<div class="row">
														<div class="col-lg-12 col-12">
															<div class="form-group">
																<label>{{ _lang('Your Rating') }}<span>*</span></label>
																<select class="ratng-bar" name="rating" rquired>
																  <option value="1">{{ _lang('1') }}</option>
																  <option value="2">{{ _lang('2') }}</option>
																  <option value="3">{{ _lang('3') }}</option>
																  <option value="4">{{ _lang('4') }}</option>
																  <option value="5">{{ _lang('5') }}</option>
																</select>	
															</div>
														</div>
														
														<div class="col-lg-12 col-12">
															<div class="form-group">
																<label>{{ _lang('Write a review') }}<span>*</span></label>
																<textarea name="comment" rows="6" required="true" {{ ! auth()->check() ? 'disabled' : '' }}></textarea>
																<input type="hidden" name="product_id" value="{{ $product->id }}" />
															</div>
														</div>

														<div class="col-lg-12 col-12">
															<div class="form-group button5">	
																<button type="submit" class="btn" {{ ! auth()->check() ? 'disabled' : '' }}>{{ _lang('Submit') }}</button>
															</div>
														</div>
													</div>
												</form>
												<!--/ End Form -->
											</div>
										</div>
									</div>
								</div>
								<!--/ End Reviews Tab -->


								<!-- Comments Tab -->
								<div class="tab-pane fade" id="comments" role="tabpanel">
									<div class="tab-single">
										<div class="row">
											<div class="col-12">
												<div class="comments">
													<h3 class="comment-title">{{ _lang('Comments') }} (<span class="comments-count">{{ $product->comments->count() }}</span>)</h3>
													
													@if(\Session::has('success'))
														<div class="alert alert-success mt-4">
															<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
															<span>{!! xss_clean(session('success')) !!}</span>
														</div>
													@endif

													<div id="comment-list">
														@if($product->comments->count() == 0)
															<p class="mb-4">{{ _lang('No Comments found !') }}</p>
														@endif

														@include('theme.default.components.comments', ['comments' => $product->comments, 'product_id' => $product->id])
													</div>

												</div>
											</div>

											<div class="col-12">			
												<div class="reply">
													<div class="reply-head">
														<h2 class="reply-title">{{ _lang('Leave Your Comment') }}</h2>
														
														@if(! auth()->check())
															<p>{{ _lang('You need login for posting a comment.') }} <a href="{{ url('sign_in') }}" class="btn-link">{{ _lang('Login to your account') }}</a></p>
														
														@endif
														<!-- Comment Form -->
														<form class="form comment-form" method="post" action="{{ route('comments.store') }}">
															@csrf
															<div class="row">
																<div class="col-12">
																	<div class="form-group">
																		<label>{{ _lang('Your Comment') }}<span>*</span></label>
																		<textarea name="body" required="true" {{ ! auth()->check() ? 'disabled' : '' }}></textarea>
																		<input type="hidden" name="product_id" value="{{ $product->id }}" />
																	</div>
																</div>
																<div class="col-12">
																	<div class="form-group button">
																		<button type="submit" class="btn" {{ ! auth()->check() ? 'disabled' : '' }}>{{ _lang('Post Comment') }}</button>
																	</div>
																</div>
															</div>
														</form>
														<!-- End Comment Form -->
														
													</div>
												</div>			
											</div>

										</div>
									</div>
								</div>
								<!--/ End Comments Tab -->

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
			
@endsection

@section('js-script')
<script src="{{ asset('public/theme/default/js/jquery.barrating.min.js') }}"></script>
<script src="{{ asset('public/theme/default/js/product-options.js?v=1.1') }}"></script>
<script src="{{ asset('public/theme/default/js/cart.js?v=1.1') }}"></script>
@endsection
