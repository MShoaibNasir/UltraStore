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
						<li class="active"><a href="">{{ _lang('My Downloads') }}</a></li>
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
				<div class="dashboard_content">
					<div class="card">
						<div class="card-header">
						   <h4>{{ _lang('My Downloads') }}</h4>
						</div>
						<div class="card-body">
						   	<div class="table-responsive">
						   		<table class="table table-bordered">
						   			<thead>
						   				<th>{{ _lang('Order ID') }}</th>
						   				<th>{{ _lang('Date') }}</th>
						   				<th>{{ _lang('Product') }}</th>
						   				<th class="text-center">{{ _lang('Action') }}</th>
						   			</thead>
						   			<tbody>	
						   				@if($downloads->count() == 0)
											<tr>
							   					<td colspan="4" class="text-center">{{ _lang('No downloadable product found !') }}</td>
							   				</tr>
						   				@endif
						   				
						   				@foreach($downloads as $order_product)		
							   				<tr>
							   					<td>{{ $order_product->order->id }}</td>
							   					<td>{{ $order_product->order->created_at }}</td>
							   					<td>{{ $order_product->product->translation->name }}</td>
							   					<td class="text-center">
							   						<a href="{{ url('download_product/'.encrypt($order_product->id)) }}" class="btn-link">{{ _lang('Download') }}</a>
							   					</td>
							   				</tr>	
						   				@endforeach
						   			</tbody>
						   		</table>
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
