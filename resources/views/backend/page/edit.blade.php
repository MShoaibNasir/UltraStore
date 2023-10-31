@extends('layouts.app')

@section('content')
<span class="panel-title d-none">{{ _lang('Update Page') }}</span>

<form method="post" class="validate" autocomplete="off" action="{{ action('PageController@update', $id) }}" enctype="multipart/form-data">
	<div class="row">
		<div class="col-lg-8">
			<div class="card">
				<div class="card-header">
					<span class="panel-title">{{ _lang('Page Details') }}</span>
				</div>
				<div class="card-body">

					{{ csrf_field()}}

					<input name="_method" type="hidden" value="PATCH">	

					<div class="row">
						<div class="col-md-12">
					        <div class="form-group">
						        <label class="control-label">{{ _lang('Title') }}</label>						
						        <input type="text" class="form-control" name="title" value="{{ $page->translation->title }}" required>
					        </div>
					    </div>

					    <div class="col-md-12">
					        <div class="form-group">
						        <label class="control-label">{{ _lang('Body') }}</label>						
						        <textarea class="form-control summernote" name="body">{{ $page->translation->body }}</textarea>
					        </div>
					    </div>
							
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
							</div>
						</div>
					</div>			
				</div>
			</div>
	    </div>

	    <div class="col-md-4">
			<div class="card">
				<div class="card-header">
					<span class="panel-title">{{ _lang('Page Settings') }}</span>
				</div>
				<div class="card-body">
    				<div class="col-md-12">
				        <div class="form-group">
					        <label class="control-label">{{ _lang('Status') }}</label>						
					        <select class="form-control auto-select" data-selected="{{ $page->status }}" name="status" required>
								<option value="1">{{ _lang('Publish') }}</option>
								<option value="0">{{ _lang('Draft') }}</option>
							</select>
						</div>
				    </div>

				    <div class="col-md-12">
				        <div class="form-group">
					        <label class="control-label">{{ _lang('Page Template') }}</label>						
					        <select class="form-control auto-select" data-selected="{{ $page->template }}" name="template">
								<option value="">{{ _lang('Select Template') }}</option>
								{{ load_custom_template() }}
							</select>
						</div>
				    </div>

					<div class="col-md-12">
				        <div class="form-group">
					        <label class="control-label">{{ _lang('Meta Title') }}</label>
					        <input type="text" class="form-control" name="meta[meta_title]" value="{{ $page->meta->translation->meta_title }}">
				        </div>
				    </div>

				    <div class="col-md-12">
				        <div class="form-group">
					        <label class="control-label">{{ _lang('Meta Leywords') }}</label>
					        <input type="text" class="form-control" name="meta[meta_keywords]" value="{{ $page->meta->translation->meta_keywords }}">
				        </div>
				    </div>

				    <div class="col-md-12">
				        <div class="form-group">
					        <label class="control-label">{{ _lang('Meta Description') }}</label>
					        <textarea name="meta[meta_description]" class="form-control">{{ $page->meta->translation->meta_description }}</textarea>
				        </div>
				    </div>

				    <div class="col-md-12">
				        <button type="button" class="choose-media btn btn-light" data-media-type="image" data-input-name="files[page_image]">
				            <i class="fa fa-folder-open m-r-5"></i> {{ _lang('Browse Image') }}
				        </button>
				        <div class="image-container w-100">
				        	@if(isset($page->image->pivot))
				        	    <div class="image">
					        		<img src="{{ asset('storage/app/'. $page->image->file_path) }}">
					        		<input type="hidden" name="files[page_image]" value="{{ $page->image->pivot->media_id }}">
					        		<i class="remove-media fas fa-times"></i>
					        	</div>
				        	@endif
				        </div>
				    </div>

				</div>
			</div>
	    </div>

	</div>
</form>
@endsection


