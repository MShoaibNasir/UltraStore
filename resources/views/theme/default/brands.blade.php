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
						<li class="active"><a href="{{ url('/brands') }}">{{ _lang('Brands') }}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

	
<!-- Wish List -->
<div class="brands section">
	<div class="container">
		<div class="row">
			@foreach($brands as $brand)
				<div class="col-md-3">
					<div class="single-brand">
						<a href="{{ url('/brands/'.$brand->slug) }}">
							@if(isset($brand->logo->pivot))
								<img src="{{ asset('storage/app/'. $brand->logo->file_path) }}" alt="#">
							@else
								<img src="{{ asset('public/theme/default/images/no-brand-image.png') }}" alt="#">
							@endif
						</a>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</div>
<!--/ End Wish List -->

@include('theme.default.components.services')

@endsection

@section('js-script')
<script src="{{ asset('public/theme/default/js/cart.js?v=1.1') }}"></script>
@endsection