<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use DB;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array();
        if(auth()->user()->user_type != 'customer'){
            $data['total_sales'] = Order::selectraw('IFNULL(SUM(orders.total), 0) as amount')
                                        ->first()->amount;
            $data['current_day_sales'] = Order::selectraw('IFNULL(SUM(orders.total), 0) as amount')
                                              ->whereRaw("date(orders.created_at)='".date('Y-m-d')."'")
                                              ->first()->amount;   
            $data['pending_orders'] = Order::where('status', 'pending')->count();                                                            
            $data['total_products'] = DB::table('products')->count(); 

            $data['top_view_products'] = \App\Entity\Product\Product::orderBy('viewed','desc')->limit(8)->get(); 

            $data['recent_orders'] = Order::orderBy('id','desc')->limit(10)->get(); 

            return view('backend.dashboard', $data);
        }

        return redirect('/my_account');    
    }

    public function total_sales_widget(){
        // Use for Permission Only
        return redirect('/admin/dashboard');
    }

    public function current_day_sales_widget(){
        // Use for Permission Only
        return redirect('/admin/dashboard');
    }

    public function pending_order_widget(){
        // Use for Permission Only
        return redirect('/admin/dashboard');
    }

    public function total_product_widget(){
        // Use for Permission Only
        return redirect('/admin/dashboard');
    }

    public function weekly_sales_widget(){
        $date = \Carbon\Carbon::today()->subDays(7);
        $orders = Order::whereDate('created_at','>=',$date)
                        ->selectRaw("DAYNAME(created_at) as day, orders.total as amount, count(id) as order_count")
                        ->groupByRaw("DAYNAME(created_at)")
                        ->get();

        $result = array();               
        foreach($orders as $order){
            $result[$order->day] = $order;
        }                

        echo json_encode($result);
    }

    public function top_view_items_widget(){
        // Use for Permission Only
        return redirect('/admin/dashboard');
    }

    public function recent_order_widget(){
        // Use for Permission Only
        return redirect('/admin/dashboard');
    }

}
