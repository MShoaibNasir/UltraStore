<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ get_option('site_title', config('app.name')) }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
		<!-- App favicon -->
        <link rel="shortcut icon" href="{{ get_favicon() }}">

		<!-- DataTables -->
        <link href="{{ asset('public/backend/plugins/datatable/datatables.min.css') }}" rel="stylesheet" type="text/css" /> 

		<link href="{{ asset('public/backend/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
		<link href="{{ asset('public/backend/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('public/backend/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ asset('public/backend/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('public/backend/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
	    <link href="{{ asset('public/backend/plugins/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" />
        
		<!-- App Css -->
        <link rel="stylesheet" href="{{ asset('public/backend/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/themify-icons.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/metisMenu.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/slicknav.min.css') }}">

		
		<!-- Others css -->
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/typography.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/default-css.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/styles.css') }}">
		<link rel="stylesheet" href="{{ asset('public/backend/assets/css/responsive.css') }}">
		
		<!-- Modernizr -->
		<script src="{{ asset('public/backend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
        

		@if(get_option('backend_direction') == "rtl")
			<link rel="stylesheet" href="{{ asset('public/backend/assets/css/rtl/bootstrap.min.css') }}">
			<link rel="stylesheet" href="{{ asset('public/backend/assets/css/rtl/style.css?v=1.1') }}">
		@endif
		
		<script type="text/javascript">
			var _url = "{{ url('admin') }}";
		</script>
	
		@include('layouts.others.languages')
		
    </head>

    <body>  
		<!-- Main Modal -->
		<div id="main_modal" class="modal" tabindex="-1" role="dialog">
		    <div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
				    <div class="modal-header bg-primary">
						<h5 class="modal-title mt-0 text-white"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
				    </div>
				  
				    <div class="alert alert-danger d-none m-3"></div>
				    <div class="alert alert-secondary d-none m-3"></div>			  
				    <div class="modal-body overflow-hidden"></div>
				  
				</div>
		    </div>
		</div>
		
		<!-- Secondary Modal -->
		<div id="secondary_modal" class="modal" tabindex="-1" role="dialog">
		    <div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				    <div class="modal-header bg-dark">
						<h5 class="modal-title mt-0 text-white"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
				    </div>
				  
				    <div class="alert alert-danger d-none m-3"></div>
				    <div class="alert alert-secondary d-none m-3"></div>			  
				    <div class="modal-body overflow-hidden"></div>
				</div>
		    </div>
		</div>
	     
		<!-- Preloader area start -->
		<div id="preloader"></div>
		<!-- Preloader area end -->
		
		<div class="page-container">
		    <!-- sidebar menu area start -->
			<div class="sidebar-menu">
				
				<div class="sidebar-header text-center">
					<a href="{{ url('admin/dashboard') }}">
						<span class="text-white ml-1 d-inline-block">{{ get_option('company_name','TrickyCode') }}</span>
					</a>	
				</div>
				
				<div class="user-details">
					<img class="avatar" src="{{ profile_picture() }}" alt="avatar">
					<span class="text-white d-inline-block">{{ Auth::user()->name }} </span><br>
				</div>
				
				<div class="main-menu">
					<div class="menu-inner">
						<nav>
							<ul class="metismenu" id="menu">
							    <li>
							    	<a href="{{ url('admin/dashboard') }}"><i class="ti-dashboard"></i> <span>{{ _lang('Dashboard') }}</span></a>
							    </li>
								@include('layouts.menus.'.Auth::user()->user_type)
							</ul>
						</nav>
					</div>
				</div>
			</div>
			<!-- sidebar menu area end -->
		
        
			<!-- main content area start -->
			<div class="main-content">

				<!-- header area start -->
				<div class="header-area">
					<div class="row align-items-center">
						<!-- nav and search button -->
						<div class="col-md-6 col-sm-8 clearfix rtl-2">
							<div class="nav-btn float-left">
								<span></span>
								<span></span>
								<span></span>
							</div>
						</div>

						<!-- profile info & task notification -->
						<div class="col-md-6 col-sm-4 clearfix rtl-1">

							<ul class="notification-area float-right">
	                            <li>
									<div class="dropdown">
									  <a class="dropdown-toggle" type="button" id="selectLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										{{ get_language() }}
										<i class="fa fa-angle-down"></i>
									  </a>
									  <div class="dropdown-menu" aria-labelledby="selectLanguage">
										@foreach( get_language_list() as $language )
											<a class="dropdown-item" href="{{ url('select_language/'.$language) }}">{{ $language }}</a>
										@endforeach
									  </div>
									</div>
								</li>
								
								<li>
									<div class="user-profile">
										<h4 class="user-name dropdown-toggle" data-toggle="dropdown">
											<img class="avatar user-thumb" id="my-profile-img" src="{{ profile_picture() }}" alt="avatar"> {{ Auth::user()->name }} <i class="fa fa-angle-down"></i>
										</h4>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="{{ url('admin/profile/edit') }}"><i class="ti-settings text-muted mr-2"></i> {{ _lang('Profile Settings') }}</a>
											<a class="dropdown-item" href="{{ url('admin/profile/change_password') }}"><i class="ti-pencil text-muted mr-2"></i> {{ _lang('Change Password') }}</a>
											<div class="dropdown-divider mb-0"></div>
											<a class="dropdown-item" href="{{ url('logout') }}"><i class="ti-power-off text-muted mr-2"></i> {{ _lang('Logout') }}</a>
										</div>
									</div>
	                            </li>
	                            
	                        </ul>

						</div>
					</div>
				</div><!-- header area end -->
				
				
				<!-- page title area start -->
				@if(Request::is('admin/dashboard'))
				<div class="page-title-area mb-3">
					<div class="row align-items-center py-3">
						
						<div class="col-sm-12">
							<div class="breadcrumbs-area clearfix">
								<h4 class="page-title float-left">{{ _lang('Dashboard') }}</h4>
							</div>
						</div>

					</div>
				</div><!-- page title area end -->
				@endif
				
				<div class="main-content-inner {{ ! Request::is('admin/dashboard') ? 'mt-4' : '' }}">
					
					<div class="alert alert-success alert-dismissible" id="main_alert" role="alert">
						<button type="button" id="close_alert" class="close">
							<span aria-hidden="true"><i class="far fa-times-circle"></i></span>
						</button>
						<span class="msg"></span>
					</div>
                    
					@yield('content')

				</div><!--End main content Inner-->
				
			</div><!--End main content-->

		</div><!--End Page Container-->

        <!-- jQuery  -->
		<script src="{{ asset('public/backend/assets/js/vendor/jquery-3.5.1.min.js') }}"></script>
		<script src="{{ asset('public/backend/assets/js/popper.min.js') }}"></script>
		<script src="{{ asset('public/backend/assets/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('public/backend/assets/js/metisMenu.min.js') }}"></script>
		<script src="{{ asset('public/backend/assets/js/jquery.slimscroll.min.js') }}"></script>
		<script src="{{ asset('public/backend/assets/js/jquery.slicknav.min.js') }}"></script>
        
		<script src="{{ asset('public/backend/assets/js/print.js') }}"></script>
		<script src="{{ asset('public/backend/assets/js/pace.min.js') }}"></script>
		<script src="{{ asset('public/backend/assets/js/clipboard.min.js') }}"></script>
        <script src="{{ asset('public/backend/plugins/moment/moment.js') }}"></script>
		
		<!-- Datatable js -->
        <script src="{{ asset('public/backend/plugins/datatable/datatables.min.js') }}"></script>
        
		<script src="{{ asset('public/backend/plugins/dropify/js/dropify.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/select2/select2.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/tinymce/tinymce.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/parsleyjs/parsley.min.js') }}"></script>
		<script src="{{ asset('public/backend/plugins/jquery-toast-plugin/jquery.toast.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('public/backend/assets/js/scripts.js?v=1.1') }}"></script>

		<script type="text/javascript">		
		(function($) {

    		"use strict";
	
			@if(Request::is('dashboard'))
				$(".page-title").html("{{ _lang('Dashboard') }}"); 
			@else
				$(".page-title").html($(".title").html()); 
				$(".page-title").html($(".panel-title").html());
			@endif			
			
			//Show Success Message
			@if(Session::has('success'))
		       $("#main_alert > span.msg").html(" {{ session('success') }} ");
			   $("#main_alert").addClass("alert-success").removeClass("alert-danger");
			   $("#main_alert").css('display','block');
			@endif
			
			//Show Single Error Message
			@if(Session::has('error'))
			   $("#main_alert > span.msg").html(" {{ session('error') }} ");
			   $("#main_alert").addClass("alert-danger").removeClass("alert-success");
			   $("#main_alert").css('display','block');
			@endif
			
			
			@php $i = 0; @endphp

			@foreach ($errors->all() as $error)
			    @if ($loop->first)
					$("#main_alert > span.msg").html("<i class='typcn typcn-delete'></i> {{ $error }} ");
					$("#main_alert").addClass("alert-danger").removeClass("alert-success");
				@else
                    $("#main_alert > span.msg").append("<br><i class='typcn typcn-delete'></i> {{ $error }} ");					
				@endif
				
				@if ($loop->last)
					$("#main_alert").css('display','block');
				@endif
				
				@if(isset($errors->keys()[$i]))
					var name = "{{ $errors->keys()[$i] }}";
				
					$("input[name='" + name + "']").addClass('error is-invalid');
					$("select[name='" + name + "'] + span").addClass('error is-invalid');
				
					$("input[name='"+name+"'], select[name='"+name+"']").parent().append("<span class='v-error'>{{$error}}</span>");
				@endif
				@php $i++; @endphp
			
			@endforeach
			
        })(jQuery);
		
	 </script>
	 
	 <!-- Custom JS -->
	 @yield('js-script')
		
    </body>
</html>