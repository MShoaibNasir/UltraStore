@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('View Email Template') }}</span>
			</div>
			<div class="card-body">
			  	<table class="table table-bordered">
					<tr><td>{{ $emailtemplate->subject }}</td></tr>
					<tr><td>{!! xss_clean($emailtemplate->body) !!}</td></tr>		
			  	</table>
			</div>
	  	</div>
 	</div>
</div>
@endsection


