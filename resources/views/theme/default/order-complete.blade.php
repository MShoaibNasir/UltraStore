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
						<li class="active"><a href="">{{ _lang('Order Placed') }}</a></li>
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

			<div class="col-lg-12">	
				<div class="order-success">
					<i class="ti-check-box"></i>
					<h2>{{ _lang('Your Order has been Placed Sucessfully') }}</h2>
					<p>{{ _lang('Your Order ID') }}#: {{ $order->id }}</p>
					<a href="{{ url('/shop') }}" class="btn-back-to-store">{{ _lang('Back to Store') }}</a>
				</div>
			</div>
		</div>
	</div>
</section>
<!--/ End Checkout -->

@endsection

