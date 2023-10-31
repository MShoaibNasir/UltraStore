@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-6">
		<div class="card">
		    <div class="card-header bg-primary text-white">
				<span class="panel-title">{{ _lang('View Currency') }}</span>
			</div>
			
			<div class="card-body">
				<table class="table table-bordered">
					<tr><td>{{ _lang('Name') }}</td><td>{{ $currency->name }}</td></tr>
					<tr><td>{{ _lang('Is Base Currency') }}</td><td>{{ $currency->base_currency == 1 ? _lang('Yes') : _lang('No') }}</td></tr>
					<tr><td>{{ _lang('Exchange Rate') }}</td><td>{{ $currency->exchange_rate }}</td></tr>
					<tr><td>{{ _lang('Status') }}</td><td>{{ $currency->status == 1 ? _lang('Active') : _lang('InActive')  }}</td></tr>
				</table>
			</div>
	    </div>
	</div>
</div>
@endsection


