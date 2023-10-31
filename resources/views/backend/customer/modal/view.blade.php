<table class="table table-bordered">
	<tr><td>{{ _lang('Name') }}</td><td>{{ $user->name }}</td></tr>
	<tr><td>{{ _lang('Email') }}</td><td>{{ $user->email }}</td></tr>
	<tr><td>{{ _lang('Phone') }}</td><td>{{ $user->phone }}</td></tr>
	<tr><td>{{ _lang('Status') }}</td><td>{!! xss_clean(status($user->status)) !!}</td></tr>
	<tr><td>{{ _lang('Created At') }}</td><td>{{ $user->created_at }}</td></tr>
</table>

