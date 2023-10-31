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
						<li class="active"><a href="">{{ _lang('Contact') }}</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->


	<!-- Start Contact -->
<section id="contact-us" class="contact-us section">
	<div class="container">
			<div class="contact-head">
				<div class="row">
					<div class="col-lg-8 col-12">
						
						@if(\Session::has('success'))
							<div class="alert alert-success">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<span>{{ session('success') }}</span>
							</div>
						@endif

						@if(\Session::has('error'))
							<div class="alert alert-danger">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								<span>{{ session('error') }}</span>
							</div>
						@endif

						<div class="form-main">
							<div class="title">
								<h4>{{ _lang('Get in touch') }}</h4>
								<h3>{{ _lang('Write us a message') }}</h3>
							</div>
							<form class="form" method="post" autocomplete="off" action="{{ url('/send_message') }}">
								@csrf
								<div class="row">
									<div class="col-lg-6 col-12">
										<div class="form-group">
											<label>{{ _lang('Your Name') }}<span>*</span></label>
											<input name="name" type="text" placeholder="" required>
										</div>
									</div>
									<div class="col-lg-6 col-12">
										<div class="form-group">
											<label>{{ _lang('Your Subjects') }}<span>*</span></label>
											<input name="subject" type="text" placeholder="" required>
										</div>
									</div>
									<div class="col-lg-6 col-12">
										<div class="form-group">
											<label>{{ _lang('Your Email') }}<span>*</span></label>
											<input name="email" type="email" placeholder="" required>
										</div>	
									</div>
									<div class="col-lg-6 col-12">
										<div class="form-group">
											<label>{{ _lang('Your Phone') }}<span>*</span></label>
											<input name="phone" type="text" placeholder="" required>
										</div>	
									</div>
									<div class="col-12">
										<div class="form-group message">
											<label>{{ _lang('Your message') }}<span>*</span></label>
											<textarea name="message" placeholder="" required></textarea>
										</div>
									</div>
									<div class="col-12">
										<div class="form-group button">
											<button type="submit" class="btn">{{ _lang('Send Message') }}</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="col-lg-4 col-12">
						<div class="single-head">
							<div class="single-info">
								<i class="fa fa-phone"></i>
								<h4 class="title">{{ _lang('Call us Now') }}:</h4>
								<ul>
									<li>{{ get_option('phone') }}</li>
								</ul>
							</div>
							<div class="single-info">
								<i class="fa fa-envelope-open"></i>
								<h4 class="title">{{ _lang('Email') }}:</h4>
								<ul>
									<li><a href="mailto:{{ get_option('email') }}">{{ get_option('email') }}</a></li>
								</ul>
							</div>
							<div class="single-info">
								<i class="fa fa-location-arrow"></i>
								<h4 class="title">{{ _lang('Our Address') }}:</h4>
								<ul>
									<li>{{ get_option('address') }}</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>
<!--/ End Contact -->

@endsection

