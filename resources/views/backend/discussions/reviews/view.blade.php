@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
		    <div class="card-header">
				<span class="panel-title">{{ _lang('View Product Review') }}</span>
			</div>
			
			<div class="card-body">
			    <table class="table table-bordered">
				    <tr><td>{{ _lang('User') }}</td><td>{{ $productreviews->user->name }}</td></tr>
					<tr><td>{{ _lang('Product') }}</td><td>{{ $productreviews->product->translation->name }}</td></tr>
					<tr><td>{{ _lang('Rating') }}</td><td>{{ $productreviews->rating }}</td></tr>
					<tr><td>{{ _lang('Comment') }}</td><td>{{ $productreviews->comment }}</td></tr>
					<tr>
						<td>{{ _lang('Status') }}</td>
						<td>
							@if($productreviews->is_approved == 1)
								<span class="badge badge-success">{{ _lang('Approved') }}</span> 
							@else
								<span class="badge badge-danger">{{ _lang('Pending') }}</span>
							@endif
						</td>
					</tr>
			    </table>
			</div>
	    </div>
	</div>
</div>
@endsection


