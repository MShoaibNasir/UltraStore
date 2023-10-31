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
						<li class="active"><a href="">{{ _lang('Sign Up') }}</a></li>
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
			<div class="col-md-6 offset-md-3">
				
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

				<div class="login_register">					
					<h3 class="section-heading">{{ _lang('Sign In') }}</h3>
					<form action="{{ url('/sign_in') }}" method="post">
						@csrf
						<input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="{{ _lang('Email') }}" required>
						<input type="password" name="password" class="form-control" placeholder="{{ _lang('Password') }}" required>
						<input type="hidden" name="redirect_to" value="{{ url()->previous() }}">

						<button type="submit" class="btn-login">{{ _lang('Login') }}</button>
							
						@if(get_option('google_login') == 'enabled')
		                    <a href="{{ url('/login/google') }}" class="btn btn-google"> {{ _lang('Continue With Google') }}</a>
						@endif

		                @if(get_option('facebook_login') == 'enabled')
		                    <a href="{{ url('/login/facebook') }}" class="btn btn-facebook"> {{ _lang('Continue With Facebook') }}</a>
		                @endif

						<div class="text-center">
							<a href="{{ route('password.request') }}" class="right_link">{{ _lang('Forget Your Password?') }}</a>
						</div>
					</form>
				</div>
				
				<div class="text-center">
					<a href="{{ url('/sign_up') }}" class="create-account-link">{{ _lang('Create an Account') }}</a>
                </div>
			</div>
		</div>
	</div>
</section>
<!--/ End Login Screen -->
		

@endsection

@section('js-script')
<script src="{{ asset('public/theme/default/js/cart.js?v=1.1') }}"></script>
@endsection