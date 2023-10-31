@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header">
				<span class="panel-title">{{ _lang('All Comment') }}</span>
			</div>
			<div class="card-body">
				<table id="product_comments_table" class="table table-bordered">
					<thead>
					    <tr>
						    <th>{{ _lang('User') }}</th>
							<th>{{ _lang('Product') }}</th>
							<th>{{ _lang('Comment') }}</th>
							<th class="text-center">{{ _lang('Replies') }}</th>
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
<script src="{{ asset('public/backend/assets/js/datatables/comments.js') }}"></script>
@endsection