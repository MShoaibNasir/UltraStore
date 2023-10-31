@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="alert alert-info">
			<strong>{{ _lang('All amounts are showing in base currency').' ('.currency().')' }}</strong>
		</div>
			
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Product Stock Report') }}</span>
			</div>
			
			<div class="card-body">
			
				<div class="report-params">
					<form class="validate" method="post" action="{{ route('reports.product_stock_report') }}">
						<div class="row">
              				{{ csrf_field() }}

							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">{{ _lang('Quantity Above') }}</label>						
									<input type="number" class="form-control" name="quantity_above" value="{{ isset($quantity_above) ? $quantity_above : old('quantity_above') }}">
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label class="control-label">{{ _lang('Quantity Below') }}</label>						
									<input type="number" class="form-control" name="quantity_below" value="{{ isset($quantity_below) ? $quantity_below : old('quantity_below') }}">
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
								<label class="control-label">{{ _lang('Stock Availability') }}</label>						
									<select class="form-control auto-select" data-selected="{{ isset($stock_availability) ? $stock_availability : old('stock_availability') }}" name="stock_availability">
										<option value="">{{ _lang('All') }}</option>
										<option value="in_stock">{{ _lang('In Stock') }}</option>
										<option value="out_of_stock">{{ _lang('Out of Stock') }}</option>									
									</select> 
								</div>
							</div>
							
							<div class="col-md-2">
								<button type="submit" class="btn btn-light btn-xs mt-26"><i class="ti-filter"></i> {{ _lang('Filter') }}</button>
							</div>
						</form>

					</div>
				</div><!--End Report param-->
                
				@php $date_format = get_option('date_format','Y-m-d'); @endphp
				
				<div class="report-header">
				   <h4>{{ _lang('Product Stock Report') }}</h4>
				   <h5>{{ isset($date1) ? date($date_format, strtotime($date1)).' '._lang('to').' '.date($date_format, strtotime($date2)) : '----------  '._lang('to').'  ----------' }}</h5>
				</div>

				<table class="table table-bordered report-table">
					<thead>     
						<th>{{ _lang('Product') }}</th>  
						<th class="text-center">{{ _lang('Quantity') }}</th>
						<th>{{ _lang('Stock Availability') }}</th>     
					</thead>
					<tbody> 
					@if(isset($report_data))
						@foreach($report_data as $report) 
							<tr>
								<td>{{ $report->translation->name }}</td>
								<td class="text-center">{{ $report->qty }}</td>
								<td>{{ $report->in_stock == 1 ? _lang('In Stock') : _lang('Out Of Stock') }}</td>
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