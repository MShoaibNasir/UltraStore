@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
		    <div class="card-header bg-primary text-white">
				<span class="panel-title">{{ _lang('View Media') }}</span>
			</div>
			
			<div class="card-body">
			    <table class="table table-bordered">
				    <tr><td>{{ _lang('Filename') }}</td><td>{{ $media->filename }}</td></tr>
					<tr><td>{{ _lang('File Path') }}</td><td>{{ asset('storage/app/' . $media->file_path) }}</td></tr>
					<tr><td>{{ _lang('File Type') }}</td><td>{{ $media->file_type }}</td></tr>
					<tr><td>{{ _lang('File Size') }}</td><td>{{ round($media->file_size / 1024) }} KB</td></tr>
					<tr><td>{{ _lang('File Extension') }}</td><td>{{ $media->file_extension }}</td></tr>
					<tr><td>{{ _lang('Uploaded By') }}</td><td>{{ $media->user->name }}</td></tr>
			    </table>
			</div>
	    </div>
	</div>
</div>
@endsection


