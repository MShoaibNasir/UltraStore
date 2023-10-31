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
						<li class="active"><a href="">{{ _lang('My Reviews') }}</a></li>
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
						   <h4>{{ _lang('My Reviews') }}</h4>
						</div>
						<div class="card-body">
						   
						</div>
					</div>
				</div>
		   </div>
		</div>
	</div>
</section>
<!--/ End Login Screen -->
		

@endsection
