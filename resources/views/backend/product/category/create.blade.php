@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Add Category') }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="form-horizontal validate" autocomplete="off" action="{{ route('category.store') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-6">
							<div class="form-group row">
								<label class="col-md-3 col-form-label">{{ _lang('Name') }}</label>	
								<div class="col-md-9">					
							        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
						        </div>
						    </div>

							
						    <div class="form-group row">
						    	
							    <label class="col-md-3 col-form-label">{{ _lang('Parent Category') }}</label>						
							    <div class="col-md-9">   
							        <select class="form-control auto-select" data-selected="{{ old('parent_id') }}" name="parent_id">
						                <option value="">{{ _lang('Select Category') }}</option>
						                {{ buildOptionTree(\App\Entity\Category\Category::all(), 0, null, 0, -1, 1) }}
									</select>
								</div>
						    </div>


					        <div class="form-group row">
								<label class="col-md-3 col-form-label">{{ _lang('Description') }}</label>	
								<div class="col-md-9">					
							        <textarea class="form-control" name="description">{{ old('description') }}</textarea>
						        </div>
						    </div>

						    <div class="form-group row">
						        <label class="col-md-3 col-form-label">{{ _lang('Logo') }}</label>	
						        <div class="col-md-9">					
							        <button type="button" class="choose-media btn btn-light" data-media-type="image" data-input-name="files[logo]">
							            <i class="fa fa-folder-open m-r-5"></i> {{ _lang('Browse') }}
							        </button>
							        <div class="image-container">
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
							        </div>
							    </div>
					        </div>

								
							<div class="form-group row">
								<div class="col-md-9 offset-md-3">
									<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
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


