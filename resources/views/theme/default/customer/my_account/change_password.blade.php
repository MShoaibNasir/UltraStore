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
						<li class="active"><a href="">{{ _lang('Change Password') }}</a></li>
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
						   <h4>{{ _lang('Change Password') }}</h4>
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
							    <form action="{{ url('/update_password') }}" method="post">
									@csrf

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

									<button type="submit" class="btn-login">{{ _lang('Update Password') }}</button>
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
