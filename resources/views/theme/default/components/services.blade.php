<!-- Start Shop Services Area  -->
<section class="shop-services section {{ get_option('enable_newsletter') != 1 ? 'mb-5' : '' }}">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-6 col-12">
				<!-- Start Single Service -->
				<div class="single-service">
					{!! xss_clean(get_option('service_1_icon')) !!}
					<h4>{{ get_trans_option('service_1_title') }}</h4>
					<p>{{ get_trans_option('service_1_sub_title') }}</p>
				</div>
				<!-- End Single Service -->
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<!-- Start Single Service -->
				<div class="single-service">
					{!! xss_clean(get_option('service_2_icon')) !!}
					<h4>{{ get_trans_option('service_2_title') }}</h4>
					<p>{{ get_trans_option('service_2_sub_title') }}</p>
				</div>
				<!-- End Single Service -->
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<!-- Start Single Service -->
				<div class="single-service">
					{!! xss_clean(get_option('service_3_icon')) !!}
					<h4>{{ get_trans_option('service_3_title') }}</h4>
					<p>{{ get_trans_option('service_3_sub_title') }}</p>
				</div>
				<!-- End Single Service -->
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<!-- Start Single Service -->
				<div class="single-service">
					{!! xss_clean(get_option('service_4_icon')) !!}
					<h4>{{ get_trans_option('service_4_title') }}</h4>
					<p>{{ get_trans_option('service_4_sub_title') }}</p>
				</div>
				<!-- End Single Service -->
			</div>
		</div>
	</div>
</section>
<!-- End Shop Newsletter -->

@if(get_option('enable_newsletter') == 1)
<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section">
	<div class="container">
		<div class="inner-top">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 col-12">

					@if(\Session::has('success'))
						<div class="alert alert-success mt-4">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<span>{{ session('success') }}</span>
						</div>
					@endif

					@if(\Session::has('error'))
						<div class="alert alert-danger mt-4">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<span>{{ session('error') }}</span>
						</div>
					@endif

					<!-- Start Newsletter Inner -->
					<div class="inner">
						<h4>{{ _lang('Newsletter') }}</h4>
						<p>{{ get_trans_option('Newsletter_title') }}</p>
						<form action="{{ url('/subscribe_newsletter') }}" method="post" class="newsletter-inner">
							@csrf
							<input type="email" name="email" placeholder="{{ _lang('Your email address') }}" value="{{ old('email') }}" required>
							<button class="btn">{{ _lang('Subscribe') }}</button>
						</form>
					</div>
					<!-- End Newsletter Inner -->
				</div>
			</div>
		</div>
	</div>
</section>
<!-- End Shop Newsletter -->
@endif