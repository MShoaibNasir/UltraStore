<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['install']], function () {
	
	//Webiste Routes
	Route::get('/shop', 'Website\WebsiteController@shop');
	Route::get('/product/{slug}', 'Website\WebsiteController@product');
	Route::get('/categories/{slug}', 'Website\WebsiteController@categories');
	Route::get('/brands/{slug?}', 'Website\WebsiteController@brands');
	Route::get('/tags/{slug}', 'Website\WebsiteController@tags');
	Route::get('/cart', 'Website\WebsiteController@cart');
	Route::get('/checkout', 'Website\WebsiteController@checkout');
	Route::post('/send_message', 'Website\WebsiteController@send_message');
	Route::post('/subscribe_newsletter', 'Website\WebsiteController@subscribe_newsletter');
	Route::match(['get','post'],'/sign_in', 'Website\CustomerController@sign_in');
	Route::match(['get','post'],'/sign_up', 'Website\CustomerController@sign_up');
	Route::get('/sign_out', 'Website\CustomerController@sign_out');

	//Need to login for View this page
	Route::group(['middleware' => ['verified']], function () {
		Route::get('/wish_list/{product_id?}', 'Website\WebsiteController@wish_list');
		Route::get('/remove_wishlist/{product_id?}', 'Website\WebsiteController@remove_wishlist');
		Route::get('/my_account/{page?}', 'Website\CustomerController@my_account');
		Route::get('/download_product/{product_id}', 'Website\CustomerController@download_product');
		Route::get('/order_details/{order_id}', 'Website\CustomerController@order_details');
		Route::post('/update_account', 'Website\CustomerController@update_account');
		Route::post('/update_password', 'Website\CustomerController@update_password');
		Route::match(['get','post'], '/add_new_address', 'Website\CustomerController@add_new_address');
		Route::match(['get','patch'], '/update_address/{address_id}', 'Website\CustomerController@update_address');
		Route::get('/delete_address/{address_id}', 'Website\CustomerController@delete_address');
		Route::post('comments/store', 'Website\CommentController@store')->name('comments.store');
		Route::post('reviews/store', 'Website\ReviewsController@store')->name('reviews.store');
	});


	//Apply Tax
	Route::get('/apply_tax/{shipping_state?}/{billing_state?}', 'Website\CheckoutController@apply_tax');
	Route::post('/make_order', 'Website\CheckoutController@make_order');
	Route::get('/payment/{order_id}', 'Website\CheckoutController@payment');

	//Get Variation Price
	Route::post('products/get_variation_price/{product_id}','ProductController@get_variation_price');

	//Add to Cart
	Route::post('/add_to_cart/{product_id}', 'Website\CartController@add_to_cart');
	Route::post('/update_cart', 'Website\CartController@update_cart');
	Route::post('/apply_coupon', 'Website\CartController@apply_coupon');
	Route::get('/remove_coupon/{name}', 'Website\CartController@remove_coupon');
	Route::get('/remove_cart_item/{id}', 'Website\CartController@remove_cart_item');
	Route::get('/shipping_method/{name}', 'Website\CartController@shipping_method');

	//Payment Gateways
	Route::get('gateway/paypal_payment_authorize/{paypal_order_id}/{order_id}', 'Website\GatewayController@paypal_payment_authorize');
	Route::post('gateway/stripe_payment_authorize/{order_id}', 'Website\GatewayController@stripe_payment_authorize');
	Route::post('gateway/razorpay_payment_authorize/{order_id}', 'Website\GatewayController@razorpay_payment_authorize');
	Route::get('gateway/paystack_payment_authorize/{order_id}/{reference}', 'Website\GatewayController@paystack_payment_authorize');
	Route::get('gateway/confirm_order/{type}/{order_id}', 'Website\GatewayController@confirm_order'); //This route is for manual payment

	
	Route::group(['prefix'=> 'admin'], function () {
	    Route::get('/', function(){
	    	return redirect('admin/login');
	    });
	    Auth::routes(['verify' => true]);
	});
  
	Route::get('/logout', 'Auth\LoginController@logout');
	Route::get('/{slug?}', 'Website\WebsiteController@index');
	
	Route::group(['middleware' => ['auth','verified'], 'prefix'=> 'admin'], function () {
		
		Route::get('dashboard', 'DashboardController@index')->middleware('groupPermission:admin,user,customer');
		
		//Profile Controller
		Route::get('profile/edit', 'ProfileController@edit')->middleware('groupPermission:admin,user');
		Route::post('profile/update', 'ProfileController@update')->middleware(['groupPermission:admin,user','demo']);
		Route::get('profile/change_password', 'ProfileController@change_password')->middleware('groupPermission:admin,user');
		Route::post('profile/update_password', 'ProfileController@update_password')->middleware(['groupPermission:admin,user','demo']);
		

		/** Admin Only Route **/
		Route::group(['middleware' => ['admin', 'demo']], function () {
			
			//User Management
			Route::resource('users','UserController');

			//User Roles
			Route::resource('roles','RoleController');
			
			//Permission Controller
		    Route::get('permission/control/{user_id?}', 'PermissionController@index')->name('permission.index');
			Route::post('permission/store', 'PermissionController@store')->name('permission.store');

			
			//Language Controller
			Route::resource('languages','LanguageController');	
			
			//Utility Controller
			Route::match(['get', 'post'],'general_settings/{store?}', 'UtilityController@settings')->name('settings.update_settings');
			Route::match(['get', 'post'],'theme_option/{page?}/{store?}', 'UtilityController@theme_option')->name('theme_option.update');
			Route::post('upload_logo', 'UtilityController@upload_logo')->name('settings.uplaod_logo');
			Route::get('database_backup_list', 'UtilityController@database_backup_list')->name('database_backups.list');
			Route::get('create_database_backup', 'UtilityController@create_database_backup')->name('database_backups.create');
			Route::delete('destroy_database_backup/{id}', 'UtilityController@destroy_database_backup');
			Route::get('download_database_backup/{id}', 'UtilityController@download_database_backup')->name('database_backups.download');
			Route::post('remove_cache', 'UtilityController@remove_cache')->name('settings.remove_cache');

			//Email Template
			Route::resource('email_templates','EmailTemplateController')->only([
				'index', 'show', 'edit', 'update'
			]);

			//Shipping Methods
			Route::get('shipping_methods', 'UtilityController@shipping_methods')->name('settings.shipping_methods');					
		});

        /** Dynamic Permission **/
		Route::group(['middleware' => ['permission', 'demo']], function () {
			
			Route::get('dashboard/total_sales_widget', 'DashboardController@total_sales_widget')->name('dashboard.total_sales_widget');
			Route::get('dashboard/current_day_sales_widget', 'DashboardController@current_day_sales_widget')->name('dashboard.current_day_sales_widget');
			Route::get('dashboard/pending_order_widget', 'DashboardController@pending_order_widget')->name('dashboard.pending_order_widget');
			Route::get('dashboard/total_product_widget', 'DashboardController@total_product_widget')->name('dashboard.total_product_widget');
			Route::get('dashboard/weekly_sales_widget', 'DashboardController@weekly_sales_widget')->name('dashboard.weekly_sales_widget');
			Route::get('dashboard/top_view_items_widget', 'DashboardController@top_view_items_widget')->name('dashboard.top_view_items_widget');
			Route::get('dashboard/recent_order_widget', 'DashboardController@recent_order_widget')->name('dashboard.recent_order_widget');
			
			//Media Controller
			Route::get('media/get_table_data/{type?}/{select_type?}','MediaController@get_table_data');
			Route::resource('media','MediaController')->except([
				'edit', 'update'
			]);

			//Order Controller
			Route::get('orders/get_table_data','OrderController@get_table_data');
			Route::resource('orders','OrderController')->except([
			    'create', 'store', 'edit'
			]);

			//Transaction Controller
			Route::get('transactions/get_table_data','TransactionController@get_table_data');
			Route::get('transactions','TransactionController@index')->name('transactions.index');

			//Product Controller
			Route::post('products/generate_variations','ProductController@generate_variations');
			Route::get('products/get_table_data','ProductController@get_table_data');
			Route::resource('products','ProductController');

			//Comments Controller
			Route::get('product_comments/get_table_data','CommentController@get_table_data');
			Route::get('product_comments/destroy/{id}','CommentController@destroy')->name('product_comments.destroy');
			Route::resource('product_comments','CommentController')->only([
			    'index', 'show'
			]);

			//Reviews Controller
			Route::get('product_reviews/get_table_data','ReviewsController@get_table_data');
			Route::post('product_reviews/bulk_action','ReviewsController@bulk_action')->name('product_reviews.bulk_action');
			Route::resource('product_reviews','ReviewsController')->except([
			    'create', 'store',
			]);

			//Category Controller
			Route::resource('category','CategoryController');

			//Brand Controller
			Route::resource('brands','BrandController');

			//Tag Controller
			Route::resource('tags','TagController');

			//Coupon Controller
			Route::resource('coupons','CouponController');

			//Customer Controller
			Route::resource('customers','CustomerController');

			//Currency Controller
			Route::resource('currency','CurrencyController');

			//Tax Vontroller
			Route::get('taxes/get_states/{country_id}','TaxController@get_states');
			Route::resource('taxes','TaxController');

			//Page Controller
			Route::resource('pages','PageController');

			//Navigation Controller
			Route::resource('navigations','NavigationController');
			Route::post('navigations/store_sorting','NavigationController@store_sorting');
			Route::get('navigation_items/{navigation_id}/create','NavigationItemController@create')->name('navigation_items.create');
			Route::post('navigation_items/store/{navigation_id}','NavigationItemController@store')->name('navigation_items.store');
			Route::get('navigation_items/edit/{id}','NavigationItemController@edit')->name('navigation_items.edit');
			Route::patch('navigation_items/update/{id}','NavigationItemController@update')->name('navigation_items.update');
			Route::get('navigation_items/destroy/{id}','NavigationItemController@destroy')->name('navigation_items.destroy');

			//Reports Controller
			Route::match(['get', 'post'],'reports/order_report','ReportController@order_report')->name('reports.order_report');
			Route::match(['get', 'post'],'reports/sales_report','ReportController@sales_report')->name('reports.sales_report');
			Route::match(['get', 'post'],'reports/product_sales_report','ReportController@product_sales_report')->name('reports.product_sales_report');
			Route::match(['get', 'post'],'reports/product_stock_report','ReportController@product_stock_report')->name('reports.product_stock_report');
			Route::match(['get', 'post'],'reports/coupons_report','ReportController@coupons_report')->name('reports.coupons_report');
			Route::match(['get', 'post'],'reports/tax_report','ReportController@tax_report')->name('reports.tax_report');
			Route::match(['get', 'post'],'reports/shipping_report','ReportController@shipping_report')->name('reports.shipping_report');
			Route::match(['get', 'post'],'reports/product_views_report','ReportController@product_views_report')->name('reports.product_views_report');
			
		});
	
	});

});

//Socila Login
Route::get('/login/{provider}', 'Auth\SocialController@redirect');
Route::get('/login/{provider}/callback','Auth\SocialController@callback');

//Get State By Country
Route::get('get_states/{country_id}','Website\WebsiteController@get_states');

//Search Products
Route::get('shop/search_products','Website\WebsiteController@search_products');

//Ajax Select2 Controller
Route::get('ajax/get_table_data','Select2Controller@get_table_data');

//Change Language
Route::get('select_language/{language}','UtilityController@select_language');

Route::get('installation/start', 'Install\InstallController@index');
Route::get('install/database', 'Install\InstallController@database');
Route::post('install/process_install', 'Install\InstallController@process_install');
Route::get('install/create_user', 'Install\InstallController@create_user');
Route::post('install/store_user', 'Install\InstallController@store_user');
Route::get('install/system_settings', 'Install\InstallController@system_settings');
Route::post('install/finish', 'Install\InstallController@final_touch');

//Update System
Route::get('migration/update', 'Install\UpdateController@update_migration');