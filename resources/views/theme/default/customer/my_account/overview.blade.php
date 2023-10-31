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
						<li class="active"><a href="">{{ _lang('My Account') }}</a></li>
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
						   <h4>{{ _lang('Account Information') }}</h4>
						</div>
						<div class="card-body">
						   <div class="form-group"><i class="fa fa-user"></i> {{ _lang('Name') }}: <strong>{{ Auth::user()->name }}</strong></div>
						   <div class="form-group"><i class="fa fa-envelope"></i> {{ _lang('Email') }}: <strong>{{ Auth::user()->email }}</strong></div>
						   <div class="form-group"><i class="fa fa-phone"></i> {{ _lang('Phone') }}: <strong>{{ Auth::user()->phone }}</strong></div>
						</div>
					</div>
				</div>
		   </div>
		</div>
	</div>
</section>
<!--/ End Login Screen -->
		

@endsection
