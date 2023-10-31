@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="alert alert-info">
			<strong>{{ _lang('All amounts are showing in base currency').' ('.currency().')' }}</strong>
		</div>
			
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Customer Order Report') }}</span>
			</div>
			
			<div class="card-body">
			
				<div class="report-params">
					<form class="validate" method="post" action="{{ route('reports.order_report') }}">
						<div class="row">
              				{{ csrf_field() }}

							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">{{ _lang('Start Date') }}</label>						
									<input type="text" class="form-control datepicker" name="date1" id="date1" value="{{ isset($date1) ? $date1 : old('date1') }}" readOnly="true" required>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">{{ _lang('End Date') }}</label>						
									<input type="text" class="form-control datepicker" name="date2" id="date2" value="{{ isset($date2) ? $date2 : old('date2') }}" readOnly="true" required>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
								<label class="control-label">{{ _lang('Order Status') }}</label>						
									<select class="form-control auto-select" data-selected="{{ isset($order_status) ? $order_status : old('order_status') }}" name="order_status" id="order_status">
										<option value="">{{ _lang('All') }}</option>
										<option value="pending_payment">{{ _lang('Pending Payment') }}</option>
										<option value="pending">{{ _lang('Pending') }}</option>
										<option value="completed">{{ _lang('Completed') }}</option>
										<option value="on_hold">{{ _lang('On Hold') }}</option>
										<option value="processing">{{ _lang('Processing') }}</option>
										<option value="refunded">{{ _lang('Refunded') }}</option>	
										<option value="canceled">{{ _lang('Canceled') }}</option>										
									</select> 
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">{{ _lang('Customer Email') }}</label>						
									<input type="text" class="form-control" name="customer_email" id="customer_email" value="{{ isset($customer_email) ? $customer_email : old('customer_email') }}">
								</div>
							</div>
							
							<div class="col-md-2">
								<button type="submit" class="btn btn-light btn-xs mt-26"><i class="ti-filter"></i> {{ _lang('Filter') }}</button>
							</div>
						</form>

					</div>
				</div><!--End Report param-->
                
				@php $date_format = get_option('date_format','Y-m-d'); @endphp
				@php $currency = currency(); @endphp
				
				<div class="report-header">
				   <h4>{{ _lang('Customer Order Report') }}</h4>
				   <h5>{{ isset($date1) ? date($date_format, strtotime($date1)).' '._lang('to').' '.date($date_format, strtotime($date2)) : '----------  '._lang('to').'  ----------' }}</h5>
				</div>

				<table class="table table-bordered report-table">
					<thead>
						<th>{{ _lang('Name') }}</th>
						<th>{{ _lang('Email') }}</th>
						<th>{{ _lang('Type') }}</th>    
						<th>{{ _lang('Orders') }}</th>    
						<th>{{ _lang('Products') }}</th>    
						<th class="text-right">{{ _lang('Total Spend') }}</th>       
					</thead>
					<tbody> 
					@if(isset($report_data))
						@foreach($report_data as $report) 
							<tr>
								<td>{{ $report->customer_name }}</td>
								<td>{{ $report->customer_email }}</td>
								<td>{{ $report->customer_id != NULL ? _lang('Customer') : _lang('Guest') }}</td>
								<td>{{ $report->total_orders }}</td>
								<td>{{ $report->total_products }}</td>
								<td class="text-right">{!! xss_clean(decimalPlace($report->total, $currency)) !!}</td>
							</tr>
						@endforeach
					@endif
				    </tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection