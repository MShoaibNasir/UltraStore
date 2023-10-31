@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-12">
	    	
		<div class="card">
			<div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Languages') }}</span>
				<a class="btn btn-primary btn-xs ml-auto" href="{{ route('languages.create') }}">{{ _lang('Add New') }}</a>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
						  	<tr>
								<th>{{ _lang('Language Name') }}</th>
								<th>{{ _lang('Edit Translation') }}</th>
								<th>{{ _lang('Remove') }}</th>
						  	</tr>
						</thead>
						<tbody>
						  
							@foreach(get_language_list() as $language)
							  <tr>
								<td>{{ $language }}</td>
								<td>
									<a href="{{ action('LanguageController@edit', $language) }}" class="btn btn-secondary btn-xs">{{ _lang('Edit Translation') }}</a>
								</td>	
								<td>
									<form action="{{ action('LanguageController@destroy', $language) }}" method="post">
									   {{ csrf_field() }}
									   <input name="_method" type="hidden" value="DELETE">
									   <button class="btn btn-danger btn-xs btn-remove" type="submit">{{ _lang('Delete') }}</button>
									</form>
								</td>
							  </tr>
						  	@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection


