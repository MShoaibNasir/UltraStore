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
						<li class="active"><a href="">{{ _lang('My Orders') }}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->
	
<!-- Login Screen -->
<section id="auth"> 
	<div class="container">
		<div class="row">
		   <div class="col-lg-3 col-md-4">
			  <div class="customer_dashboard">
				 @include('theme.default.customer.my_account.menu')
			  </div>
		   </div>
		   <div class="col-lg-9 col-md-8">
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
							
				<div class="dashboard_content">
					<div class="card">
						<div class="card-header">
						   <h4>{{ _lang('My Orders') }}</h4>
						</div>
						<div class="card-body">
						   <div class="table-responsive">
						   		<table class="table table-bordered">
						   			<thead>
						   				<th>{{ _lang('Order ID') }}</th>
						   				<th>{{ _lang('Date') }}</th>
						   				<th>{{ _lang('Total') }}</th>
						   				<th>{{ _lang('Order Status') }}</th>
						   				<th>{{ _lang('Payment Status') }}</th>
						   				<th class="text-center">{{ _lang('Action') }}</th>
						   			</thead>
						   			<tbody>
						   				@if($orders->count() == 0)
											<tr>
							   					<td colspan="6" class="text-center">{{ _lang('No Order found !') }}</td>
							   				</tr>
						   				@endif
						   				
							   			@foreach($orders as $order)
							   				<tr>
							   					<td>{{ $order->id }}</td>
							   					<td>{{ $order->created_at }}</td>
							   					<td>{!! xss_clean(decimalPlace($order->total,$order->currency)) !!}</td>
							   					<td>{!! xss_clean($order->getStatus()) !!}</td>
							   					<td>{!! xss_clean($order->getPaymentStatus()) !!}</td>
							   					<td class="text-center">
							   						<a href="{{ url('/order_details/'.encrypt($order->id)) }}" class="btn-link">{{ _lang('View Details') }}</a>
							   						@if($order->status == $order::PENDING_PAYMENT)
							   							| <a href="{{ url('/payment/'.encrypt($order->id)) }}" class="btn-link">{{ _lang('Pay Now') }}</a>
							   						@endif
							   					</td>
							   				</tr>
							   			@endforeach
						   			</tbody>
						   		</table>
								{{ $orders->links() }}
						   </div>
						</div>
					</div>
				</div>
		   </div>
		</div>
	</div>
</section>
<!--/ End Login Screen -->
		

@endsection
