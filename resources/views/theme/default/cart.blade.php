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
						<li class="active"><a href="">{{ _lang('Cart') }}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->
	
<!-- Shopping Cart -->
<div class="shopping-cart section">
	@include('theme.default.components.cart-body')
</div>
<!--/ End Shopping Cart -->
		
@include('theme.default.components.services')

@endsection

@section('js-script')
<script src="{{ asset('public/theme/default/js/cart.js?v=1.1') }}"></script>
@endsection