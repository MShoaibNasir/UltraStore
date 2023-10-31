@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-6">
		<div class="card">
			<div class="card-header">
				<span class="panel-title">{{ _lang('Add New Tag') }}</span>
			</div>
			<div class="card-body">
			    <form method="post" class="validate" autocomplete="off" action="{{ route('tags.store') }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-md-12">
						        <div class="form-group">
							        <label class="control-label">{{ _lang('Name') }}</label>						
							        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
						        </div>
						    </div>

							
						<div class="col-md-12">
							<div class="form-group">
								<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
							</div>
						</div>
					</div>			
			    </form>
			</div>
		</div>
    </div>
</div>
@endsection


