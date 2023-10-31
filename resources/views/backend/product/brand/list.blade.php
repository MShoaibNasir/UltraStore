@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Brand List') }}</span>
				<a class="btn btn-primary btn-xs ml-auto" href="{{ route('brands.create') }}">{{ _lang('Add New') }}</a>
			</div>
			<div class="card-body">
				<table id="brands_table" class="table table-bordered data-table">
					<thead>
					    <tr>
						    <th>{{ _lang('Logo') }}</th>
						    <th>{{ _lang('Name') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
					    @foreach($brands as $brand)
					    <tr data-id="row_{{ $brand->id }}">
							<td class='logo'>
								<div class="thumbnail-holder">
									<img src="{{ asset('storage/app/'. $brand->logo->file_path) }}">
								</div>
							</td>
							<td class='name'>{{ $brand->translation->name }}</td>
							
							<td class="text-center">
								<div class="dropdown">
								  <button class="btn btn-light dropdown-toggle btn-xs" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								  {{ _lang('Action') }}
								  <i class="fas fa-angle-down"></i>
								  </button>
								  <form action="{{ action('BrandController@destroy', $brand['id']) }}" method="post">
									{{ csrf_field() }}
									<input name="_method" type="hidden" value="DELETE">
									
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
										<a href="{{ action('BrandController@edit', $brand['id']) }}" class="dropdown-item dropdown-edit dropdown-edit"><i class="mdi mdi-pencil"></i> {{ _lang('Edit') }}</a>
										<a href="{{ action('BrandController@show', $brand['id']) }}" class="dropdown-item dropdown-view dropdown-view"><i class="mdi mdi-eye"></i> {{ _lang('View') }}</a>
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