@extends('layouts.app')

@section('content')
@php $permissions = permission_list(); @endphp
@php $user_type = Auth::user()->user_type; @endphp

<link rel="stylesheet" href="{{ asset('public/backend/plugins/chartjs/Chart.min.css') }}">

<div class="row">
	@if (in_array('dashboard.total_sales_widget',$permissions) || $user_type == 'admin')
	<div class="col-md-3 mb-3">
		<div class="card">
			<div class="seo-fact sbg1">
				<div class="p-4">
					<div class="seofct-icon">
						<span>{{ _lang('Total Sales') }}</span>
					</div>
					<h2>{!! xss_clean(decimalPlace($total_sales, currency())) !!}</h2>
				</div>
			</div>
		</div>
	</div>
	@endif
	
	@if (in_array('dashboard.current_day_sales_widget',$permissions) || $user_type == 'admin')
	<div class="col-md-3 mb-3">
		<div class="card">
			<div class="seo-fact sbg2">
				<div class="p-4">
					<div class="seofct-icon">
						<span>{{ _lang('Current Day Sales') }}</span>
					</div>
					<h2>{!! xss_clean(decimalPlace($current_day_sales, currency())) !!}</h2>
				</div>
			</div>
		</div>
	</div>
	@endif


	@if (in_array('dashboard.pending_order_widget',$permissions) || $user_type == 'admin')
	<div class="col-md-3 mb-3">
		<div class="card">
			<div class="seo-fact sbg4">
				<div class="p-4">
					<div class="seofct-icon">
						<span>{{ _lang('Pending Orders') }}</span>
					</div>
					<h2>{{ $pending_orders }}</h2>
				</div>
			</div>
		</div>
	</div>
	@endif
	
	@if (in_array('dashboard.total_product_widget',$permissions) || $user_type == 'admin')
	<div class="col-md-3 mb-3">
		<div class="card">
			<div class="seo-fact sbg2">
				<div class="p-4">
					<div class="seofct-icon">
						<span>{{ _lang('Total Products') }}</span>
					</div>
					<h2>{{ $total_products }}</h2>
				</div>
			</div>
		</div>
	</div>
	@endif

</div>

<div class="row d-flex align-items-stretch">
	@if (in_array('dashboard.weekly_sales_widget',$permissions) || $user_type == 'admin')
	<!-- Weekly Sales start -->
	<div class="col-lg-7 mt-2">
		<div class="card h-100">
			<div class="card-body pb-0">
				<h4 class="header-title">{{ _lang('Weekly Sales') }}</h4>
				<canvas id="weekly_sales"></canvas>
			</div>
		</div>
	</div>
	<!-- Weekly Sales end -->
	@endif


	@if (in_array('dashboard.top_view_items_widget',$permissions) || $user_type == 'admin')
	<!-- Top Viewed Products start -->
	<div class="col-lg-5 mt-2">
		<div class="card h-100">
			<div class="card-body">
				<h4 class="header-title">{{ _lang('Top Viewed Products') }}</h4>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<th>{{ _lang('Product') }}</th>
							<th class="text-center">{{ _lang('Views') }}</th>
						</thead>
						<tbody>
							@foreach($top_view_products as $top_view_product)
								<tr>
									<td>{{ $top_view_product->translation->name }}</td>
									<td class="text-center">{{ $top_view_product->viewed }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Top Viewed Products end -->
	@endif
</div>

@if (in_array('dashboard.recent_order_widget',$permissions) || $user_type == 'admin')
<div class="row">
	<!-- Recent Orders start -->
	<div class="col-lg-12 mt-5">
		<div class="card">
			<div class="card-body">
				<h4 class="header-title">{{ _lang('Recent Orders') }}</h4>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<th>{{ _lang('Customer Name') }}</th>
							<th>{{ _lang('Email') }}</th>
							<th>{{ _lang('Total') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th>{{ _lang('Payment') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
						</thead>
						<tbody>
							@foreach($recent_orders as $recent_order)
								<tr>
									<td>{{ $recent_order->customer_name }}</td>
									<td>{{ $recent_order->customer_email }}</td>
									<td>{!! xss_clean(decimalPlace(convert_currency_2(1, $recent_order->currency_rate, $recent_order->total), $recent_order->currency)) !!}</td>
									<td>{!! xss_clean($recent_order->getStatus()) !!}</td>
									<td>{!! xss_clean($recent_order->getPaymentStatus()) !!}</td>
									<td class="text-center">
										<div class="dropdown">
											<button class="btn btn-light btn-xs dropdown-toggle" type="button" data-toggle="dropdown">{{ _lang('Action') }} <i class="fas fa-angle-down"></i></button>
											<div class="dropdown-menu">
												<a class="dropdown-item" href="{{ action('OrderController@show', $recent_order->id) }}"><i class="fas fa-eye"></i> {{ _lang('View') }}</a>
												<form action="{{ action('OrderController@destroy', $recent_order['id']) }}" method="post">
													@csrf
													<input name="_method" type="hidden" value="DELETE">
													<button class="button-link btn-remove" type="submit"><i class="fas fa-trash"></i> {{ _lang('Delete') }}</button>'
												</form>	
											</div>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Recent Orders end -->
</div>
@endif

@endsection

@section('js-script')
<script src="{{ asset('public/backend/plugins/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('public/backend/assets/js/dashboard.js') }}"></script>
@endsection
        