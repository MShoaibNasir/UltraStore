@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-3">
			<ul class="nav flex-column nav-tabs settings-tab" role="tablist">
				<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#general"><i class="ti-settings"></i> {{ _lang('General Settings') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#system"><i class="ti-brush-alt"></i> {{ _lang('System Settings') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#currency_settings"><i class="ti-money"></i> {{ _lang('Currency Settings') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#email"><i class="ti-email"></i> {{ _lang('Email Settings') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#payment_gateway"><i class="ti-credit-card"></i> {{ _lang('Payment Gateway') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#social_login"><i class="ti-google"></i> {{ _lang('Social Login') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#mailchimp_settings"><i class="fab fa-mailchimp"></i> {{ _lang('MailChimp Settings') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#logo"><i class="ti-image"></i> {{ _lang('Logo and Favicon') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cache"><i class="ti-server"></i> {{ _lang('Cache Control') }}</a></li>
			</ul>
		</div>
		  
		@php $settings = \App\Setting::all(); @endphp
		  
		<div class="col-sm-9">
			<div class="tab-content">
				<div id="general" class="tab-pane active">
					<div class="card">

						<div class="card-header">
							<span class="panel-title">{{ _lang('General Settings') }}</span>
						</div>

						<div class="card-body">
							 <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Company Name') }}</label>				
										<input type="text" class="form-control" name="company_name" value="{{ get_setting($settings, 'company_name') }}" required>
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Site Title') }}</label>						
										<input type="text" class="form-control" name="site_title" value="{{ get_setting($settings, 'site_title') }}" required>
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Phone') }}</label>						
										<input type="text" class="form-control" name="phone" value="{{ get_setting($settings, 'phone') }}">
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Email') }}</label>						
										<input type="email" class="form-control" name="email" value="{{ get_setting($settings, 'email') }}">
									  </div>
									</div>

									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Timezone') }}</label>						
										<select class="form-control select2" name="timezone" required>
										<option value="">{{ _lang('-- Select One --') }}</option>
										{{ create_timezone_option(get_setting($settings, 'timezone')) }}
										</select>
									  </div>
									</div>
									
													
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Language') }}</label>						
										<select class="form-control select2" name="language">
											<option value="">{{ _lang('-- Select One --') }}</option>
											{{ load_language( get_setting($settings, 'language') ) }}
										</select>
									  </div>
									</div>
	
									<div class="col-md-12">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Address') }}</label>						
										<textarea class="form-control" name="address">{{ get_setting($settings, 'address') }}</textarea>
									  </div>
									</div>

										
									<div class="col-md-12">
									  <div class="form-group">
										<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
									  </div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				 
				<div id="system" class="tab-pane">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('System Settings') }}</span>
						</div>

					  	<div class="card-body">

							<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Supported Countries') }}</label>						
										<select class="form-control select2 auto-multiple-select" data-selected="{{ get_setting($settings, 'supported_countries') }}" name="supported_countries[]" multiple="true">
											@foreach(get_all_country() as $country)
												<option value="{{ $country->name }}">{{ $country->name }}</option>
				                    	    @endforeach
										</select>
									  </div>
									</div>

								    <div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Backend Direction') }}</label>						
										<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'backend_direction','ltr') }}" name="backend_direction" required>
											<option value="ltr">{{ _lang('LTR') }}</option>
											<option value="rtl">{{ _lang('RTL') }}</option>
										</select>
									  </div>
									</div>
								
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Date Format') }}</label>						
										<select class="form-control auto-select" name="date_format" data-selected="{{ get_setting($settings, 'date_format','Y-m-d') }}" required>
											<option value="Y-m-d">{{ date('Y-m-d') }}</option>
											<option value="d-m-Y">{{ date('d-m-Y') }}</option>
											<option value="d/m/Y">{{ date('d/m/Y') }}</option>
											<option value="m-d-Y">{{ date('m-d-Y') }}</option>
											<option value="m.d.Y">{{ date('m.d.Y') }}</option>
											<option value="m/d/Y">{{ date('m/d/Y') }}</option>
											<option value="d.m.Y">{{ date('d.m.Y') }}</option>
											<option value="d/M/Y">{{ date('d/M/Y') }}</option>
											<option value="d/M/Y">{{ date('M/d/Y') }}</option>
											<option value="d M, Y">{{ date('d M, Y') }}</option>
										</select>
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Time Format') }}</label>						
										<select class="form-control auto-select" name="time_format" data-selected="{{ get_setting($settings, 'time_format',24) }}" required>
											<option value="24">{{ _lang('24 Hours') }}</option>
											<option value="12">{{ _lang('12 Hours') }}</option>
										</select>
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Email Verification') }}</label>
										<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'email_verification','disabled') }}" name="email_verification" required>
											<option value="enabled">{{ _lang('Enable') }}</option>
											<option value="disabled">{{ _lang('Disable') }}</option>
										</select>
									  </div>
									</div>		

									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Media File Type Supported') }}</label>	
										<input type="text" class="form-control" name="media_file_types_supported" value="{{ get_setting($settings, 'media_file_types_supported','png,jpg,jpeg') }}">
									  </div>
									</div>	

									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Media Max Upload Size in MB') }}</label>
										<small class="float-right">{{ _lang('Max').' '.@ini_get("upload_max_filesize").' '._lang('Supported by your server') }}</small>	
										<input type="text" class="form-control" name="media_max_upload_size" value="{{ get_setting($settings, 'media_max_upload_size',2) }}">
									  </div>
									</div>	

									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Digital File Max Upload Size in MB') }}</label>
										<small class="float-right">{{ _lang('Max').' '.@ini_get("upload_max_filesize").' '._lang('Supported by your server') }}</small>
										<input type="text" class="form-control" name="digital_file_max_upload_size" value="{{ get_setting($settings, 'digital_file_max_upload_size',2) }}">
									  </div>
									</div>			
										
									<div class="col-md-12">
									  <div class="form-group">
										<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
									  </div>
									</div>
								</div>
						    </form>
					  	</div>
					</div>
				</div>


				<div id="currency_settings" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Currency Settings') }}</span>
						</div>

						<div class="card-body"> 
						   <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">
									
								    <div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Currency Converter') }}</label>
											<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'currency_converter','manual') }}" name="currency_converter" required>
												<option value="manual">{{ _lang('Manual') }}</option>
												<option value="fixer">{{ _lang('Fixer API') }}</option>
											</select>
									  	</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label">{{ _lang('Fixer API Key').' ('._lang('Currency Converter').')' }}</label>	
											<a href="https://fixer.io/" target="_blank" class="btn-link pull-right">{{ _lang('GET API KEY') }}</a>	
											<input type="text" class="form-control" name="fixer_api_key" value="{{ get_setting($settings, 'fixer_api_key') }}">
										</div>
									</div>								
									
									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Currency Position') }}</label>						
											<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'currency_position','left') }}" name="currency_position" required>
												<option value="left">{{ _lang('Left') }}</option>
												<option value="right">{{ _lang('Right') }}</option>
											</select>
									  	</div>
									</div>


									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Thousand Seperator') }}</label>	
											<input type="text" class="form-control" name="thousand_sep" value="{{ get_setting($settings, 'thousand_sep',',') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Decimal Seperator') }}</label>	
											<input type="text" class="form-control" name="decimal_sep" value="{{ get_setting($settings, 'decimal_sep','.') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Decimal Places') }}</label>	
											<input type="text" class="form-control" name="decimal_places" value="{{ get_setting($settings, 'decimal_places',2) }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
									  	</div>
									</div>	
								</div>							
							</form>
						</div>
					</div>
				</div>
				 
				
				<div id="email" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Email Settings') }}</span>
						</div>

					    <div class="card-body">
							<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('Mail Type') }}</label>						
										<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'mail_type','smtp') }}" name="mail_type" id="mail_type" required>
										  <option value="smtp">{{ _lang('SMTP') }}</option>
										  <option value="sendmail">{{ _lang('Sendmail') }}</option>
										</select>
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('From Email') }}</label>						
										<input type="text" class="form-control" name="from_email" value="{{ get_setting($settings, 'from_email') }}" required>
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('From Name') }}</label>						
										<input type="text" class="form-control" name="from_name" value="{{ get_setting($settings, 'from_name') }}" required>
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('SMTP Host') }}</label>						
										<input type="text" class="form-control smtp" name="smtp_host" value="{{ get_setting($settings, 'smtp_host') }}">
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('SMTP Port') }}</label>						
										<input type="text" class="form-control smtp" name="smtp_port" value="{{ get_setting($settings, 'smtp_port') }}">
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('SMTP Username') }}</label>						
										<input type="text" class="form-control smtp" autocomplete="off" name="smtp_username" value="{{ get_setting($settings, 'smtp_username') }}">
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('SMTP Password') }}</label>						
										<input type="password" class="form-control smtp" autocomplete="off" name="smtp_password" value="{{ get_setting($settings, 'smtp_password') }}">
									  </div>
									</div>
									
									<div class="col-md-6">
									  <div class="form-group">
										<label class="control-label">{{ _lang('SMTP Encryption') }}</label>						
										<select class="form-control smtp auto-select" data-selected="{{ get_setting($settings, 'smtp_encryption','ssl') }}" name="smtp_encryption">
										   <option value="">{{ _lang('None') }}</option>
										   <option value="ssl">{{ _lang('SSL') }}</option>
										   <option value="tls">{{ _lang('TLS') }}</option>
										</select>
									  </div>
									</div>
									
									<div class="col-md-12">
									  <div class="form-group">
										<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
									  </div>
									</div>
								</div>						
							</form>
					    </div>
					</div>
				</div>
				  
				  
				<div id="payment_gateway" class="tab-pane fade">
			
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Payment Gateway') }}</span>
						</div>

						<div class="card-body">

							<div class="accordion" id="payment_gateway">
                                <div class="card">
									<div class="card-header params-panel" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
									  <span>{{ _lang('PayPal') }}</span>
									</div>

									<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#payment_gateway">
									  	<div class="card-body">
										   <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">
                                               
												{{ csrf_field() }}
												<div class="row">
													<div class="col-md-4">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Enable PayPal') }}</label>					
														<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'paypal_active','No') }}" name="paypal_active" id="paypal_active" required>
														   <option value="No">{{ _lang('No') }}</option>
														   <option value="Yes">{{ _lang('Yes') }}</option>
														</select>
													  </div>
													</div>
	
													<div class="col-md-4">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Label') }}</label>						
														<input type="text" class="form-control" name="paypal_label" value="{{ get_setting($settings, 'paypal_label','PayPal') }}" required>
													  </div>
													</div>

													<div class="col-md-4">
													  <div class="form-group">
														<label class="control-label">{{ _lang('PayPal Mode') }}</label>					
														<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'paypal_mode','sandbox') }}" name="paypal_mode" required>
														   <option value="sandbox">{{ _lang('Sandbox') }}</option>
														   <option value="Yes">{{ _lang('Yes') }}</option>
														</select>
													  </div>
													</div>

													<div class="col-md-12">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Description') }}</label>						
														<textarea class="form-control" name="paypal_description" required>{{ get_setting($settings, 'paypal_description','Pay Via PayPal') }}</textarea>
													  </div>
													</div>

													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Client ID') }}</label>						
														<input type="text" class="form-control" name="paypal_client_id" value="{{ get_setting($settings, 'paypal_client_id') }}" required>
													  </div>
													</div>

													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Secret') }}</label>						
														<input type="text" class="form-control" name="paypal_secret" value="{{ get_setting($settings, 'paypal_secret') }}" required>
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
								</div>

								<div class="card">
									<div class="card-header params-panel" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
									  <span>{{ _lang('Stripe') }}</span>
									</div>

									<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#payment_gateway">
									  	<div class="card-body">
										   <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">

												{{ csrf_field() }}
												<div class="row">
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Enable Stripe') }}</label>						
														<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'stripe_active','No') }}" name="stripe_active" required>
														   <option value="Yes">{{ _lang('Yes') }}</option>
														   <option value="No">{{ _lang('No') }}</option>
														</select>
													  </div>
													</div>

													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Label') }}</label>						
														<input type="text" class="form-control" name="stripe_label" value="{{ get_setting($settings, 'stripe_label','Stripe') }}" required>
													  </div>
													</div>

													<div class="col-md-12">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Description') }}</label>						
														<input type="text" class="form-control" name="stripe_description" value="{{ get_setting($settings, 'stripe_description','Pay Via Credit Card') }}" required>
													  </div>
													</div>
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Secret Key') }}</label>
														<input type="text" class="form-control" name="stripe_secret_key" value="{{ get_setting($settings, 'stripe_secret_key') }}" required>
													  </div>
													</div>
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Publishable Key') }}</label>						
														<input type="text" class="form-control" name="stripe_publishable_key" value="{{ get_setting($settings, 'stripe_publishable_key') }}" required>
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
								</div> <!--End Stripe -->

								<div class="card">
									<div class="card-header params-panel" data-toggle="collapse" data-target="#razorpay" aria-expanded="true" aria-controls="razorpay">
									  <span>{{ _lang('Razorpay') }}</span>
									</div>

									<div id="razorpay" class="collapse" aria-labelledby="razorpay" data-parent="#payment_gateway">
									  	<div class="card-body">
										   <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">

												{{ csrf_field() }}
												<div class="row">
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Enable Razorpay') }}</label>						
														<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'razorpay_active','No') }}" name="razorpay_active" required>
														   <option value="Yes">{{ _lang('Yes') }}</option>
														   <option value="No">{{ _lang('No') }}</option>
														</select>
													  </div>
													</div>

													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Label') }}</label>						
														<input type="text" class="form-control" name="razorpay_label" value="{{ get_setting($settings, 'razorpay_label','Razorpay') }}" required>
													  </div>
													</div>

													<div class="col-md-12">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Description') }}</label>						
														<input type="text" class="form-control" name="razorpay_description" value="{{ get_setting($settings, 'razorpay_description') }}" required>
													  </div>
													</div>
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Key ID') }}</label>
														<input type="text" class="form-control" name="razorpay_key_id" value="{{ get_setting($settings, 'razorpay_key_id') }}" required>
													  </div>
													</div>
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Key Secret') }}</label>	
														<input type="text" class="form-control" name="razorpay_key_secret" value="{{ get_setting($settings, 'razorpay_key_secret') }}" required>
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
								</div> <!--End Stripe -->

								<div class="card">
									<div class="card-header params-panel" data-toggle="collapse" data-target="#paystack" aria-expanded="true" aria-controls="paystack">
									  <span>{{ _lang('PayStack') }}</span>
									</div>

									<div id="paystack" class="collapse" aria-labelledby="paystack" data-parent="#payment_gateway">
									  	<div class="card-body">
										   <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">

												{{ csrf_field() }}
												<div class="row">
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Enable Paystack') }}</label>						
														<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'paystack_active','No') }}" name="paystack_active" required>
														   <option value="Yes">{{ _lang('Yes') }}</option>
														   <option value="No">{{ _lang('No') }}</option>
														</select>
													  </div>
													</div>

													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Label') }}</label>						
														<input type="text" class="form-control" name="paystack_label" value="{{ get_setting($settings, 'paystack_label','Paystack') }}" required>
													  </div>
													</div>

													<div class="col-md-12">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Description') }}</label>						
														<input type="text" class="form-control" name="paystack_description" value="{{ get_setting($settings, 'paystack_description') }}" required>
													  </div>
													</div>
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Public Key') }}</label>
														<input type="text" class="form-control" name="paystack_public_key" value="{{ get_setting($settings, 'paystack_public_key') }}" required>
													  </div>
													</div>
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Secret Key') }}</label>	
														<input type="text" class="form-control" name="paystack_secret_key" value="{{ get_setting($settings, 'paystack_secret_key') }}" required>
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
								</div> <!--End PayStack -->

								<div class="card">
									<div class="card-header params-panel" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
									  <span>{{ _lang('Cash On Delivery') }}</span>
									</div>

									<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#payment_gateway">
									  	<div class="card-body">
										   <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">

												{{ csrf_field() }}
												<div class="row">
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Enable Cash On Delivery') }}</label>		
														<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'cod_active','No') }}" name="cod_active" required>
														   <option value="Yes">{{ _lang('Yes') }}</option>
														   <option value="No">{{ _lang('No') }}</option>
														</select>
													  </div>
													</div>

													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Label') }}</label>						
														<input type="text" class="form-control" name="cod_label" value="{{ get_setting($settings, 'cod_label','Cash On Delivery') }}" required>
													  </div>
													</div>

													<div class="col-md-12">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Description') }}</label>						
														<textarea class="form-control" name="cod_description" required>{{ get_setting($settings, 'cod_description','Cash On Delivery') }}</textarea>
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
								</div><!-- End Cash on Delivery-->

								<div class="card">
									<div class="card-header params-panel" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
									  <span>{{ _lang('Bank Transfer') }}</span>
									</div>

									<div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#payment_gateway">
									  	<div class="card-body">
										   <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">

												{{ csrf_field() }}
												<div class="row">
													
													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Enable Bank Transfer') }}</label>		
														<select class="form-control auto-select" data-selected="{{ get_setting($settings, 'bank_transfer_active','No') }}" name="bank_transfer_active" required>
														   <option value="Yes">{{ _lang('Yes') }}</option>
														   <option value="No">{{ _lang('No') }}</option>
														</select>
													  </div>
													</div>

													<div class="col-md-6">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Label') }}</label>						
														<input type="text" class="form-control" name="bank_transfer_label" value="{{ get_setting($settings, 'bank_transfer_label','Bank Transfer') }}" required>
													  </div>
													</div>

													<div class="col-md-12">
													  <div class="form-group">
														<label class="control-label">{{ _lang('Description') }}</label>						
														<textarea class="form-control" name="bank_transfer_description" required>{{ get_setting($settings, 'bank_transfer_description') }}</textarea>
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
								</div><!-- End Bank Transfer-->

							</div>	
						</div>
					</div>
				</div>
				  
				<div id="social_login" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Social Login') }}</span>
						</div>
						<div class="card-body">
							<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								
								<h5 class="header-title">{{ _lang('Google Login') }}</h5>
								<div class="params-panel border border-dark p-3">
									<div class="row">		
										
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Google Login') }}</label>
											<select class="form-control select2 auto-select" data-selected="{{ get_setting($settings, 'google_login','disabled') }}" name="google_login" required>
												<option value="disabled">{{ _lang('Disable') }}</option>
												<option value="enabled">{{ _lang('Enable') }}</option>
											</select>
										  </div>
										</div>
										
										
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('GOOGLE CLIENT ID') }}</label> <a href="https://console.developers.google.com/apis/credentials" target="_blank" class="btn-link float-right">{{ _lang('GET API KEY') }}</a>	
											<input type="text" class="form-control" name="GOOGLE_CLIENT_ID" value="{{ get_setting($settings, 'GOOGLE_CLIENT_ID') }}">
										  </div>
										</div>
										
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('GOOGLE CLIENT SECRET') }}</label>						
											<input type="text" class="form-control" name="GOOGLE_CLIENT_SECRET" value="{{ get_setting($settings, 'GOOGLE_CLIENT_SECRET') }}">
										  </div>
										</div>
										
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('GOOGLE REDIRECT URL') }}</label>						
											<input type="text" class="form-control" value="{{ url('login/google/callback') }}" readOnly="true">
										  </div>
										</div>
										
									</div>	
								</div>
								
								<br>
								<h5 class="header-title">{{ _lang('Facebook Login') }}</h5>
								<div class="params-panel border border-dark p-3">
									<div class="row">
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('Facebook Login') }}</label>
											<select class="form-control select2 auto-select" data-selected="{{ get_setting($settings, 'facebook_login','disabled') }}" name="facebook_login" required>
												<option value="disabled">{{ _lang('Disable') }}</option>
												<option value="enabled">{{ _lang('Enable') }}</option>
											</select>
										  </div>
										</div>
										
										
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('FACEBOOK APP ID') }}</label>					<a href="https://developers.facebook.com/apps" target="_blank" class="btn-link float-right">{{ _lang('GET API KEY') }}</a>	
											<input type="text" class="form-control" name="FACEBOOK_CLIENT_ID" value="{{ get_setting($settings, 'FACEBOOK_CLIENT_ID') }}">
										  </div>
										</div>
										
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('FACEBOOK APP SECRET') }}</label>						
											<input type="text" class="form-control" name="FACEBOOK_CLIENT_SECRET" value="{{ get_setting($settings, 'FACEBOOK_CLIENT_SECRET') }}">
										  </div>
										</div>
										
										<div class="col-md-6">
										  <div class="form-group">
											<label class="control-label">{{ _lang('FACEBOOK REDIRECT URL') }}</label>						
											<input type="text" class="form-control" value="{{ url('login/facebook/callback') }}" readOnly="true">
										  </div>
										</div>
									</div>
								</div>

								<br>
								<div class="row">
									<div class="col-md-12">
									  <div class="form-group">
										<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
									  </div>
									</div>							
								</div>		

							</form>
						</div>
					</div>
				</div>

				<div id="mailchimp_settings" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Mailchimp Settings') }}</span>
						</div>

						<div class="card-body">
 							<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['general_settings','store']) }}">				         
								{{ csrf_field() }}
								<div class="row">

									<div class="col-md-12">
										<div class="form-group">
											<label>
												<input type="hidden" name="enable_newsletter" value="0">
												<input type="checkbox" value="1" name="enable_newsletter" {{ get_option('enable_newsletter') == 1 ? 'checked' : '' }}> {{ _lang('Enable Newsletter') }}
											</label>
										</div>	
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Newsletter Title') }}</label>
											<input type="text" class="form-control" name="Newsletter_title" value="{{ get_trans_option('Newsletter_title') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('MAILCHIMP API KEY') }}</label>
											<input type="text" class="form-control" name="MAILCHIMP_APIKEY" value="{{ get_setting($settings, 'MAILCHIMP_APIKEY') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('MAILCHIMP LIST ID') }}</label>
											<input type="text" class="form-control" name="MAILCHIMP_LIST_ID" value="{{ get_setting($settings, 'MAILCHIMP_LIST_ID') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
									  	</div>
									</div>	
							
								</div>
						   </form>	
						</div>

					</div>
				</div>
				  
				  
				<div id="logo" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Logo and Favicon') }}</span>
						</div>

						<div class="card-body">
							<div class="row">
								<div class="col-md-6">
									<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.uplaod_logo') }}" enctype="multipart/form-data">				         	
										{{ csrf_field() }}
										<div class="row">
											<div class="col-md-12">
											  <div class="form-group">
												<label class="control-label">{{ _lang('Upload Logo') }}</label>						
												<input type="file" class="form-control dropify" name="logo" data-max-file-size="8M" data-allowed-file-extensions="png jpg jpeg PNG JPG JPEG" data-default-file="{{ get_logo() }}" required>
											  </div>
											</div>
											
											<br>
											<div class="col-md-12">
											  <div class="form-group">
												<button type="submit" class="btn btn-primary btn-block">{{ _lang('Upload') }}</button>
											  </div>
											</div>	
										</div>	
									</form>
								</div>

								<div class="col-md-6">
									<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('settings.update_settings','store') }}" enctype="multipart/form-data">	
										{{ csrf_field() }}
										<div class="row">	
											<div class="col-md-12">
											  <div class="form-group">
												<label class="control-label">{{ _lang('Upload Favicon') }} (PNG)</label>						
												<input type="file" class="form-control dropify" name="favicon" data-max-file-size="2M" data-allowed-file-extensions="png" data-default-file="{{ get_favicon() }}" required>
											  </div>
											</div>
											
											<br>
											<div class="col-md-12">
											  <div class="form-group">
												<button type="submit" class="btn btn-primary btn-block">{{ _lang('Upload') }}</button>
											  </div>
											</div>	
										</div>
                                    </form>										
								</div>									
							</div>
				  		</div>
			   		</div>  
				</div><!--End Logo Tab-->


				<div id="cache" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Cache Control') }}</span>
						</div>

						<div class="card-body">
							<form method="post" class="params-panel" autocomplete="off" action="{{ route('settings.remove_cache') }}">	
								{{ csrf_field() }}
								<div class="row">	
									<div class="col-md-12">
									  	<div class="checkbox">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="cache[view_cache]" value="view_cache" id="view_cache">
												<label class="custom-control-label" for="view_cache">{{ _lang('View Cache') }}</label>
											</div>
										</div>
									</div>

									<div class="col-md-12">
									  	<div class="checkbox">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="cache[application_cache]" value="application_cache" id="application_cache">
												<label class="custom-control-label" for="application_cache">{{ _lang('Application Cache') }}</label>
											</div>
										</div>
									</div>
									
									<br>
									<br>
									<div class="col-md-12">
									  <div class="form-group">
										<button type="submit" class="btn btn-primary">{{ _lang('Remove Cache') }}</button>
									  </div>
									</div>	
								</div>
                            </form>										
				  		</div>
			   		</div>  
				</div><!--End Cache Tab-->
		</div>
	</div>
</div>
@endsection
