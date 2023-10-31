@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-6">
		<div class="card">
		    <div class="card-header">
				<span class="panel-title">{{ _lang('View Tag') }}</span>
			</div>
			
			<div class="card-body">
			    <table class="table table-bordered">
				    <tr><td>{{ _lang('Name') }}</td><td>{{ $tag->translation->name }}</td></tr>
			    </table>
			</div>
	    </div>
	</div>
</div>
@endsection


