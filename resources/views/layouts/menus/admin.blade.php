<li>
	<a href="{{ route('orders.index') }}"><i class="ti-timer"></i> <span>{{ _lang('Orders') }}</span></a>
</li>

<li>
	<a href="javascript: void(0);"><i class="ti-package"></i><span>{{ _lang('Products') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">{{ _lang('Products') }}</a></li>	
		<li class="nav-item"><a class="nav-link" href="{{ route('category.index') }}">{{ _lang('Category') }}</a></li>	
		<li class="nav-item"><a class="nav-link" href="{{ route('brands.index') }}">{{ _lang('Brands') }}</a></li>	
		<li class="nav-item"><a class="nav-link" href="{{ route('tags.index') }}">{{ _lang('Tags') }}</a></li>	
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="ti-comments"></i><span>{{ _lang('Product Discussions') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('product_comments.index') }}">{{ _lang('Comments') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('product_reviews.index') }}">{{ _lang('Reviews') }}</a></li>			
	</ul>
</li>

<li><a href="{{ route('coupons.index') }}"><i class="ti-ticket"></i> <span>{{ _lang('Coupons') }}</span></a></li>

<li><a href="{{ route('customers.index') }}"><i class="ti-id-badge"></i> <span>{{ _lang('Customers') }}</span></a></li>

<li><a href="{{ route('transactions.index') }}"><i class="ti-credit-card"></i> <span>{{ _lang('Transactions') }}</span></a></li>

<li><a href="{{ route('media.index') }}"><i class="ti-camera"></i> <span>{{ _lang('Media') }}</span></a></li>

<li><a href="{{ route('pages.index') }}"><i class="ti-agenda"></i> <span>{{ _lang('Pages') }}</span></a></li>

<li><a href="{{ route('navigations.index') }}"><i class="ti-menu"></i> <span>{{ _lang('Site Navigations') }}</span></a></li>

<li>
	<a href="javascript: void(0);"><i class="ti-user"></i><span>{{ _lang('User Management') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">{{ _lang('All Users') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('roles.index') }}">{{ _lang('User Roles') }}</a></li>		
		<li class="nav-item"><a class="nav-link" href="{{ route('permission.index') }}">{{ _lang('Access Control') }}</a></li>		
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="ti-world"></i><span>{{ _lang('Languages') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('languages.index') }}">{{ _lang('All Language') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('languages.create') }}">{{ _lang('Add New') }}</a></li>		
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="ti-desktop"></i><span>{{ _lang('Website Settings') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('theme_option.update','theme_settings') }}">{{ _lang('Theme Settings') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('theme_option.update','home_page_settings') }}">{{ _lang('Home Page Settings') }}</a></li>	
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="ti-bar-chart"></i><span>{{ _lang('Reports') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.order_report') }}">{{ _lang('Order Report') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.sales_report') }}">{{ _lang('Sales Report') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.product_sales_report') }}">{{ _lang('Product Wise Sales') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.product_stock_report') }}">{{ _lang('Product Stock Report') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.coupons_report') }}">{{ _lang('Coupons Report') }}</a></li>	
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.tax_report') }}">{{ _lang('Tax Report') }}</a></li>	
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.shipping_report') }}">{{ _lang('Shipping Report') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.product_views_report') }}">{{ _lang('Product Views Report') }}</a></li>	
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="ti-settings"></i><span>{{ _lang('System Settings') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		<li class="nav-item"><a class="nav-link" href="{{ route('settings.update_settings') }}">{{ _lang('General Settings') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('currency.index') }}">{{ _lang('Currency Manager') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('settings.shipping_methods') }}">{{ _lang('Shipping Methods') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('taxes.index') }}">{{ _lang('Tax Settings') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('email_templates.index') }}">{{ _lang('Email Templates') }}</a></li>
		<li class="nav-item"><a class="nav-link" href="{{ route('database_backups.list') }}">{{ _lang('Database Backup') }}</a></li>	
	</ul>
</li>