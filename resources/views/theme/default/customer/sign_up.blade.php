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
						<li class="active"><a href="">{{ _lang('Sign In') }}</a></li>
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
			<div class="col-lg-6 offset-3">
				
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
					<h3 class="section-heading">{{ _lang('Sign Up') }}</h3>
					<form action="{{ url('/sign_up') }}" method="post">
						@csrf
						<input type="text" name="name" value="{{ old('name') }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="{{ _lang('Name') }}">
						
						@if($errors->has('name'))
							<div class="invalid-feedback">
					          {{ $errors->first('name') }}
					        </div>
				        @endif

						<input type="email" name="email" value="{{ old('email') }}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="{{ _lang('Email') }}">

						@if($errors->has('email'))
							<div class="invalid-feedback">
					          {{ $errors->first('email') }}
					        </div>
				        @endif

						<input type="text" name="phone"  value="{{ old('phone') }}" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" placeholder="{{ _lang('Phone') }}">

						@if($errors->has('phone'))
							<div class="invalid-feedback">
					          {{ $errors->first('phone') }}
					        </div>
				        @endif

						<input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="{{ _lang('Password') }}">

						@if($errors->has('password'))
							<div class="invalid-feedback">
					          {{ $errors->first('password') }}
					        </div>
				        @endif

						<input type="password" name="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" placeholder="{{ _lang('Password Confrimation') }}">

						@if($errors->has('password_confirmation'))
							<div class="invalid-feedback">
					          {{ $errors->first('password_confirmation') }}
					        </div>
				        @endif

						<button type="submit" class="btn-login">{{ _lang('Sign Up') }}</button>

						<div class="text-center">
							<a href="{{ url('sign_in') }}" class="right_link">{{ _lang('Already have an account?') }}</a>
						</div>
					</form>
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