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
						<li class="active"><a href="">{{ _lang('My Addresses') }}</a></li>
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
							<h4 class="d-flex align-items-center">
								<span>{{ _lang('My Addresses') }}</span>
								<a class="btn-add-address ml-auto" href="{{ url('/add_new_address') }}">
									<i class="ti-plus"></i> {{ _lang('New Address') }}
								</a>
							</h4>
						</div>

						<div class="card-body">
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
							
							<div class="table-responsive">
							   	<table id="customer_addresses_table" class="table table-bordered">
									<thead>
									    <tr>
											<th>{{ _lang('Name') }}</th>
											<th>{{ _lang('Address') }}</th>
											<th class="text-center">{{ _lang('Action') }}</th>
									    </tr>
									</thead>
									<tbody>
									    @foreach($addresses as $customeraddress)
										    <tr data-id="row_{{ $customeraddress->id }}">
												<td class='name'>{{ $customeraddress->name }}</td>
												<td class='address'>
													<strong><u>{{ ucwords($customeraddress->type).' '._lang('Address') }} {{ $customeraddress->is_default == 1 ? '('._lang('Default').')' : '' }}</u></strong><br>
													{{ _lang('Country').': '.$customeraddress->country }}<br>
													{{ _lang('State').': '.$customeraddress->state }}<br>
													{{ _lang('City').': '.$customeraddress->city }}<br>
													{{ _lang('Address').': '.$customeraddress->address }}<br>
													{{ _lang('Post Code').': '.$customeraddress->post_code }}<br>
												</td>
												<td class="text-center">
													<a href="{{ url('/update_address/'.$customeraddress->id) }}" class="text-info"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
													<a href="{{ url('/delete_address/'.$customeraddress->id) }}"  class="text-danger"><i class="fa fa-trash-o class="btn btn-primary"" aria-hidden="true"></i></a>	
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
