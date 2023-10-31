<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity\Product\Product;
use App\Entity\Coupon\Coupon;
use App\Entity\Tax\TaxRate;
use DB;

class ReportController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        date_default_timezone_set(get_option('timezone','Asia/Dhaka'));
    }
  
    /**
     * Show Customer Order Report.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function order_report(Request $request)
    {
		if($request->isMethod('get')){
		    return view('backend.reports.order_report');	
		}else if($request->isMethod('post')){
			$data = array();
			$date1 = $request->date1;
		    $date2 = $request->date2;
		    $order_status = isset($request->order_status) ? $request->order_status : '';
		    $customer_email = isset($request->customer_email) ? $request->customer_email : '';
			
			$data['report_data'] = \App\Order::select('customer_id', 'customer_name', 'customer_email')
											   ->when($order_status, function ($query, $order_status) {
												   return $query->where('status', $order_status);
											   })
											   ->when($customer_email, function ($query, $customer_email) {
												   return $query->where('customer_email', $customer_email);
											   })
											   ->selectRaw('COUNT(DISTINCT(orders.id)) as total_orders')
											   ->join('order_products', 'orders.id', '=', 'order_products.order_id')
											   ->selectRaw('SUM(order_products.qty) as total_products')
											   ->selectRaw('IFNULL(SUM(orders.total), 0) * COUNT(DISTINCT orders.id) / COUNT(*) as total')
											   ->whereRaw("date(orders.created_at) >= '$date1' AND date(orders.created_at) <= '$date2'")
											   ->groupBy([
													'customer_id',
													'customer_name',
													'customer_email',
												])->get();
		   
		   
			$data['date1'] = $request->date1;
		    $data['date2'] = $request->date2;
		    $data['order_status'] = $request->order_status;
		    $data['customer_email'] = $request->customer_email;
			return view('backend.reports.order_report',$data);
		}
        
    }
	
	
	/**
     * Show Sales Report.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sales_report(Request $request)
    {
		if($request->isMethod('get')){
		    return view('backend.reports.sales_report');	
		}else if($request->isMethod('post')){
			$data = array();
			$date1 = $request->date1;
		    $date2 = $request->date2;
		    $order_status = isset($request->order_status) ? $request->order_status : '';
			
			$data['report_data'] = \App\Order::select('customer_id', 'customer_name', 'customer_email', 'orders.created_at')
											   ->when($order_status, function ($query, $order_status) {
												   return $query->where('status', $order_status);
											   })
											   ->selectRaw('COUNT(DISTINCT(orders.id)) as total_orders')
											   ->join('order_products', 'orders.id', '=', 'order_products.order_id')
											   ->selectRaw('SUM(order_products.qty) as total_products')
											   ->selectRaw('IFNULL(SUM(orders.sub_total), 0) * COUNT(DISTINCT orders.id) / COUNT(*) as sub_total')
											   ->selectRaw('IFNULL(SUM(orders.shipping_cost), 0) * COUNT(DISTINCT orders.id) / COUNT(*) as shipping_cost')
											   ->selectRaw('IFNULL(SUM(orders.discount), 0) * COUNT(DISTINCT orders.id) / COUNT(*) as discount')
											   ->leftJoin(DB::raw('(SELECT order_id, sum(amount) amount FROM order_taxes GROUP BY order_id) o_tax'), function ($join) {
													$join->on('orders.id', '=', 'o_tax.order_id');
												})
											   ->selectRaw('SUM(o_tax.amount) as tax')
											   ->selectRaw('IFNULL(SUM(orders.total), 0) * COUNT(DISTINCT orders.id) / COUNT(*) as total')
											   ->whereRaw("date(orders.created_at) >= '$date1' AND date(orders.created_at) <= '$date2'")
											   ->groupBy('orders.created_at')
											   ->get();
		   
		   
			$data['date1'] = $request->date1;
		    $data['date2'] = $request->date2;
		    $data['order_status'] = $request->order_status;
			return view('backend.reports.sales_report',$data);
		}
        
    }
	
	/**
     * Show Product Sales Report.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function product_sales_report(Request $request)
    {
		if($request->isMethod('get')){
		    return view('backend.reports.product_sales_report');	
		}else if($request->isMethod('post')){
			$data = array();
			$date1 = $request->date1;
		    $date2 = $request->date2;
		    $order_status = isset($request->order_status) ? $request->order_status : '';
		    $product = isset($request->product) ? $request->product : '';
			
			$data['report_data'] = Product::select('products.id')
										   ->join('order_products', 'products.id', 'order_products.product_id')
										   ->join('orders', 'order_products.order_id', '=', 'orders.id')
										   ->join('product_translations','products.id','product_translations.product_id')
										   ->when($order_status, function ($query, $order_status) {
											   return $query->where('orders.status', $order_status);
										   })
										   ->when($product, function ($query, $product) {
											   return $query->where('product_translations.name', "like", "$product%");
										   })
										   ->selectRaw('SUM(order_products.qty) as qty')
										   ->selectRaw('SUM(order_products.line_total) as total')
										   ->whereRaw("date(orders.created_at) >= '$date1' AND date(orders.created_at) <= '$date2'")
										   ->where('products.is_active', 1)
										   ->groupBy('products.id')
										   ->get();
		   
		   
			$data['date1'] = $request->date1;
		    $data['date2'] = $request->date2;
		    $data['order_status'] = $request->order_status;
		    $data['product'] = $request->product;
			return view('backend.reports.product_sales_report',$data);
		}
        
    }
	
	/**
     * Show Product Stock Report.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function product_stock_report(Request $request)
    {
		if($request->isMethod('get')){
		    return view('backend.reports.product_stock_report');	
		}else if($request->isMethod('post')){
			$data = array();
			
			$quantity_above = isset($request->quantity_above) ? $request->quantity_above : '';
		    $quantity_below = isset($request->quantity_below) ? $request->quantity_below : '';
		    $stock_availability = isset($request->stock_availability) ? $request->stock_availability : '';

			$data['report_data'] = Product::select('id', 'qty', 'in_stock')
										 ->with('translation')
										 ->when($quantity_above, function ($query, $quantity_above) {
											$query->where('manage_stock', true)
												  ->where('qty', '>', $quantity_above);
										 })
										 ->when($quantity_below, function ($query, $quantity_below) {
											$query->where('manage_stock', true)
												  ->where('qty', '<', $quantity_below);
										 })
										 ->when($stock_availability === 'in_stock', function ($query) {
											$query->where('in_stock', true);
										 })
										 ->when($stock_availability === 'out_of_stock', function ($query) {
											$query->where('in_stock', false);
										 })
										 ->get();
			
			$data['quantity_above'] = $request->quantity_above;
		    $data['quantity_below'] = $request->quantity_below;
		    $data['stock_availability'] = $request->stock_availability;
			return view('backend.reports.product_stock_report',$data);
		}
	}
	
	
	/**
     * Show Coupons Report.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function coupons_report(Request $request)
    {
		if($request->isMethod('get')){
		    return view('backend.reports.coupons_report');	
		}else if($request->isMethod('post')){
			$data = array();
			
			$date1 = $request->date1;
		    $date2 = $request->date2;
		    $order_status = isset($request->order_status) ? $request->order_status : '';
		    $coupon_code = isset($request->coupon_code) ? $request->coupon_code : '';
			
			$data['report_data'] = Coupon::select('coupons.id', 'code')
										->with('translation')
										->join('orders', 'coupons.id', '=', 'orders.coupon_id')
										->selectRaw('COUNT(*) as total_orders')
										->selectRaw('SUM(orders.discount) as total')
										->when($order_status, function ($query, $order_status) {
											   return $query->where('orders.status', $order_status);
										})
										->when($coupon_code, function ($query, $coupon_code) {
											$query->where('code', $coupon_code);
										})
										->where('is_active',1)
										->whereRaw("date(orders.created_at) >= '$date1' AND date(orders.created_at) <= '$date2'")
										->groupBy(['coupons.id', 'coupons.code'])
										->get();
			
			$data['date1'] = $request->date1;
		    $data['date2'] = $request->date2;
		    $data['order_status'] = $request->order_status;
		    $data['coupon_code'] = $request->coupon_code;
			return view('backend.reports.coupons_report',$data);
		}
	}
	
	/**
     * Show Tax Report.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function tax_report(Request $request)
    {
		if($request->isMethod('get')){
		    return view('backend.reports.tax_report');	
		}else if($request->isMethod('post')){
			$data = array();
			
			$date1 = $request->date1;
		    $date2 = $request->date2;
		    $order_status = isset($request->order_status) ? $request->order_status : '';
		    $tax_name = isset($request->tax_name) ? $request->tax_name : '';
			
			$data['report_data'] = TaxRate::select('tax_rates.id','orders.created_at')
										->join('tax_rates_translation','tax_rates.id','tax_rates_translation.tax_rate_id')
										->join('order_taxes', 'tax_rates.id', '=', 'order_taxes.tax_rate_id')
										->selectRaw('SUM(order_taxes.amount) as total')
										->join('orders', 'order_taxes.order_id', '=', 'orders.id')
										->selectRaw('MIN(orders.created_at) as start_date')
									    ->selectRaw('MAX(orders.created_at) as end_date')
										->selectRaw('COUNT(*) as total_orders')
										->when($order_status, function ($query, $order_status) {
											   return $query->where('orders.status', $order_status);
										})
										->when($tax_name, function ($query, $tax_name) {
											$query->where('tax_rates_translation.name','like', $tax_name . '%');
										})
										->whereRaw("date(orders.created_at) >= '$date1' AND date(orders.created_at) <= '$date2'")
										->groupBy('tax_rates.id')
										->get();
			
			$data['date1'] = $request->date1;
		    $data['date2'] = $request->date2;
		    $data['order_status'] = $request->order_status;
		    $data['tax_name'] = $request->tax_name;
			return view('backend.reports.tax_report',$data);
		}
	}
	
	
	/**
     * Show Shipping Report.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function shipping_report(Request $request)
    {
		if($request->isMethod('get')){
		    return view('backend.reports.shipping_report');	
		}else if($request->isMethod('post')){
			$data = array();
			
			$date1 = $request->date1;
		    $date2 = $request->date2;
		    $order_status = isset($request->order_status) ? $request->order_status : '';
		    $tax_name = isset($request->tax_name) ? $request->tax_name : '';
			
			$data['report_data'] = \App\Order::select('shipping_method')
											->selectRaw('MIN(orders.created_at) as start_date')
											->selectRaw('MAX(orders.created_at) as end_date')
											->selectRaw('COUNT(*) as total_orders')
											->selectRaw('SUM(shipping_cost) as total')
											->when($order_status, function ($query, $order_status) {
												   return $query->where('status', $order_status);
											})
											->whereRaw("date(orders.created_at) >= '$date1' AND date(orders.created_at) <= '$date2'")
											->groupBy('shipping_method')
											->get();
			
			$data['date1'] = $request->date1;
		    $data['date2'] = $request->date2;
		    $data['order_status'] = $request->order_status;
		    $data['tax_name'] = $request->tax_name;
			return view('backend.reports.shipping_report',$data);
		}
	}
	
	/**
     * Show Product Views Report.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function product_views_report(Request $request)
    {
		$data = array();
		$product_name = isset($request->product_name) ? $request->product_name : '';
		$sku = isset($request->sku) ? $request->sku : '';
			
		if($request->isMethod('get')){
			$data['report_data'] = Product::select('id', 'viewed')
										->where('viewed', '!=', 0)
										->when($product_name, function ($query, $product_name) {
											$query->whereHas('translation', function ($query) use($product_name) {
												return $query->where('name', 'like', $product_name . '%');
											});
										})
										->when($sku, function ($query, $sku) {
											$query->where('sku', $sku);
										})
										->where('is_active',1)
										->orderByDesc('viewed')
										->get();
		    return view('backend.reports.product_views_report', $data);	
		}else if($request->isMethod('post')){

			$data['report_data'] = Product::select('id', 'viewed')
										->where('viewed', '!=', 0)
										->when($product_name, function ($query, $product_name) {
											$query->whereHas('translation', function ($query) use($product_name) {
												return $query->where('name', 'like', $product_name . '%');
											});
										})
										->when($sku, function ($query, $sku) {
											$query->where('sku', $sku);
										})
										->where('is_active',1)
										->orderByDesc('viewed')
										->get();
			

		    $data['product_name'] = $request->product_name;
		    $data['sku'] = $request->sku;
			return view('backend.reports.product_views_report',$data);
		}
	}


}
