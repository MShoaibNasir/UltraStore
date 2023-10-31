@extends('theme.default.website')

@section('content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="{{ url('') }}">{{ _lang('Home') }}<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="">{{ _lang('Update Address') }}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->
	
<!-- Login Screen -->
<section id="auth"> 
	<div class="container">
		<div class="row">
		   <div class="col-lg-3 col-md-4">
			  <div class="customer_dashboard">
				 @include('theme.default.customer.my_account.menu')
			  </div>
		   </div>
		   <div class="col-lg-9 col-md-8">
				<div class="dashboard_content">
					<div class="card">
						<div class="card-header">
						   <h4>{{ _lang('Update Address') }}</h4>
						</div>
						<div class="card-body">
							@if(\Session::has('success'))
								<div class="alert alert-success mt-4">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<span>{!! xss_clean(session('success')) !!}</span>
								</div>
							@endif

							@if(\Session::has('error'))
								<div class="alert alert-danger mt-4">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<span>{!! xss_clean(session('error')) !!}</span>
								</div>
							@endif
				
							<div class="account_details">
							    <form action="{{ url('/update_address/'.$address->id) }}" method="post">
									@csrf
									<input name="_method" type="hidden" value="PATCH">
									<div class="row">
										<div class="col-md-12">
											<input type="text" name="name" value="{{ $address->name }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="{{ _lang('Name') }}" required>
											
											@if($errors->has('name'))
												<div class="invalid-feedback">
										          {{ $errors->first('name') }}
										        </div>
									        @endif
									    </div>

									    <div class="col-md-6">
											 @php $supported_countries = get_option('supported_countries'); @endphp
						                    	    
											<select class="form-control customer-country" name="country" required>
								                <option value="">{{ _lang('Select Country') }}</option>	
					                    	    @if(!empty($supported_countries))
						                    	    @foreach(get_all_country() as $country)
 														@if(in_array($country->name, $supported_countries))
 															<option value="{{ $country->sortname }}" data-id="{{ $country->id }}" {{ $address->country == $country->sortname ? 'selected' : '' }}>
 																{{ $country->name }}
 															</option>
 														@endif
						                    	    @endforeach
					                    	    @endif
											</select>
											@if($errors->has('country'))
												<div class="invalid-feedback">
										          {{ $errors->first('country') }}
										        </div>
									        @endif
									    </div>


									    <div class="col-md-6">
									    	<select class="form-control" id="state" name="state" required>
									    		@foreach(get_states(get_country_id($address->country)) as $state)
													<option value="{{ $state->name }}" {{ $state->name ==  $address->state ? 'selected' : '' }}>{{ $state->name }}</option>
					                    	    @endforeach
									    	</select>
			
											@if($errors->has('state'))
												<div class="invalid-feedback">
										          {{ $errors->first('state') }}
										        </div>
									        @endif
									    </div>

									    <div class="col-md-12">
											<input type="text" name="city" value="{{ $address->city }}" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" placeholder="{{ _lang('City') }}" required>
											
											@if($errors->has('city'))
												<div class="invalid-feedback">
										          {{ $errors->first('city') }}
										        </div>
									        @endif
									    </div>

									    <div class="col-md-12">
											<textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" placeholder="{{ _lang('Address') }}" required>{{ $address->address }}</textarea>

											@if($errors->has('address'))
												<div class="invalid-feedback">
										          {{ $errors->first('address') }}
										        </div>
									        @endif
									    </div>

									    <div class="col-md-6">
											<input type="text" name="post_code"  value="{{ $address->post_code }}" class="form-control {{ $errors->has('post_code') ? 'is-invalid' : '' }}" placeholder="{{ _lang('Post Code') }}" required>

											@if($errors->has('post_code'))
												<div class="invalid-feedback">
										          {{ $errors->first('post_code') }}
										        </div>
									        @endif
									    </div>

									    <div class="col-md-6">	        
									        <select class="form-control" name="is_default" required>
												<option value="">{{ _lang('is Default') }}</option>
												<option value="0" {{ $address->is_default == 0 ? 'selected' : '' }}>{{ _lang('No') }}</option>
												<option value="1" {{ $address->is_default == 1 ? 'selected' : '' }}>{{ _lang('Yes') }}</option>
											</select>
											@if($errors->has('is_default'))
												<div class="invalid-feedback">
										          {{ $errors->first('is_default') }}
										        </div>
									        @endif
									    </div>

										
										<div class="col-md-12">
											<button type="submit" class="btn-login">{{ _lang('Update Changes') }}</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
		   </div>
		</div>
	</div>
</section>
<!--/ End Login Screen -->
		

@endsection