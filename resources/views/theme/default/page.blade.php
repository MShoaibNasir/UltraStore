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
						<li class="active"><a href="{{ url('') }}">{{ $page->translation->title }}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

	
<!-- Wish List -->
<div class="section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<p>{!! xss_clean($page->translation->body) !!}</p>
			</div>
		</div>
	</div>
</div>
<!--/ End Wish List -->

		
@include('theme.default.components.services')

@endsection

@section('js-script')
<script src="{{ asset('public/theme/default/js/cart.js?v=1.1') }}"></script>
@endsection