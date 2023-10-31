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
						<li class="active"><a href="">{{ _lang('My Account Details') }}</a></li>
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
						   <h4>{{ _lang('My Account Details') }}</h4>
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
							    <form action="{{ url('/update_account') }}" method="post">
									@csrf
									<input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" placeholder="{{ _lang('Name') }}">
									
									@if($errors->has('name'))
										<div class="invalid-feedback">
								          {{ $errors->first('name') }}
								        </div>
							        @endif

									<input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" placeholder="{{ _lang('Email') }}">

									@if($errors->has('email'))
										<div class="invalid-feedback">
								          {{ $errors->first('email') }}
								        </div>
							        @endif

									<input type="text" name="phone"  value="{{ Auth::user()->phone }}" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" placeholder="{{ _lang('Phone') }}">

									@if($errors->has('phone'))
										<div class="invalid-feedback">
								          {{ $errors->first('phone') }}
								        </div>
							        @endif

									<button type="submit" class="btn-login">{{ _lang('Update Details') }}</button>
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