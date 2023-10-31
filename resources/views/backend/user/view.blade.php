@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
		    <div class="card-header">
				<span class="panel-title">{{ _lang('View User') }}</span>
			</div>
			
			<div class="card-body">
			    <table class="table table-bordered">
				    <tr><td>{{ _lang('Name') }}</td><td>{{ $user->name }}</td></tr>
					<tr><td>{{ _lang('Email') }}</td><td>{{ $user->email }}</td></tr>
					<tr><td>{{ _lang('User Type') }}</td><td>{{ $user->user_type }}</td></tr>
					<tr><td>{{ _lang('User Role') }}</td><td>{{ $user->role->name }}</td></tr>
					<tr><td>{{ _lang('Status') }}</td><td>{!! xss_clean(status($user->status)) !!}</td></tr>
			    </table>
			</div>
	    </div>
	</div>
</div>
@endsection


