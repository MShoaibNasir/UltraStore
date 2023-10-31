@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
		    <div class="card-header">
				<span class="panel-title">{{ _lang('View Category') }}</span>
			</div>
			
			<div class="card-body">
			    <table class="table table-bordered">
				    <tr><td>{{ _lang('Name') }}</td><td>{{ $category->translation->name }}</td></tr>
					<tr><td>{{ _lang('Description') }}</td><td>{{ $category->translation->description }}</td></tr>
			    </table>
			</div>
	    </div>
	</div>
</div>
@endsection


