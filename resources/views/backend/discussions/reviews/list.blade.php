@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <form id="bulk_action_form" action="{{ route('product_reviews.bulk_action') }}" method="post">
			    @csrf
			    <div class="card-header d-flex align-items-center">
					<span class="panel-title">{{ _lang('All Reviews') }}</span>
					<select class="bulk-action ml-auto" name="bulk_action" id="bulk_action">
						<option value="">{{ _lang('Bulk Action') }}</option>
						<option value="approved">{{ _lang('Approved') }}</option>
						<option value="pending">{{ _lang('Pending') }}</option>
						<option value="delete">{{ _lang('Delete') }}</option>
					</select>
				</div>
				<div class="card-body">	
					<table id="product_reviews_table" class="table table-bordered">
						<thead>
						    <tr>
							    <th>{{ _lang('#') }}</th>
							    <th>{{ _lang('User') }}</th>
								<th>{{ _lang('Product') }}</th>
								<th class="text-center">{{ _lang('Rating') }}</th>
								<th>{{ _lang('Comment') }}</th>
								<th class="text-center">{{ _lang('Status') }}</th>
								<th class="text-center">{{ _lang('Action') }}</th>
						    </tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection

@section('js-script')
<script src="{{ asset('public/backend/assets/js/datatables/reviews.js') }}"></script>
@endsection