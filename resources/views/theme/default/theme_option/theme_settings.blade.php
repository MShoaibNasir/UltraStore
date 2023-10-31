@extends('layouts.app')

@section('content')
	
    <div class="row">
        <div class="col-sm-3">
			<ul class="nav flex-column nav-tabs settings-tab" role="tablist">
				<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menus"><i class="ti-view-list-alt"></i> {{ _lang('Menu Management') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#footer"><i class="ti-layout-cta-left"></i> {{ _lang('Footer') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#services"><i class="ti-layout-grid3"></i> {{ _lang('Services') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#appearance"><i class="ti-palette"></i> {{ _lang('Theme Appearance') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#seo"><i class="ti-world"></i> {{ _lang('SEO') }}</a></li>
				<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#social_links"><i class="ti-instagram"></i> {{ _lang('Social Links') }}</a></li>
			</ul>
		</div>
		  
		  
		<div class="col-sm-9">
			<div class="tab-content">
				 
				<div id="menus" class="tab-pane active">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Menu Management') }}</span>
						</div>

					  	<div class="card-body">

							<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['general_settings','store']) }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">

									@php $navigations = App\Entity\Navigation\Navigation::where('status',1)->get(); @endphp

								    <div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Primary Menu') }}</label>
											<select class="form-control auto-select" data-selected="{{ get_option('primary_menu') }}" name="primary_menu">
												<option value="">{{ _lang('Select One') }}</option>
												@foreach($navigations as $navigation)
													<option value="{{ $navigation->id }}">{{ $navigation->name }}</option>
												@endforeach
											</select>
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Category Menu') }}</label>
											<select class="form-control auto-select" data-selected="{{ get_option( 'category_menu') }}" name="category_menu">
												<option value="">{{ _lang('Select One') }}</option>
												@foreach($navigations as $navigation)
													<option value="{{ $navigation->id }}">{{ $navigation->name }}</option>
												@endforeach
											</select>
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Footer Menu 1 Title') }}</label>
											<input type="text" class="form-control" name="footer_menu_1_title" value="{{ get_trans_option('footer_menu_1_title') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Footer Menu 1') }}</label>
											<select class="form-control auto-select" data-selected="{{ get_option('footer_menu_1') }}" name="footer_menu_1">
												<option value="">{{ _lang('Select One') }}</option>
												@foreach($navigations as $navigation)
													<option value="{{ $navigation->id }}">{{ $navigation->name }}</option>
												@endforeach
											</select>
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Footer Menu 2 Title') }}</label>
											<input type="text" class="form-control" name="footer_menu_2_title" value="{{ get_trans_option('footer_menu_2_title') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Footer Menu 2') }}</label>
											<select class="form-control auto-select" data-selected="{{ get_option('footer_menu_2') }}" name="footer_menu_2">
												<option value="">{{ _lang('Select One') }}</option>
												@foreach($navigations as $navigation)
													<option value="{{ $navigation->id }}">{{ $navigation->name }}</option>
												@endforeach
											</select>
									  	</div>
									</div>
												
									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Changes') }}</button>
									  	</div>
									</div>
								</div>
						    </form>
					  	</div>
					</div>
				</div>


				<div id="footer" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Footer Settings') }}</span>
						</div>

						<div class="card-body"> 
						   <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['general_settings','store']) }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('About Us') }}</label>	
											<textarea class="form-control" name="footer_about_us">{{ get_trans_option('footer_about_us') }}</textarea>
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Copyright Text') }}</label>
											<input type="text" class="form-control" name="copyright_text" value="{{ get_trans_option('copyright_text') }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Payment Menthod Image') }}</label>
											<input type="file" class="form-control dropify" name="payment_method_image" data-allowed-file-extensions="png" data-default-file="{{ get_option('payment_method_image') != '' ? asset('public/uploads/media/'.get_option('payment_method_image')) : '' }}">
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Changes') }}</button>
									  	</div>
									</div>	
								</div>							
							</form>
						</div>
					</div>
				</div>
				
				<div id="services" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Services') }}</span>
						</div>

					    <div class="card-body">
							<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['general_settings','store']) }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-12">
										<h4>{{ _lang('Service 1') }}</h4>	
										<hr>	
									</div>	

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Title') }}</label>	
											<input type="text" class="form-control" name="service_1_title" value="{{ get_trans_option('service_1_title') }}">
									  	</div>
									</div>
									
									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Sub Title') }}</label>
											<input type="text" class="form-control" name="service_1_sub_title" value="{{ get_trans_option('service_1_sub_title') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Icon') }}</label>
											(<a _target="_blank" href="https://themify.me/themify-icons">{{ _lang('Suppored Icons') }}</a>)
											<input type="text" class="form-control" name="service_1_icon" value="{{ get_option('service_1_icon') }}">
									  	</div>
									</div>

									<div class="col-md-12">
										<h4>{{ _lang('Service 2') }}</h4>	
										<hr>	
									</div>	

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Title') }}</label>	
											<input type="text" class="form-control" name="service_2_title" value="{{ get_trans_option('service_2_title') }}">
									  	</div>
									</div>
									
									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Sub Title') }}</label>
											<input type="text" class="form-control" name="service_2_sub_title" value="{{ get_trans_option('service_2_sub_title') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Icon') }}</label>
											(<a _target="_blank" href="https://themify.me/themify-icons">{{ _lang('Suppored Icons') }}</a>)
											<input type="text" class="form-control" name="service_2_icon" value="{{ get_option('service_2_icon') }}">
									  	</div>
									</div>

									<div class="col-md-12">
										<h4>{{ _lang('Service 3') }}</h4>	
										<hr>	
									</div>	

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Title') }}</label>	
											<input type="text" class="form-control" name="service_3_title" value="{{ get_trans_option('service_3_title') }}">
									  	</div>
									</div>
									
									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Sub Title') }}</label>
											<input type="text" class="form-control" name="service_3_sub_title" value="{{ get_trans_option('service_3_sub_title') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Icon') }}</label>
											(<a _target="_blank" href="https://themify.me/themify-icons">{{ _lang('Suppored Icons') }}</a>)
											<input type="text" class="form-control" name="service_3_icon" value="{{ get_option('service_3_icon') }}">
									  	</div>
									</div>

									<div class="col-md-12">
										<h4>{{ _lang('Service 4') }}</h4>	
										<hr>	
									</div>	

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Title') }}</label>	
											<input type="text" class="form-control" name="service_4_title" value="{{ get_trans_option('service_4_title') }}">
									  	</div>
									</div>
									
									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Sub Title') }}</label>
											<input type="text" class="form-control" name="service_4_sub_title" value="{{ get_trans_option('service_4_sub_title') }}">
									  	</div>
									</div>

									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Service Icon') }}</label>
											(<a _target="_blank" href="https://themify.me/themify-icons">{{ _lang('Suppored Icons') }}</a>)
											<input type="text" class="form-control" name="service_4_icon" value="{{ get_option('service_4_icon') }}">
									  	</div>
									</div>
									
									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Changes') }}</button>
									  	</div>
									</div>
								</div>						
							</form>
					    </div>
					</div>
				</div>

				<div id="appearance" class="tab-pane">
					<div class="card">

						<div class="card-header">
							<span class="panel-title">{{ _lang('Theme Appearance') }}</span>
						</div>

						<div class="card-body">
							 <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['general_settings','store']) }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Theme Color') }}</label>				
											<input type="color" class="form-control colorpicker" name="theme_color" value="{{ get_option('theme_color','#E91E63') }}" required>
									  	</div>
									</div>
									
									<div class="col-md-6">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Navigation Color') }}</label>
											<input type="color" class="form-control colorpicker" name="navigation_color" value="{{ get_option('navigation_color','#1d2224') }}" required>
									  	</div>
									</div>

									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Custom CSS') }}</label>
											<textarea class="form-control" name="custom_css" rows="8">{{ get_option('custom_css') }}</textarea>
									  	</div>
									</div>
																			
									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Changes') }}</button>
									  	</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div id="seo" class="tab-pane">
					<div class="card">

						<div class="card-header">
							<span class="panel-title">{{ _lang('SEO Settings') }}</span>
						</div>

						<div class="card-body">
							 <form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['general_settings','store']) }}" enctype="multipart/form-data">
								{{ csrf_field() }}
								<div class="row">
									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Meta Keywords') }}</label>				
											<textarea class="form-control" name="meta_keywords" required>{{ get_option('meta_keywords') }}</textarea>
									  	</div>
									</div>
									
									<div class="col-md-12">
									  	<div class="form-group">
											<label class="control-label">{{ _lang('Meta Description') }}</label>
											<textarea class="form-control" name="meta_description" required>{{ get_option('meta_description') }}</textarea>
									  	</div>
									</div>
																			
									<div class="col-md-12">
									  	<div class="form-group">
											<button type="submit" class="btn btn-primary">{{ _lang('Save Changes') }}</button>
									  	</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				 
				
				<div id="social_links" class="tab-pane fade">
					<div class="card">
						<div class="card-header">
							<span class="panel-title">{{ _lang('Social Links') }}</span>
						</div>

					    <div class="card-body">
							<form method="post" class="settings-submit params-panel" autocomplete="off" action="{{ route('theme_option.update',['general_settings','store']) }}">
								{{ csrf_field() }}
								<div class="row">									
									<div class="col-md-8">
										<div class="row">
											<div class="col-md-12">
											  	<div class="form-group">
													<label class="control-label">{{ _lang('Facebook') }}</label>						
													<input type="text" class="form-control" name="facebook_link" value="{{ get_option('facebook_link') }}">
											 	 </div>
											</div>

											<div class="col-md-12">
											  	<div class="form-group">
													<label class="control-label">{{ _lang('Twitter') }}</label>						
													<input type="text" class="form-control" name="twitter_link" value="{{ get_option('twitter_link') }}">
											 	 </div>
											</div>

											<div class="col-md-12">
											  	<div class="form-group">
													<label class="control-label">{{ _lang('Instagram') }}</label>						
													<input type="text" class="form-control" name="instagram_link" value="{{ get_option('instagram_link') }}">
											 	 </div>
											</div>

											<div class="col-md-12">
											  	<div class="form-group">
													<label class="control-label">{{ _lang('Youtube') }}</label>
													<input type="text" class="form-control" name="youtube_link" value="{{ get_option('youtube_link') }}">
											 	 </div>
											</div>
											
											<div class="col-md-12">
											  <div class="form-group">
												<button type="submit" class="btn btn-primary">{{ _lang('Save Settings') }}</button>
											  </div>
											</div>
										</div>
									</div>
								</div>						
							</form>
					    </div>
					</div>
				</div>
				
			</div>	<!--End tab Content-->  
		</div>
	</div>
</div>
@endsection
