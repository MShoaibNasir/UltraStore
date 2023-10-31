@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card">
		    <div class="card-header">
			    <span class="card-title panel-title">{{ _lang('Shipping Methods') }}</span>
			</div>
			
			<div class="card-body">			
				<div class="accordion" id="shipping_methods">
					<div class="card">
						<div class="card-header params-panel" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						  <h5 class="mb-0">{{ _lang('Free Shipping') }}</h5>
						</div>

						<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#shipping_methods">
							<div class="card-body">
								<form method="post" class="settings-submit" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Enable Free Shipping') }}</label>						
											<select class="form-control auto-select" data-selected="{{ get_option('free_shipping_active','No') }}" name="free_shipping_active" required>
											   <option value="No">{{ _lang('No') }}</option>
											   <option value="Yes">{{ _lang('Yes') }}</option>
											</select>
										  </div>
										</div>
									</div>
									
									<div class="row">								
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Lable') }}</label>						
											<input type="text" class="form-control" name="free_shipping_label" value="{{ get_option('free_shipping_label') }}" required>
										  </div>
										</div>
									</div>
									
									<div class="row">	
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Minimum Amount') }}</label>						
											<input type="text" class="form-control float-field" name="free_shipping_minimum_amount" value="{{ get_option('free_shipping_minimum_amount') }}">
										  </div>
										</div>

																		
										<div class="col-md-12">
										  <div class="form-group">
											<button type="submit" class="btn btn-primary pull-right">{{ _lang('Save Settings') }}</button>
										  </div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div><!--End Free Shipping-->
					
					
					<div class="card">
						<div class="card-header params-panel" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
						  <h5 class="mb-0">{{ _lang('Local Pickup') }}</h5>
						</div>

						<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#shipping_methods">
							<div class="card-body">
								<form method="post" class="settings-submit" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Enable Local Pickup') }}</label>						
											<select class="form-control auto-select" data-selected="{{ get_option('local_pickup_active','No') }}" name="local_pickup_active" required>
											   <option value="No">{{ _lang('No') }}</option>
											   <option value="Yes">{{ _lang('Yes') }}</option>
											</select>
										  </div>
										</div>
									</div>
									
									<div class="row">								
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Lable') }}</label>						
											<input type="text" class="form-control" name="local_pickup_label" value="{{ get_option('local_pickup_label') }}" required>
										  </div>
										</div>
									</div>
									
									<div class="row">	
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Cost') }}</label>						
											<input type="text" class="form-control float-field" name="local_pickup_cost" value="{{ get_option('local_pickup_cost') }}" required>
										  </div>
										</div>

																		
										<div class="col-md-12">
										  <div class="form-group">
											<button type="submit" class="btn btn-primary pull-right">{{ _lang('Save Settings') }}</button>
										  </div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div><!--Local Pickup-->
					
					
					<div class="card">
						<div class="card-header params-panel" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
						  <h5 class="mb-0">{{ _lang('Flat Rate') }}</h5>
						</div>

						<div id="collapseThree" class="collapse" aria-labelledby="collapseThree" data-parent="#shipping_methods">
							<div class="card-body">
								<form method="post" class="settings-submit" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">
									{{ csrf_field() }}
									<div class="row">
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Enable Flat Rate') }}</label>						
											<select class="form-control auto-select" data-selected="{{ get_option('flat_rate_active','No') }}" name="flat_rate_active" required>
											   <option value="No">{{ _lang('No') }}</option>
											   <option value="Yes">{{ _lang('Yes') }}</option>
											</select>
										  </div>
										</div>
									</div>
									
									<div class="row">								
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Lable') }}</label>						
											<input type="text" class="form-control" name="flat_rate_label" value="{{ get_option('flat_rate_label') }}" required>
										  </div>
										</div>
									</div>
									
									<div class="row">	
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Cost') }}</label>						
											<input type="text" class="form-control float-field" name="flat_rate_cost" value="{{ get_option('flat_rate_cost') }}" required>
										  </div>
										</div>

																		
										<div class="col-md-12">
										  <div class="form-group">
											<button type="submit" class="btn btn-primary pull-right">{{ _lang('Save Settings') }}</button>
										  </div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div><!--Flat Rate-->
					 
				</div>
			</div>
		</div>  
	</div>
</div>
@endsection

