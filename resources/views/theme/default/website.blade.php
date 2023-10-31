<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Title Tag  -->
    <title>{{ isset($seo_title) ? $seo_title : get_option('site_title', config('app.name')) }}</title>

    <meta name="keywords" content="{{ isset($meta_keywords) ? $meta_keywords : get_option('meta_keywords') }}"/>
    <meta name="description" content="{{ isset($meta_description) ? $meta_description : get_option('meta_description') }}"/>

	<!-- Favicon -->
	<link rel="icon" type="image/png" href="{{ get_favicon() }}">

	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
	
	<!-- StyleSheet -->
	
	<!-- Bootstrap -->
	<link rel="stylesheet" href="{{ asset('public/theme/default/css/bootstrap.css') }}">
	<!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('public/theme/default/css/magnific-popup.min.css') }}">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/theme/default/css/font-awesome.css') }}">
	<!-- Fancybox -->
	<link rel="stylesheet" href="{{ asset('public/theme/default/css/jquery.fancybox.min.css') }}">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="{{ asset('public/theme/default/css/themify-icons.css') }}">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="{{ asset('public/theme/default/css/niceselect.css') }}">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('public/theme/default/css/animate.css') }}">
	<!-- Flex Slider CSS -->
    <link rel="stylesheet" href="{{ asset('public/theme/default/css/flex-slider.min.css') }}">
    <!-- Jquery Ui -->
    <link rel="stylesheet" href="{{ asset('public/theme/default/css/jquery-ui.css') }}">
	<!-- Owl Carousel -->
    <link rel="stylesheet" href="{{ asset('public/theme/default/css/owl-carousel.css') }}">
	<!-- Slicknav -->
    <link rel="stylesheet" href="{{ asset('public/theme/default/css/slicknav.min.css') }}">

    <link href="{{ asset('public/backend/plugins/jquery-toast-plugin/jquery.toast.min.css') }}" rel="stylesheet" />
	
	<link rel="stylesheet" href="{{ asset('public/theme/default/css/reset.css') }}">
	<link rel="stylesheet" href="{{ asset('public/theme/default/style.css?v=1.1') }}">
    <link rel="stylesheet" href="{{ asset('public/theme/default/css/responsive.css?v=1.1') }}">  

    @include('theme.default.components.custom_styles') 
	@include('layouts.others.languages')

    <script type="text/javascript">
    	var _url = "{{ url('') }}";
    </script>
    
</head>
<body class="js">
	<!-- Preloader -->
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	<!-- End Preloader -->	
	
	@if(\Session::has('checkout_error'))
		<div class="alert alert-danger rounded-0">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<p class="text-center m-0 text-white">{{ session('checkout_error') }}</p>
		</div>
	@endif
	
	<!-- Header -->
	<header class="header shop">
		<!-- Topbar -->
		<div class="topbar">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-12 col-12">
						<!-- Top Left -->
						<div class="top-left">
							<ul class="list-main">
								<li><i class="ti-headphone-alt"></i> {{ get_option('phone') }}</li>
								<li><i class="ti-email"></i> {{ get_option('email') }}</li>
							</ul>
						</div>
						<!--/ End Top Left -->
					</div>
					<div class="col-lg-7 col-md-12 col-12">
						<!-- Top Right -->
						<div class="right-content">
							<ul class="list-main">
								<li>
									<div class="dropdown show">
									  <a class="dropdown-toggle" href="#" role="button" id="languageSwitcher" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <i class="ti-world"></i>  
									    {{ session('language') =='' ? get_option('language') : session('language') }}
									  </a>

									  <div class="dropdown-menu" aria-labelledby="languageSwitcher">
	
									    @foreach(get_language_list() as $language)
											<a class="dropdown-item" href="{{ url('/') }}?language={{ $language }}">{{ $language }}</a>
										@endforeach
									  </div>
									</div>
								</li>
								<li>
									<div class="dropdown show">
									  <a class="dropdown-toggle" href="#" role="button" id="currencySwitcher" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									    <i class="ti-credit-card"></i>
									    {{ session('currency') =='' ? currency() : session('currency') }}
									  </a>

									  <div class="dropdown-menu" aria-labelledby="currencySwitcher">
									  	@foreach(\App\Currency::where('status',1)->get() as $currency)
									    	<a class="dropdown-item" href="?currency={{ $currency->name }}">{{ $currency->name }}</a>
									    @endforeach
									  </div>
									</div>
								</li>
								
								@if(! Auth::check())
									<li><i class="ti-lock"></i><a href="{{ url('/sign_in') }}">{{ _lang('Login') }}</a></li>
								@else
									<li><i class="ti-user"></i> <a href="{{ url('/my_account') }}">{{ _lang('My account') }}</a></li>
									<li><i class="ti-power-off"></i><a href="{{ url('/sign_out') }}">{{ _lang('Logout') }}</a></li>
								@endif
							</ul>
						</div>
						<!-- End Top Right -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Topbar -->
		<div class="middle-inner">
			<div class="container">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-12">
						<!-- Logo -->
						<div class="logo">
							<a href="{{ url('') }}"><img src="{{ get_logo() }}" alt="logo"></a>
						</div>
						<!--/ End Logo -->				

						<!-- Search Form -->
						<div class="search-top">
							<div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
							<!-- Search Form -->
							<div class="search-top">
								<form class="search-form" action="{{ url('/shop') }}">
									<input type="text" class="search-products" placeholder="{{ _lang('Search here') }}..." name="search">
									<button value="search" type="submit"><i class="ti-search"></i></button>
								</form>
							</div>
							<!--/ End Search Form -->
						</div>
						<!--/ End Search Form -->
						
						<div class="mobile-nav"></div>
						
					</div>
					<div class="col-lg-8 col-md-7 col-12">
						<div class="search-bar-top">
							<form action="{{ url('/shop') }}">			
								<div class="search-bar">
									@php $search_category = isset($_GET['category']) ? $_GET['category'] : ''; @endphp
									<select class="nice-select" name="category" id="search-category">
										<option value="all">{{ _lang('All') }}</option>
										@foreach(App\Entity\Category\Category::where('parent_id',null)->get() as $category)
											<option value="{{ $category->slug }}" {{ $search_category == $category->slug ? 'selected' : ''  }}>{{ $category->translation->name }}</option>
										@endforeach
									</select>
								
									<input name="search" class="search-products" placeholder="{{ _lang('Search Products') }}" type="search">
									<button class="btnn"><i class="ti-search"></i></button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-lg-2 col-md-3 col-12">
						<div class="right-bar">

							<div class="sinlge-bar">
								<a href="{{ url('wish_list') }}" class="single-icon">
									<i class="fa fa-heart-o" aria-hidden="true"></i>
									<span class="total-count" id="wishlist-count">{{ auth()->check() ? auth()->user()->wishlist->count() : 0 }}</span>
								</a>
							</div>

							<div class="sinlge-bar shopping" id="mini-cart">
								@include('theme.default.components.mini-cart')
							</div>

						</div>
					</div>
					
					<div id="mobile-cart">
						<a href="{{ url('/cart') }}" class="single-icon"><i class="ti-shopping-cart-full"></i> 
							<span class="total-count">{{ \Cart::getTotalQuantity() }}</span>
						</a>
					</div>
					
				</div>
			</div>
		</div>
		<!-- Header Inner -->
		<div class="header-inner">
			<div class="container">
				<div class="cat-nav-head">
					<div class="row">
						@if(Request::is('/'))
						<div class="col-lg-3">
							<div class="all-category">
								<h3 class="cat-heading">
									<i class="fa fa-bars" aria-hidden="true"></i>{{ _lang('CATEGORIES') }}
								</h3>

								{!! xss_clean(show_navigation(get_option('category_menu'), 'main-category', 'sub-category', 'sub-category','right')) !!}
							</div>
						</div>
						@endif

						<div class="{{ Request::is('/') ? 'col-lg-9 col-12' : 'col-lg-12' }}">
							<div class="menu-area">
								<!-- Main Menu -->
								<nav class="navbar navbar-expand-lg">
									<div class="navbar-collapse">	
										<div class="nav-inner">	
											{!! xss_clean(show_navigation(get_option('primary_menu'), 'nav main-menu menu navbar-nav', 'dropdown', 'dropdown sub-dropdown')) !!}
										</div>
									</div>
								</nav>
								<!--/ End Main Menu -->	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--/ End Header Inner -->
	</header>
	<!--/ End Header -->
	
	@yield('content')	

	<!-- Quick View Shop -->
	<div class="modal fade" id="quickShop" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
				</div>
				<div class="modal-body">


				</div>
			</div>
		</div>
	</div>
	<!-- Quick View Shop end -->
	
	<!-- Start Footer Area -->
	<footer class="footer">
		<!-- Footer Top -->
		<div class="footer-top section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
							<div class="logo">
								<a href="{{ url('') }}"><h4>{{ get_option('site_title') }}</h4></a>
							</div>

							<p class="text">{!! xss_clean(get_trans_option('footer_about_us')) !!}</p>
							
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>{{ get_trans_option('footer_menu_1_title') }}</h4>
							{!! xss_clean(show_navigation(get_option('footer_menu_1'))) !!}
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>{{ get_trans_option('footer_menu_2_title') }}</h4>
							{!! xss_clean(show_navigation(get_option('footer_menu_2'))) !!}
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>{{ _lang('My Account') }}</h4>
							<!-- Single Widget -->
							<ul>
								<li><a href="{{ url('/my_account/overview') }}">{{ _lang('Account Overview') }}</a></li>
								<li><a href="{{ url('/my_account/orders') }}">{{ _lang('My Orders') }}</a></li>
								<li><a href="{{ url('/my_account/downloads') }}">{{ _lang('My Downloads') }}</a></li>
								<li><a href="{{ url('/my_account/reviews') }}">{{ _lang('My Reviews') }}</a></li>
								@auth
									<li><a href="{{ url('/logout') }}">{{ _lang('Logout') }}</a></li>
								@endauth
							</ul>
							<!-- End Single Widget -->
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		<div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>{!! xss_clean(get_trans_option('copyright_text')) !!}</p>
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="right">
								<img src="{{ get_option('payment_method_image') != '' ? asset('public/uploads/media/'.get_option('payment_method_image')) : asset('public/theme/default/images/payments.png') }}" alt="#">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- /End Footer Area -->
 
	<!-- Jquery -->
    <script src="{{ asset('public/theme/default/js/jquery.min.js') }}"></script>

    <script src="{{ asset('public/theme/default/js/jquery-migrate-3.0.0.js') }}"></script>

	<script src="{{ asset('public/theme/default/js/jquery-ui.min.js') }}"></script>
	<!-- Popper JS -->
	<script src="{{ asset('public/theme/default/js/popper.min.js') }}"></script>
	<!-- Bootstrap JS -->
	<script src="{{ asset('public/theme/default/js/bootstrap.min.js') }}"></script>
	<!-- Slicknav JS -->
	<script src="{{ asset('public/theme/default/js/slicknav.min.js') }}"></script>
	<!-- Owl Carousel JS -->
	<script src="{{ asset('public/theme/default/js/owl-carousel.js') }}"></script>
	<!-- Magnific Popup JS -->
	<script src="{{ asset('public/theme/default/js/magnific-popup.js') }}"></script>
	<!-- Waypoints JS -->
	<script src="{{ asset('public/theme/default/js/waypoints.min.js') }}"></script>
	<!-- Countdown JS -->
	<script src="{{ asset('public/theme/default/js/finalcountdown.min.js') }}"></script>
	<!-- Nice Select JS -->
	<script src="{{ asset('public/theme/default/js/nicesellect.js') }}"></script>
	<!-- Flex Slider JS -->
	<script src="{{ asset('public/theme/default/js/flex-slider.js') }}"></script>
	<!-- ScrollUp JS -->
	<script src="{{ asset('public/theme/default/js/scrollup.js') }}"></script>
	<!-- Onepage Nav JS -->
	<script src="{{ asset('public/theme/default/js/onepage-nav.min.js') }}"></script>
	<!-- Easing JS -->
	<script src="{{ asset('public/theme/default/js/easing.js') }}"></script>

	<script src="{{ asset('public/backend/plugins/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
	
	<script src="{{ asset('public/theme/default/js/typeahead.bundle.js') }}"></script>

	<script src="{{ asset('public/backend/assets/js/print.js') }}"></script>
	
	<!-- Active JS -->
	<script src="{{ asset('public/theme/default/js/active.js?v=1.2') }}"></script>

	<!-- Custom JS -->
	@yield('js-script')
</body>
</html>