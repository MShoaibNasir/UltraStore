@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">
		    <div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Category List') }}</span>
				<a class="btn btn-primary btn-xs ml-auto" href="{{ route('category.create') }}">{{ _lang('Add New') }}</a>
			</div>
			<div class="card-body">
                <div class="tree_view">
					@if( count($categories) > 0 )
						{{ buildTree($categories, 0, 'category') }}
					@else
						<h5 class="not-found-ctegory">{{ _lang('No Category Found !') }}</h5>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection