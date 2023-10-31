@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-12">

		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Product Views Report') }}</span>
			</div>
			
			<div class="card-body">
			
				<div class="report-params">
					<form class="validate" method="post" action="{{ route('reports.product_views_report') }}">
						<div class="row">
              				{{ csrf_field() }}
							
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">{{ _lang('Product Name') }}</label>						
									<input type="text" class="form-control" name="product_name" value="{{ isset($product_name) ? $product_name : old('product_name') }}">
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label class="control-label">{{ _lang('SKU') }}</label>						
									<input type="text" class="form-control" name="sku" value="{{ isset($sku) ? $sku : old('sku') }}">
								</div>
							</div>
							
							<div class="col-md-2">
								<button type="submit" class="btn btn-light btn-xs mt-26"><i class="ti-filter"></i> {{ _lang('Filter') }}</button>
							</div>
						</form>

					</div>
				</div><!--End Report param-->
                

				<div class="report-header">
				   <h4>{{ _lang('Product Views Report') }}</h4>
				</div>

				<table class="table table-bordered report-table">
					<thead>  
						<th>{{ _lang('Product') }}</th>    
						<th>{{ _lang('Views') }}</th>       
					</thead>
					<tbody> 
					@if(isset($report_data))
						@foreach($report_data as $report) 
							<tr>
								<td>{{ $report->translation->name }}</td>
								<td>{{ $report->viewed }}</td>
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