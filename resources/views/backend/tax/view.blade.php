@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
		    <div class="card-header">
				<span class="panel-title">{{ _lang('View Tax') }}</span>
			</div>
			
			<div class="card-body">
			    <table class="table table-bordered">
				    <tr><td>{{ _lang('Tax Class Name') }}</td><td>{{ $tax->translation->name }}</td></tr>
				    <tr><td>{{ _lang('Based On') }}</td><td>{{ $tax->get_based_on() }}</td></tr>
			    </table>
			    
                <div class="table-responsive">
                    <table class="table table-bordered" id="tax-rates-table">
                     	<thead>
			                <tr>
			                    <th>{{ _lang('Tax Name') }}</th>
			                    <th>{{ _lang('Country') }}</th>
			                    <th>{{ _lang('State') }}</th>
			                    <th>{{ _lang('Rate') }} %</th>
			                </tr>
			            </thead>
			            <tbody>
			            	@foreach($tax->tax_rates as $tax_rate)
    						<tr>
			                    <td>{{ $tax_rate->translation->name }}</td>
			                    <td>{{ $tax_rate->country }}</td>
			                    <td>{{ $tax_rate->state }}</td>
			                    <td>{{ $tax_rate->rate }}</td>
			                </tr>
			                @endforeach
			            </tbody>
                     </table>
                 </div>

			</div>
	    </div>
	</div>
</div>
@endsection


