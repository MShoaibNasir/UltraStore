@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<span class="panel-title d-none">{{ _lang('Create Coupon') }}</span>
	    <form method="post" class="validate" autocomplete="off" action="{{ route('coupons.store') }}">
			{{ csrf_field() }}
			
			<div class="row">
				<div class="col-lg-6">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('General Information') }}</span>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Name') }}</label>						
								        <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
							        </div>
							    </div>

								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Code') }}</label>						
								        <input type="text" class="form-control" name="code" value="{{ old('code') }}" required>
							        </div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Discount Type') }}</label>						
								        <select class="form-control auto-select" data-selected="{{ old('is_percent',0) }}" name="is_percent" required>
											<option value="0">{{ _lang('Fixed') }}</option>
											<option value="1">{{ _lang('Percent') }}</option>
										</select>
									</div>
							    </div>

								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Value') }}</label>						
								        <input type="text" class="form-control float-field" name="value" value="{{ old('value') }}">
							        </div>
							    </div>


								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Status') }}</label>						
								        <select class="form-control auto-select" data-selected="{{ old('is_active',1) }}" name="is_active" required>
											<option value="1">{{ _lang('Active') }}</option>
											<option value="0">{{ _lang('In Active') }}</option>
										</select>
									</div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Start Date') }}</label>						
								        <input type="text" class="form-control datepicker" name="start_date" value="{{ old('start_date') }}">
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('End Date') }}</label>						
								        <input type="text" class="form-control datepicker" name="end_date" value="{{ old('end_date') }}">
							        </div>
							    </div>
		
							</div>	
						</div>
					</div>			
				</div>


				<div class="col-lg-6">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Usage Restrictions') }}</span>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Minimum Spend') }}</label>						
								        <input type="number" class="form-control float-field" name="minimum_spend" value="{{ old('minimum_spend') }}">
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Maximum Spend') }}</label>						
								        <input type="number" class="form-control float-field" name="maximum_spend" value="{{ old('maximum_spend') }}">
							        </div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Products') }}</label>						
								        <select class="form-control auto-multiple-select select2" data-selected="[{{ old('products') ? implode (', ', old('products')) : '' }}]" name="products[]" multiple>
								        	@foreach(\App\Entity\Product\Product::all() as $product)
												<option value="{{ $product->id }}">{{ $product->translation->name }}</option>
											@endforeach
								        </select>
							        </div>
							    </div>

							     <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Exclude Products') }}</label>
								        <select class="form-control auto-multiple-select select2" data-selected="[{{ old('exclude_products') ? implode (', ', old('exclude_products')) : '' }}]" name="exclude_products[]" multiple>
								        	@foreach(\App\Entity\Product\Product::all() as $product)
												<option value="{{ $product->id }}">{{ $product->translation->name }}</option>
											@endforeach
								        </select>
							        </div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Categories') }}</label>						
								        <select class="form-control auto-multiple-select select2" data-selected="[{{ old('categories') ? implode (', ', old('categories')) : '' }}]" name="categories[]" multiple>
								        	{{ buildOptionTree(\App\Entity\Category\Category::all(), 0, null, 0, -1) }}
								        </select>
							        </div>
							    </div>

							     <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Exclude Categories') }}</label>
								        <select class="form-control auto-multiple-select select2" data-selected="[{{ old('exclude_categories') ? implode (', ', old('exclude_categories')) : '' }}]" name="exclude_categories[]" multiple>
								        	{{ buildOptionTree(\App\Entity\Category\Category::all(), 0, null, 0, -1) }}
								        </select>
							        </div>
							    </div>

							    <div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Usage Limit Per Coupon') }}</label>
								        <input type="number" class="form-control" name="usage_limit_per_coupon" value="{{ old('usage_limit_per_coupon') }}">
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Usage Limit Per Customer') }}</label>
								        <input type="number" class="form-control" name="usage_limit_per_customer" value="{{ old('usage_limit_per_customer') }}">
							        </div>
							    </div>

							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<button type="submit" class="btn btn-primary">{{ _lang('Save Coupon') }}</button>
					</div>
				</div>
			</div>			
	    </form>
    </div>
</div>
@endsection


