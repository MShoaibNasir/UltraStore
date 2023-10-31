@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Update Category') }}</span>
			</div>
			<div class="card-body">
				<form action="{{ action('CategoryController@destroy', $category['id']) }}" method="post">
					{{ csrf_field() }}
					<input name="_method" type="hidden" value="DELETE">
															
					<button class="btn btn-danger float-right btn-remove" type="submit"><i class="far fa-trash-alt"></i> {{ _lang('Delete') }}</button>		
			  	</form>
								  	
				<form method="post" class="form-horizontal validate" autocomplete="off" action="{{ action('CategoryController@update', $id) }}" enctype="multipart/form-data">
					{{ csrf_field()}}
					<input name="_method" type="hidden" value="PATCH">				
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-md-3 col-form-label">{{ _lang('Name') }}</label>	
								<div class="col-md-9">					
							        <input type="text" class="form-control" name="name" value="{{ $category->translation->name }}" required>
						        </div>
						    </div>

							<div class="form-group row">
								<label class="col-md-3 col-form-label">{{ _lang('Parent Category') }}</label>
							    <div class="col-md-9">  						
								    <select class="form-control auto-select" data-selected="{{ $category->parent_id }}" name="parent_id">
						                <option value="">{{ _lang('Select Category') }}</option>
										{{ buildOptionTree(\App\Entity\Category\Category::all(), 0, $category->id, 0, -1, 1) }}
								    </select>
							    </div>
							</div>

							<div class="form-group row">
								<label class="col-md-3 col-form-label">{{ _lang('Description') }}</label>	
								<div class="col-md-9">					
							        <textarea class="form-control" name="description">{{ $category->translation->description }}</textarea>
						        </div>
						    </div>

						    <div class="form-group row">
						        <label class="col-md-3 col-form-label">{{ _lang('Logo') }}</label>	
						        <div class="col-md-9">					
							        <button type="button" class="choose-media btn btn-light" data-media-type="image" data-input-name="files[logo]">
							            <i class="fa fa-folder-open m-r-5"></i> {{ _lang('Browse') }}
							        </button>
							        <div class="image-container">
							        	@if(isset($category->logo->pivot))
							        		<div class="image">
							        			<img src="{{ asset('storage/app/'. $category->logo->file_path) }}">
							        			<input type="hidden" name="files[logo]" value="{{ $category->logo->pivot->media_id }}">
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
							        	@if(isset($category->banner->pivot))
							        	    <div class="image">
								        		<img src="{{ asset('storage/app/'. $category->banner->file_path) }}">
								        		<input type="hidden" name="files[banner]" value="{{ $category->banner->pivot->media_id }}">
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


