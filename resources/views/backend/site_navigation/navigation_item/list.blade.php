@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Navigation Items') }}</span>
				<a class="btn btn-primary btn-xs ml-auto" href="{{ route('navigation_items.create') }}">{{ _lang('Add New') }}</a>
			</div>
			<div class="card-body">
				<table id="navigation_items_table" class="table table-bordered data-table">
					<thead>
					    <tr>
						    <th>{{ _lang('Navigation') }}</th>
							<th>{{ _lang('Type') }}</th>
							<th>{{ _lang('Page') }}</th>
							<th>{{ _lang('Category') }}</th>
							<th>{{ _lang('URL') }}</th>
							<th>{{ _lang('Icon') }}</th>
							<th>{{ _lang('Target') }}</th>
							<th>{{ _lang('Parent Navigation') }}</th>
							<th>{{ _lang('Position') }}</th>
							<th>{{ _lang('Status') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
					    @foreach($navigationitems as $navigationitem)
					    <tr data-id="row_{{ $navigationitem->id }}">
							<td class='navigation_id'>{{ $navigationitem->navigation_id }}</td>
							<td class='type'>{{ $navigationitem->type }}</td>
							<td class='page_id'>{{ $navigationitem->page_id }}</td>
							<td class='category_id'>{{ $navigationitem->category_id }}</td>
							<td class='url'>{{ $navigationitem->url }}</td>
							<td class='icon'>{{ $navigationitem->icon }}</td>
							<td class='target'>{{ $navigationitem->target }}</td>
							<td class='parent_id'>{{ $navigationitem->parent_id }}</td>
							<td class='position'>{{ $navigationitem->position }}</td>
							<td class='status'>{{ $navigationitem->status }}</td>
							
							<td class="text-center">
								<div class="dropdown">
								  <button class="btn btn-light dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  {{ _lang('Action') }}
								  <i class="fas fa-angle-down"></i>
								  </button>
								  <form action="{{ action('NavigationItemController@destroy', $navigationitem['id']) }}" method="post">
									{{ csrf_field() }}
									<input name="_method" type="hidden" value="DELETE">
									
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a href="{{ action('NavigationItemController@edit', $navigationitem['id']) }}" class="dropdown-item dropdown-edit dropdown-edit"><i class="mdi mdi-pencil"></i> {{ _lang('Edit') }}</a>
										<a href="{{ action('NavigationItemController@show', $navigationitem['id']) }}" class="dropdown-item dropdown-view dropdown-view"><i class="mdi mdi-eye"></i> {{ _lang('View') }}</a>
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