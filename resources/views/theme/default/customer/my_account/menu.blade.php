<ul class="nav nav-tabs flex-column" role="tablist">
	<li class="nav-item">
	   <a class="nav-link {{ $page == 'overview' ? 'active' : '' }}" href="{{ url('/my_account/overview') }}"><i class="ti-user"></i>{{ _lang('Overview') }}</a>
	</li>
	<li class="nav-item">
	   <a class="nav-link {{ $page == 'orders' ? 'active' : '' }}" href="{{ url('/my_account/orders') }}"><i class="ti-shopping-cart-full"></i>{{ _lang('My Orders') }}</a>
	</li>
	<li class="nav-item">
	   <a class="nav-link {{ $page == 'downloads' ? 'active' : '' }}" href="{{ url('/my_account/downloads') }}"><i class="ti-download"></i>{{ _lang('My Downloads') }}</a>
	</li>
	<li class="nav-item">
	   <a class="nav-link {{ $page == 'reviews' ? 'active' : '' }}" href="{{ url('/my_account/reviews') }}"><i class="ti-star"></i>{{ _lang('My Reviews') }}</a>
	</li>
	<li class="nav-item">
	   <a class="nav-link {{ $page == 'addresses' ? 'active' : '' }}" href="{{ url('/my_account/addresses') }}"><i class="ti-location-pin"></i>{{ _lang('My Addresses') }}</a>
	</li>
	<li class="nav-item">
	   <a class="nav-link {{ $page == 'account_details' ? 'active' : '' }}" href="{{ url('/my_account/account_details') }}"><i class="ti-view-list-alt"></i>{{ _lang('Account Details') }}</a>
	</li>
	<li class="nav-item">
	   <a class="nav-link {{ $page == 'change_password' ? 'active' : '' }}" href="{{ url('/my_account/change_password') }}"><i class="ti-exchange-vertical"></i>{{ _lang('Change Password') }}</a>
	</li>
	<li class="nav-item">
	   <a class="nav-link" href="{{ url('/logout') }}"><i class="ti-power-off"></i>{{ _lang('Logout') }}</a>
	</li>
</ul>