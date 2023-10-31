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
						<li class="active"><a href="{{ url('/shop') }}">{{ _lang('Shop') }}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

<!-- Product Style -->
<section class="product-area shop section">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-12">
				<div id="sidebar-expander"></div>
				<div class="shop-sidebar">
					<!-- Single Widget -->
					<div class="single-widget category" id="sidebar-category">
						<h3 class="title">{{ _lang('Categories') }}</h3>
						@php $slug = isset($slug) ? $slug : ''; @endphp
						{{ buildTreeCollapse(App\Entity\Category\Category::all(), 0, 'categories', $slug) }}
					</div>
					<!--/ End Single Widget -->

					<!-- Shop By Price -->
					<div class="single-widget range">
						<h3 class="title">{{ _lang('Shop by Price') }}</h3>
						<div class="price-filter">
							<div class="price-filter-inner">
								<div id="slider-range" data-min="0" data-max="{{ get_max_price() }}" data-value="{{ isset($_GET['end_price']) ? $_GET['end_price'] : get_max_price() }}"></div>
								
								<div class="price_slider_amount">
									<div class="label-input">
										<input type="text" id="amount" class="text-center" name="price" placeholder="{{ _lang('Add Your Price') }}"/>
										<input type="hidden" id="start_price" value="0" class="filter"/>
										<input type="hidden" id="end_price" value="{{ isset($_GET['end_price']) ? $_GET['end_price'] : get_max_price() }}" class="filter"/>
									</div>
								</div>
							</div>
							<button type="button" class="btn btn-block py-2 mt-2" id="filter_by_price">{{ _lang('Filter') }}</button>	
						</div>

					</div>
					<!--/ End Shop By Price -->

					<!-- Single Widget -->
					<div class="single-widget category">
						<h3 class="title">{{ _lang('Brands') }}</h3>
						<ul class="categor-list">
							@php $brand_slug = isset($brand_slug) ? $brand_slug : ''; @endphp
							@foreach(\App\Entity\Brand\Brand::all() as $brand)
								<li><a href="{{ filter_url('/brands/'.$brand->slug) }}" class="{{ $brand_slug == $brand->slug ? 'active' : '' }}">{{ $brand->translation->name }}</a></li>
							@endforeach
						</ul>
					</div>
					<!--/ End Single Widget -->

					<!-- Single Widget -->
					<div class="single-widget category">
						<h3 class="title">{{ _lang('Tags') }}</h3>
						<ul class="categor-list">
							@php $tag_slug = isset($tag_slug) ? $tag_slug : ''; @endphp
							@foreach(\App\Entity\Tag\Tag::all() as $tag)
								<li>
									<a href="{{ filter_url('/tags/'.$tag->slug) }}" class="{{ $tag_slug == $tag->slug ? 'active' : '' }}">{{ $tag->translation->name }}</a>
								</li>
							@endforeach
						</ul>
					</div>
					<!--/ End Single Widget -->
				</div>
			</div>

			<div class="col-lg-9 col-12">
				<div class="row">
					<div class="col-12">
						<!-- Shop Top -->
						<div class="shop-top">
							<div class="shop-shorter">
								<div class="single-shorter">
									@php $length = isset($_GET['length']) ? $_GET['length'] : ''; @endphp
									<label>{{ _lang('Show') }} :</label>
									<select id="length" class="filter">
										<option value="09" {{ $length == '09' ? 'selected' : '' }}>09</option>
										<option value="15" {{ $length == '15' ? 'selected' : '' }}>15</option>
										<option value="25" {{ $length == '25' ? 'selected' : '' }}>25</option>
										<option value="30" {{ $length == '30' ? 'selected' : '' }}>30</option>
									</select>
								</div>
								<div class="single-shorter">
									@php $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : ''; @endphp
									<label>{{ _lang('Sort By') }} :</label>
									<select id="sort_by" class="filter">
										<option value="default">{{ _lang('Default') }}</option>
										<option value="oldest" {{ $sort_by == "oldest" ? "selected" : "" }}>{{ _lang('Oldest') }}</option>
										<option value="newest" {{ $sort_by == "newest" ? "selected" : "" }}>{{ _lang('Newest') }}</option>
										<option value="low_to_high" {{ $sort_by == "low_to_high" ? "selected" : "" }}>{{ _lang('Price: Low to High') }}</option>
										<option value="high_to_low" {{ $sort_by == "high_to_low" ? "selected" : "" }}>{{ _lang('Price: High to Low') }}</option>
										<option value="a_to_z" {{ $sort_by == "a_to_z" ? "selected" : "" }}>{{ _lang('Name: A-Z') }}</option>
										<option value="z_to_a" {{ $sort_by == "z_to_a" ? "selected" : "" }}>{{ _lang('Name: Z-A') }}</option>
									</select>
								</div>
							</div>
						</div>
						<!--/ End Shop Top -->
					</div>
				</div>

				<div class="row">
					@if($products->isEmpty())
						<div class="col-12">
							<h5 class="text-center mt-5">{{ _lang('No products found !') }}</h5>
						</div>
					@endif

					@include('theme.default.components.product-grid')

					<!--Pagination-->
					<div class="col-lg-12">
						{{ $products->links() }}
					</div>

				</div><!--End Row-->

			</div>
		</div>
	</div>
</section>
<!--/ End Product Style 1  -->	

@endsection

@section('js-script')
<script src="{{ asset('public/theme/default/js/cart.js?v=1.1') }}"></script>
@endsection