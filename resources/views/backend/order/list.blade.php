@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header">
				<span class="panel-title">{{ _lang('Order List') }}</span>
			</div>
			<div class="card-body">
				<table id="orders_table" class="table table-bordered">
					<thead>
					    <tr>
							<th>{{ _lang('ID') }}</th>
							<th>{{ _lang('Order Date') }}</th>
							<th>{{ _lang('Customer Name') }}</th>
							<th>{{ _lang('Email') }}</th>
							<th>{{ _lang('Total') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th>{{ _lang('Payment') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection


@section('js-script')
<script src="{{ asset('public/backend/assets/js/datatables/orders.js?v=1.1') }}"></script>
@endsection
