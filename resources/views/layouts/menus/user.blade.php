@php $permissions = permission_list(); @endphp

@if (in_array('orders.index',$permissions))
	<li>
		<a href="{{ route('orders.index') }}"><i class="ti-timer"></i> <span>{{ _lang('Orders') }}</span></a>
	</li>
@endif


<li>
	<a href="javascript: void(0);"><i class="ti-package"></i><span>{{ _lang('Products') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		@if (in_array('products.index',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">{{ _lang('Products') }}</a></li>
		@endif	

		@if (in_array('category.index',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('category.index') }}">{{ _lang('Category') }}</a></li>	
		@endif

		@if (in_array('brands.index',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('brands.index') }}">{{ _lang('Brands') }}</a></li>	
		@endif

		@if (in_array('tags.index',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('tags.index') }}">{{ _lang('Tags') }}</a></li>	
		@endif
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="ti-comments"></i><span>{{ _lang('Product Discussions') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		@if (in_array('product_comments.index',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('product_comments.index') }}">{{ _lang('Comments') }}</a></li>
		@endif

		@if (in_array('product_reviews.index',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('product_reviews.index') }}">{{ _lang('Reviews') }}</a></li>
		@endif	
	</ul>
</li>

@if (in_array('coupons.index',$permissions))
	<li><a href="{{ route('coupons.index') }}"><i class="ti-ticket"></i> <span>{{ _lang('Coupons') }}</span></a></li>
@endif

@if (in_array('customers.index',$permissions))
	<li><a href="{{ route('customers.index') }}"><i class="ti-id-badge"></i> <span>{{ _lang('Customers') }}</span></a></li>
@endif

@if (in_array('transactions.index',$permissions))
	<li><a href="{{ route('transactions.index') }}"><i class="ti-credit-card"></i> <span>{{ _lang('Transactions') }}</span></a></li>
@endif

@if (in_array('media.index',$permissions))
	<li><a href="{{ route('media.index') }}"><i class="ti-camera"></i> <span>{{ _lang('Media') }}</span></a></li>
@endif

@if (in_array('pages.index',$permissions))
	<li><a href="{{ route('pages.index') }}"><i class="ti-agenda"></i> <span>{{ _lang('Pages') }}</span></a></li>
@endif

@if (in_array('navigations.index',$permissions))
	<li><a href="{{ route('navigations.index') }}"><i class="ti-menu"></i> <span>{{ _lang('Site Navigations') }}</span></a></li>
@endif

<li>
	<a href="javascript: void(0);"><i class="ti-bar-chart"></i><span>{{ _lang('Reports') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		@if (in_array('reports.order_report',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('reports.order_report') }}">{{ _lang('Order Report') }}</a></li>
		@endif
		
		@if (in_array('reports.sales_report',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('reports.sales_report') }}">{{ _lang('Sales Report') }}</a></li>
		@endif
		
		@if (in_array('reports.product_sales_report',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('reports.product_sales_report') }}">{{ _lang('Product Wise Sales') }}</a></li>
		@endif
		
		@if (in_array('reports.product_stock_report',$permissions))
		<li class="nav-item"><a class="nav-link" href="{{ route('reports.product_stock_report') }}">{{ _lang('Product Stock Report') }}</a></li>
		@endif
		
		@if (in_array('reports.coupons_report',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('reports.coupons_report') }}">{{ _lang('Coupons Report') }}</a></li>	
		@endif
		
		@if (in_array('reports.tax_report',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('reports.tax_report') }}">{{ _lang('Tax Report') }}</a></li>	
		@endif
		
		@if (in_array('reports.shipping_report',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('reports.shipping_report') }}">{{ _lang('Shipping Report') }}</a></li>
		@endif
		
		@if (in_array('reports.product_views_report',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('reports.product_views_report') }}">{{ _lang('Product Views Report') }}</a></li>	
		@endif
	</ul>
</li>

<li>
	<a href="javascript: void(0);"><i class="ti-settings"></i><span>{{ _lang('System Settings') }}</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
	<ul class="nav-second-level" aria-expanded="false">
		@if (in_array('currency.index',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('currency.index') }}">{{ _lang('Currency Manager') }}</a></li>
		@endif
	
		@if (in_array('taxes.index',$permissions))
			<li class="nav-item"><a class="nav-link" href="{{ route('taxes.index') }}">{{ _lang('Tax Settings') }}</a></li>
		@endif
	</ul>
</li>