<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utilities\CheckoutTax;
use App\Services\OrderService;
use App\User;
use App\CustomerAddress;
use App\Order;
use Validator;
use Cart;
use Auth;
use Hash;
use DB;

class CheckoutController extends Controller
{
  
    private $theme;

    public function __construct()
    { 
        $this->theme = env('ACTIVE_THEME','default');        
        date_default_timezone_set(get_option('timezone','Asia/Dhaka'));       
    }

    public function apply_tax(Request $request, $shipping_state, $billing_state){
    	Cart::removeConditionsByType('tax');
    	
    	if($shipping_state != '' && $billing_state != ''){
    		CheckoutTax::apply_tax($shipping_state, $billing_state);
    	}	

    	if( ! $request->ajax()){
           return back();
        }else{
           return view("theme.$this->theme.components.checkout-cart");
        }
    }

    public function make_order(Request $request, OrderService $orderService){

        if(Auth::check()){
            $validator = Validator::make($request->all(), [
                'shipping_address' => 'required',
                'billing_address'  => 'required',
            ]);
			
			if(Auth::user()->phone == null){	 
				if($request->ajax()){ 
					return response()->json(['result' => 'error','message' => _lang('You must add your phone number before placing order !')]);
				}else{
					return back()->with('error', _lang('You must add your phone number before placing order !'))->withInput();
				}           		
			}
        }else{
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email'  => $request->create_account == 1 ? 'required|email|unique:users|max:191' : 'required|email',
                'phone'  => 'required',
                'country'  => 'required',
                'state'  => 'required',
                'post_code'  => 'required',
                'address'  => 'required',
                'password' => $request->create_account == 1 ? 'required|min:6|confirmed' : '',
            ]);
        }
        

        if ($validator->fails()) {
            if($request->ajax()){ 
                return response()->json(['result' => 'error','message' => $validator->errors()->all()]);
            }else{
                return back()->withErrors($validator)->withInput();
            }           
        }

        DB::beginTransaction();

        //Create User Account
        if($request->create_account == 1){
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->user_type = 'customer';
            $user->status = 1;
            $user->profile_picture = 'default.png';
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->password = Hash::make($request->password);

            $user->save();

            //Add New Address
            $customeraddress = new CustomerAddress();
            $customeraddress->customer_id = $user->id;
            $customeraddress->name = $request->input('name');
            //$customeraddress->email = $request->input('email');
            //$customeraddress->phone = $request->input('phone');
            $customeraddress->country = $request->input('country');
            $customeraddress->state = $request->input('state');
            $customeraddress->city = $request->input('city');
            $customeraddress->address = $request->input('address');
            $customeraddress->post_code = $request->input('post_code');
            $customeraddress->is_default = 1;

            $customeraddress->save();

        }

        //Place Order
        $order = $orderService->create($request);

        //Login User
        if($request->create_account == 1){
           Auth::loginUsingId($user->id, true);
        }

        //Clear Cart Items
        Cart::clear();
        Cart::clearCartConditions();

        DB::commit();

        if( $order->id > 0 ){
            return redirect('/payment/'.encrypt($order->id));
        }

        return back()->with('error',_lang('Error Occured, Please try again !'));
    	
    }

    public function payment(Request $request, $order_id){
        $order_id = decrypt($order_id);
        $order = Order::find($order_id);
        
        if($order->status == $order::PENDING_PAYMENT){
            return view("theme.$this->theme.payment",compact('order'));
        }

        return back();  
    }

}