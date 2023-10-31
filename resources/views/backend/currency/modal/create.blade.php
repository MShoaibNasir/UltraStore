<form method="post" class="ajax-screen-submit" autocomplete="off" action="{{ route('currency.store') }}" enctype="multipart/form-data">
	{{ csrf_field() }}
	
    <div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Name') }}</label>						
			<select class="form-control auto-select select2" data-selected="{{ old('name') }}" name="name"  required>
				<option value="">{{ _lang('Select One') }}</option>
				{{ get_currency_list() }}
			</select>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Base Currency') }}</label>						
			<select class="form-control auto-select" data-selected="{{ old('base_currency',0) }}" name="base_currency" >
				<option value="0">{{ _lang('No') }}</option>
				<option value="1">{{ _lang('Yes') }}</option>
			</select>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Exchange Rate') }}</label>						
			<input type="text" class="form-control" name="exchange_rate" value="{{ old('exchange_rate') }}" required>
		</div>
	</div>

	<div class="col-md-12">
		<div class="form-group">
			<label class="control-label">{{ _lang('Status') }}</label>						
			<select class="form-control auto-select" data-selected="{{ old('status',1) }}" name="status"  required>
				<option value="1">{{ _lang('Active') }}</option>
				<option value="0">{{ _lang('InActive') }}</option>
			</select>
		</div>
	</div>

	
	<div class="col-md-12">
	    <div class="form-group">
		    <button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
	    </div>
	</div>
</form>
