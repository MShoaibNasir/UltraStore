@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">

		<form method="post" class="validate" autocomplete="off" action="{{ action('CouponController@update', $id) }}" enctype="multipart/form-data">
			{{ csrf_field()}}
			<input name="_method" type="hidden" value="PATCH">	

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
								        <input type="text" class="form-control" name="name" value="{{ $coupon->translation->name }}" required>
							        </div>
							    </div>

								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Code') }}</label>						
								        <input type="text" class="form-control" name="code" value="{{ $coupon->code }}" required>
							        </div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Discount Type') }}</label>						
								        <select class="form-control auto-select" data-selected="{{ $coupon->is_percent }}" name="is_percent" required>
											<option value="0">{{ _lang('Fixed') }}</option>
											<option value="1">{{ _lang('Percent') }}</option>
										</select>
									</div>
							    </div>

								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Value') }}</label>						
								        <input type="text" class="form-control float-field" name="value" value="{{ $coupon->value }}">
							        </div>
							    </div>

								<div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Status') }}</label>						
								        <select class="form-control auto-select" data-selected="{{ $coupon->is_active }}" name="is_active" required>
											<option value="1">{{ _lang('Active') }}</option>
											<option value="0">{{ _lang('In Active') }}</option>
										</select>
									</div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Start Date') }}</label>						
								        <input type="text" class="form-control datepicker" name="start_date" value="{{ $coupon->start_date }}">
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('End Date') }}</label>						
								        <input type="text" class="form-control datepicker" name="end_date" value="{{ $coupon->end_date }}">
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
								        <input type="number" class="form-control float-field" name="minimum_spend" value="{{ $coupon->minimum_spend }}">
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Maximum Spend') }}</label>						
								        <input type="number" class="form-control float-field" name="maximum_spend" value="{{ $coupon->maximum_spend }}">
							        </div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Products') }}</label>						
								        <select class="form-control auto-multiple-select select2" data-selected="{{ $coupon->products->pluck('id') }}" name="products[]" multiple>
								        	@foreach(\App\Entity\Product\Product::all() as $product)
												<option value="{{ $product->id }}">{{ $product->translation->name }}</option>
											@endforeach
								        </select>
							        </div>
							    </div>

							     <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Exclude Products') }}</label>
								        <select class="form-control auto-multiple-select select2" data-selected="{{ $coupon->excludeProducts->pluck('id') }}" name="exclude_products[]" multiple>
								        	@foreach(\App\Entity\Product\Product::all() as $product)
												<option value="{{ $product->id }}">{{ $product->translation->name }}</option>
											@endforeach
								        </select>
							        </div>
							    </div>

							    <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Categories') }}</label>						
								        <select class="form-control auto-multiple-select select2" data-selected="{{ $coupon->categories->pluck('id') }}" name="categories[]" multiple>
								        	{{ buildOptionTree(\App\Entity\Category\Category::all(), 0, null, 0, -1) }}
								        </select>
							        </div>
							    </div>

							     <div class="col-md-12">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Exclude Categories') }}</label>
								        <select class="form-control auto-multiple-select select2" data-selected="{{ $coupon->excludeCategories->pluck('id') }}" name="exclude_categories[]" multiple>
								        	{{ buildOptionTree(\App\Entity\Category\Category::all(), 0, null, 0, -1) }}
								        </select>
							        </div>
							    </div>

							    <div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Usage Limit Per Coupon') }}</label>
								        <input type="number" class="form-control" name="usage_limit_per_coupon" value="{{ $coupon->usage_limit_per_coupon }}">
							        </div>
							    </div>

								<div class="col-md-6">
							        <div class="form-group">
								        <label class="control-label">{{ _lang('Usage Limit Per Customer') }}</label>
								        <input type="number" class="form-control" name="usage_limit_per_customer" value="{{ $coupon->usage_limit_per_customer }}">
							        </div>
							    </div>

							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="form-group">
						<button type="submit" class="btn btn-primary">{{ _lang('Update Coupon') }}</button>
					</div>
				</div>
			</div>	
		</form>
	</div>
</div>

@endsection


