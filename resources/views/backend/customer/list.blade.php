@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card">
		    <div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Customer List') }}</span>
				<a class="btn btn-primary btn-xs ml-auto ajax-modal" data-title="{{ _lang('Create New Customer') }}" href="{{ route('customers.create') }}">{{ _lang('Create New Customer') }}</a>
			</div>
			<div class="card-body">
				<table id="users_table" class="table table-bordered data-table">
					<thead>
					    <tr>
							<th class="text-center">#</th>
						    <th>{{ _lang('Name') }}</th>
							<th>{{ _lang('Email') }}</th>
							<th>{{ _lang('Phone') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
					    @foreach($users as $user)
					    <tr data-id="row_{{ $user->id }}">
							<td class='profile_picture text-center'><img src="{{ profile_picture($user->profile_picture) }}" class="thumb-sm rounded-circle mr-2"></td>
							<td class='name'><a href="{{ action('CustomerController@show', $user['id']) }}">{{ $user->name }}</a></td>
							<td class='email'>{{ $user->email }}</td>
							<td class='phone'>{{ $user->phone }}</td>
							<td class='status'>{!! xss_clean(status($user->status)) !!}</td>
							<td class="text-center">
								<div class="dropdown">
								  <button class="btn btn-light dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  {{ _lang('Action') }}
								  <i class="fas fa-angle-down"></i>
								  </button>
								  <form action="{{ action('CustomerController@destroy', $user['id']) }}" method="post">
									{{ csrf_field() }}
									<input name="_method" type="hidden" value="DELETE">
									
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a href="{{ action('CustomerController@edit', $user['id']) }}" data-title="{{ _lang('Update Customer Details') }}" class="dropdown-item dropdown-edit ajax-modal"><i class="mdi mdi-pencil"></i> {{ _lang('Edit') }}</a>
										<a href="{{ action('CustomerController@show', $user['id']) }}" class="dropdown-item dropdown-view"><i class="mdi mdi-eye"></i> {{ _lang('View') }}</a>
										<button class="btn-remove dropdown-item" type="submit"><i class="mdi mdi-delete"></i> {{ _lang('Delete') }}</button>
									</div>
								  </form>
								</div>
							</td>
					    </tr>
					    @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection