<form method="post" class="ajax-screen-submit" autocomplete="off" action="{{ action('ReviewsController@update', $id) }}" enctype="multipart/form-data">
	{{ csrf_field()}}
	<input name="_method" type="hidden" value="PATCH">				
	
	<div class="col-md-12">
		<div class="form-group">
		   <label class="control-label">{{ _lang('User') }}</label>						
		   <input type="text" class="form-control" name="user_id" value="{{ $productreviews->user->name }}" readonly>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
		   <label class="control-label">{{ _lang('Product') }}</label>						
		   <input type="text" class="form-control" name="product_id" value="{{ $productreviews->product->translation->name }}" readonly>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
		   <label class="control-label">{{ _lang('Rating') }}</label>						
		   <select class="form-control auto-select" data-selected="{{ $productreviews->rating }}" name="rating">
		   	   <option value="1">1</option>
		   	   <option value="2">2</option>
		   	   <option value="3">3</option>
		   	   <option value="4">4</option>
		   	   <option value="5">5</option>
		   </select>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
		   <label class="control-label">{{ _lang('Comment') }}</label>						
		   <textarea class="form-control" name="comment">{{ $productreviews->comment }}</textarea>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
		   <label class="control-label">{{ _lang('Status') }}</label>						
		   <select class="form-control auto-select" name="is_approved" data-selected="{{ $productreviews->is_approved }}">
		   		<option value="0">{{ _lang('Pending') }}</option>
		   		<option value="1">{{ _lang('Approved') }}</option>
		   </select>
		</div>
	</div>

	
	<div class="form-group">
	    <div class="col-md-12">
		    <button type="submit" class="btn btn-primary">{{ _lang('Update') }}</button>
	    </div>
	</div>
</form>

