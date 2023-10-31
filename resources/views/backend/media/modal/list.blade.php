
<div class="card">
    <div class="card-header">
		<span class="panel-title">{{ _lang('Media List') }}</span>
		<button class="btn btn-primary btn-xs float-right ajax-modal-2" data-title="{{ _lang('Upload Media') }}" data-href="{{ route('media.create') }}">{{ _lang('Upload New') }}</button>
	</div>
	<div class="card-body">
		<table id="media_table" data-type="ajax" data-multiple="{{ isset($_GET['multiple']) ? 'true' : 'false' }}" class="table table-bordered">
			<thead>
			    <tr>
				    <th>{{ _lang('File') }}</th>
				    <th>{{ _lang('Filename') }}</th>
					<th>{{ _lang('File Type') }}</th>
					<th>{{ _lang('File Size') }}</th>
					<th class="text-center">{{ _lang('Select') }}</th>
			    </tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>

<script src="{{ asset('public/backend/assets/js/media.js') }}"></script>
