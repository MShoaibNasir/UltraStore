@extends('layouts.app')

@section('content')

<div class="row">
	<div class="col-lg-12">
		<div class="card no-export">

		    <div class="card-header d-flex align-items-center">
				<span class="panel-title">{{ _lang('Media List') }}</span>
				<button class="btn btn-primary btn-xs ml-auto ajax-modal" data-title="{{ _lang('Upload Media') }}" data-href="{{ route('media.create') }}">{{ _lang('Upload New') }}</button>			
			</div>

			<div class="card-body">
				<table id="media_table" data-type="" class="table table-bordered">
					<thead>
					    <tr>
						    <th>{{ _lang('File') }}</th>
						    <th>{{ _lang('Filename') }}</th>
							<th>{{ _lang('File Type') }}</th>
							<th>{{ _lang('File Size') }}</th>
							<th class="text-center">{{ _lang('Action') }}</th>
					    </tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection

@section('js-script')
<script src="{{ asset('public/backend/assets/js/media.js') }}"></script>
@endsection