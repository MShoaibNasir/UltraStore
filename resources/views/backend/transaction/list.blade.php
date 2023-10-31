@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header">
				<span class="panel-title">{{ _lang('All Transaction') }}</span>
			</div>
			<div class="card-body">
				<table id="transactions_table" class="table table-bordered">
					<thead>
					    <tr>
						    <th>{{ _lang('Order ID') }}</th>
							<th>{{ _lang('Transaction ID') }}</th>
							<th>{{ _lang('Payment Method') }}</th>
							<th>{{ _lang('Currency') }}</th>
							<th>{{ _lang('Amount') }}</th>
							<th>{{ _lang('Paid At') }}</th>
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
<script src="{{ asset('public/backend/assets/js/datatables/transactions.js') }}"></script>
@endsection