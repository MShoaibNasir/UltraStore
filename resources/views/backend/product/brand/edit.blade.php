@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Update Brand') }}</span>
			</div>
			<div class="card-body">
				<form method="post" class="validate" autocomplete="off" action="{{ action('BrandController@update', $id) }}" enctype="multipart/form-data">
					{{ csrf_field()}}
					<input name="_method" type="hidden" value="PATCH">				
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
						        <label class="col-md-3 col-form-label">{{ _lang('Name') }}</label>	
						        <div class="col-md-9">					
							        <input type="text" class="form-control" name="name" value="{{ $brand->translation->name }}" required>
							    </div>
					        </div>

							<div class="form-group row">
						        <label class="col-md-3 col-form-label">{{ _lang('Logo') }}</label>	
						        <div class="col-md-9">					
							        <button type="button" class="choose-media btn btn-light" data-media-type="image" data-input-name="files[logo]">
							            <i class="fa fa-folder-open m-r-5"></i> {{ _lang('Browse') }}
							        </button>
							        <div class="image-container">
							        	@if(isset($brand->logo->pivot))
							        		<div class="image">
							        			<img src="{{ asset('storage/app/'. $brand->logo->file_path) }}">
							        			<input type="hidden" name="files[logo]" value="{{ $brand->logo->pivot->media_id }}">
							        		    <i class="remove-media fas fa-times"></i>
							        		</div>
							        	@endif
							        </div>
							    </div>
					        </div>

					        <div class="form-group row">
						        <label class="col-md-3 col-form-label">{{ _lang('Banner') }}</label>	
						        <div class="col-md-9">					
							        <button type="button" class="choose-media btn btn-light" data-media-type="image" data-input-name="files[banner]">
							            <i class="fa fa-folder-open m-r-5"></i> {{ _lang('Browse') }}
							        </button>
							        <div class="image-container">
							        	@if(isset($brand->banner->pivot))
							        	    <div class="image">
								        		<img src="{{ asset('storage/app/'. $brand->banner->file_path) }}">
								        		<input type="hidden" name="files[banner]" value="{{ $brand->banner->pivot->media_id }}">
								        		<i class="remove-media fas fa-times"></i>
								        	</div>
							        	@endif
							        </div>
							    </div>
					        </div>


							<div class="form-group row">	
								<div class="col-md-9 offset-md-3">
									<button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
								</div>
							</div>	
						</div>	
					</div>	
				</form>
			</div>
		</div>
	</div>
</div>

@endsection


