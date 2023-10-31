@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
		    <div class="card-header">
				<span class="panel-title">{{ _lang('View Comment') }}</span>
			</div>
			
			<div class="card-body">
			    <table class="table table-bordered">
				    <tr><td>{{ _lang('User') }}</td><td>{{ $productcomment->user->name }}</td></tr>
					<tr><td>{{ _lang('Product') }}</td><td>{{ $productcomment->product->translation->name }}</td></tr>
			    </table>

			    <div class="tree_view">
			    	{!! show_admin_comment($productcomment) !!}
				</div>
			</div>
	    </div>
	</div>
</div>
@endsection


