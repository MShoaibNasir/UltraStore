@extends('layouts.app')

@section('content')
<span class="panel-title d-none">{{ _lang('Create Page') }}</span>
<form method="post" class="validate" autocomplete="off" action="{{ route('pages.store') }}" enctype="multipart/form-data">
	
	<div class="row">
		<div class="col-lg-8">
			<div class="card">
				<div class="card-header">
					<span class="panel-title">{{ _lang('Page Details') }}</span>
				</div>
				<div class="card-body">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-12">
					        <div class="form-group">
						        <label class="control-label">{{ _lang('Title') }}</label>						
						        <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
					        </div>
					    </div>

					    <div class="col-md-12">
					        <div class="form-group">
						        <label class="control-label">{{ _lang('Body') }}</label>						
						        <textarea class="form-control summernote" name="body">{{ old('body') }}</textarea>
					        </div>
					    </div>
							
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
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
					        <select class="form-control auto-select" data-selected="{{ old('status','1') }}" name="status" required>
								<option value="1">{{ _lang('Publish') }}</option>
								<option value="0">{{ _lang('Draft') }}</option>
							</select>
						</div>
				    </div>

				    <div class="col-md-12">
				        <div class="form-group">
					        <label class="control-label">{{ _lang('Page Template') }}</label>						
					        <select class="form-control auto-select" data-selected="{{ old('template','') }}" name="template">
								<option value="">{{ _lang('Select Template') }}</option>
								{{ load_custom_template() }}
							</select>
						</div>
				    </div>

					<div class="col-md-12">
				        <div class="form-group">
					        <label class="control-label">{{ _lang('Meta Title') }}</label>
					        <input type="text" class="form-control" name="meta[meta_title]" value="{{ old('meta[meta_title]') }}">
				        </div>
				    </div>

				    <div class="col-md-12">
				        <div class="form-group">
					        <label class="control-label">{{ _lang('Meta Leywords') }}</label>
					        <input type="text" class="form-control" name="meta[meta_keywords]" value="{{ old('meta[meta_keywords]') }}">
				        </div>
				    </div>

				    <div class="col-md-12">
				        <div class="form-group">
					        <label class="control-label">{{ _lang('Meta Description') }}</label>
					        <textarea name="meta[meta_description]" class="form-control">{{ old('meta[meta_description]') }}</textarea>
				        </div>
				    </div>

				    <div class="col-md-12">
				        <button type="button" class="choose-media btn btn-light" data-media-type="image" data-input-name="files[page_image]">
				            <i class="fa fa-folder-open m-r-5"></i> {{ _lang('Browse Image') }}
				        </button>
				        <div class="image-container w-100"></div>
				    </div>

				</div>
			</div>
	    </div>

	</div>
</form>
@endsection


