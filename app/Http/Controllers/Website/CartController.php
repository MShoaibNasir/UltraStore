<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Product\Product;
use App\Entity\Coupon\Coupon;
use App\Order;
use App\Utilities\CheckoutTax;
use Cart;
use Auth;

class CartController extends Controller
{

    private $theme;

    public function __construct()
    { 
        $this->theme = env('ACTIVE_THEME','default');        
        date_default_timezone_set(get_option('timezone','Asia/Dhaka'));       
    }

    public function add_to_cart(Request $request, $product_id)
    {
        $product = Product::find($product_id);
	

        if($product->product_type != 'variable_product'){
			
			//Check Stock
			if($product->manage_stock == 1){
				$item = Cart::get($product->id);
				
				$item_quantity = $item ? $item->quantity : 0;
	
				if(($item_quantity + $request->quantity) > $product->qty){
					return response()->json(['result' => false, 'message' => _lang('Sorry, No stock available !')]);
				}
				
			}
            
            $price = $product->price;
            if($product->special_price != '' || (int) $product->special_price != 0 ){
                $price = $product->special_price;
            }

            $cart = Cart::add(array(
                'id'         => $product->id,
                'name'       => $product->translation->name,
                'price'      => $price,
                'quantity'   => $request->quantity,
                'attributes' => array(),
                'associatedModel' => $product
            ));

            if( ! $request->ajax()){
                return back();
            }else{
				$view = view("theme.$this->theme.components.mini-cart")->render();
				$total_items = Cart::getTotalQuantity();
				return response()->json(['result' => true, 'data' => $view, 'total_items' => $total_items]);
            }

        }else{
            $variations = array();
            $option_values = explode('&',$request->product_option[0]);

            $index = 0;
            foreach(explode('&',$request->product_option[0]) as $product_option){
                $option_value = explode('=',$option_values[$index]);
                array_push($variations, explode('%2C',$option_value[1])[0]);
                $index++;
            }

            $variation = get_variation_price($product_id, $variations);
			
			//Check Stock
			if($product->manage_stock == 1){
				$item = Cart::get(md5(json_encode($variation['attributes'])));
				
				$item_quantity = $item ? $item->quantity : 0;
				
				if($product->qty <= ($item_quantity + 1)){
					return response()->json(['result' => false, 'message' => _lang('Sorry, No stock available !')]);
				}	
			}

            if($variation['special_price'] != '' || (int) $variation['special_price'] != 0 ){
                $price = $variation['special_price'];
            }else{
                $price = $variation['price'];
            }

            $cart = Cart::add(array(
                'id'              => md5(json_encode($variation['attributes'])),
                'name'            => $product->translation->name,
                'price'           => $price,
                'quantity'        => $request->quantity,
                'attributes'      => $variation['attributes'],
                'associatedModel' => $product
            ));


            if( ! $request->ajax()){
                return back();
            }else{
                //return view("theme.$this->theme.components.mini-cart");
				$view = view("theme.$this->theme.components.mini-cart")->render();
				$total_items = Cart::getTotalQuantity();
				return response()->json(['result' => true, 'data' => $view, 'total_items' => $total_items]);
            }
        }
        
    }

    /** Update Cart **/
    public function update_cart(Request $request){  
        $index = 0;
        foreach($request->cart_id as $id){
			$item = Cart::get($id);
			
			if($item->model->manage_stock == 1){
				$item_quantity = $item ? $item->quantity : 0;
				
				if($item->model->qty <= ($item_quantity + $request->quantity[$index])){
					return response()->json(['result' => false, 'message' => _lang('Sorry').', '.$item->name.' '._lang('not available in stock !')]);
				}
				
			}
			
            Cart::update($id, array(
                'quantity' => array(
                      'relative' => false,
                      'value' => $request->quantity[$index]
                ),
            ));
            $index++;
        }

        if(Cart::getSubTotal() < get_option('free_shipping_minimum_amount')){
            Cart::removeCartCondition(get_option('free_shipping_label'));
        }

        if( ! $request->ajax()){
           return back()->with('success',_lang('Cart Updated'));
        }else{
			$shopping_cart = view("theme.$this->theme.components.cart-body")->render();
			$mini_cart = view("theme.$this->theme.components.mini-cart")->render();
			$total_items = Cart::getTotalQuantity();
			//return response()->json(['result' => true, 'shopping_cart' => $shopping_cart, 'mini_cart' => $mini_cart]);
			return response()->json(['result' => true, 'shopping_cart' => $shopping_cart, 'mini_cart' => $mini_cart, 'total_items' => $total_items]);
        }
        
    }
	

    /** Apply Coupon Code **/
    public function apply_coupon(Request $request){  
        if($request->coupon == ''){
           return back();
        }

        $currenct_date = date('Y-m-d');
        $coupon = Coupon::where('code',$request->coupon)
                        ->where('start_date','<=',$currenct_date)
                        ->where('end_date','>=',$currenct_date)
                        ->where('is_active',1)
                        ->first();
					

        if($coupon){
			
			//Check Usages Limit
            if($coupon->usage_limit_per_coupon == $coupon->used){ 
                return back()->with('error',_lang('Coupon already reached the maximum number of used !'));   
            }
			
			//Check Usages Limit Per Customer
			if($coupon->usage_limit_per_customer > 0){
				if(! Auth::check()){
					return back()->with('error',_lang('Sorry, This Coupon code has usages restriction. Please login before apply this coupon code !'));   
				}
				
				$customer_usages_limit = Order::where('customer_id', Auth::id())
										      ->where('coupon_id', $coupon->id)
											  ->count();
							
				if($coupon->usage_limit_per_customer == $customer_usages_limit){ 
					return back()->with('error',_lang('Sorry, You have already reached the maximum number of used !'));   
				}
			}

            //Check Minimum Amount Spend
            if($coupon->minimum_spend > 0){
                if(Cart::getSubTotal() < $coupon->minimum_spend){
                    return back()->with('error',_lang('Minimum Spend Amount').' '.show_price($coupon->minimum_spend));
                }
            }

            //Check Maximum Amount Spend
            if($coupon->maximum_spend > 0){
                if(Cart::getSubTotal() > $coupon->maximum_spend){
                    return back()->with('error',_lang('Sorry, You have Spend maximum amount !'));
                }
            }

            $coupon_amount = 0;
            $general_coupon = true;

            //Check Coupons for Products
            $coupon_products = $coupon->products()->get();

            if(! $coupon_products->isEmpty()){
                $general_coupon = false;

                foreach(Cart::getContent() as $cart){
                    $row = $coupon_products->firstWhere('id',$cart->associatedModel->id);

                    if($row){
                        $coupon_amount += $cart->getPriceSumWithConditions();
                    }
                }
            }

            //Exclude Product Coupon code
            $exclude_products = $coupon->excludeProducts()->get();
            if(! $exclude_products->isEmpty()){
                $general_coupon = false;

                foreach(Cart::getContent() as $cart){
                    $row = $exclude_products->firstWhere('id',$cart->associatedModel->id);

                    if(! $row){
                        $coupon_amount += $cart->getPriceSumWithConditions();
                    }
                }
            }

            //Check Coupons for Categories
            $coupon_categories = $coupon->categories()->get();

            if(! $coupon_categories->isEmpty()){
                $general_coupon = false;

                foreach(Cart::getContent() as $cart){
                    $row = $coupon_categories->whereIn('id',$cart->associatedModel->categories->pluck('id'))->all();

                    if($row){    
                        $coupon_amount += $cart->getPriceSumWithConditions();
                    }
                }
            }

            //Check Coupons for Categories
            $exclude_categories = $coupon->excludeCategories()->get();

            if(! $exclude_categories->isEmpty()){
                $general_coupon = false;

                foreach(Cart::getContent() as $cart){
                    $row = $exclude_categories->whereIn('id',$cart->associatedModel->categories->pluck('id'))->all();

                    if(! $row){    
                        $coupon_amount += $cart->getPriceSumWithConditions();
                    }
                }
            }

            //Apply Coupon
            $coupon_value = 0; 
            if( $coupon_amount > 0 ){
                $coupon_value = $coupon->is_percent == 1 ? ($coupon->value / 100) * $coupon_amount : $coupon->value;
            }else if($general_coupon == true){
                $coupon_value = $coupon->is_percent == 1 ? ($coupon->value / 100) * Cart::getSubTotal() : $coupon->value; 
			}
			
			
            //Apply Coupon
            if($coupon_value > 0){
                
                //Remove existing Coupon
                Cart::removeConditionsByType('coupon');

                $coupon001 = new \Darryldecode\Cart\CartCondition(array(
                    'name'   => $coupon->translation->name,
                    'type'   => 'coupon',
                    'target' => 'total',
                    'value'  => '-'.$coupon_value,
                    'order' => 2,
                    'attributes' => array(
                        'coupon_id' => $coupon->id,
                    )
                ));

                Cart::condition($coupon001);

                return back()->with('success',_lang('Coupon Applied Sucessfully'));
            }else{
                return back()->with('error',_lang('You are not eligible for this coupon code !'));
            }
             
            
        }else{
            return back()->with('error',_lang('Invalid Coupon Code !'));
        }

        
    }

    /** Remove Global Coupon **/
    public function remove_coupon($name){     
        $condition = Cart::getCondition($name);
        
        if($condition->getType() == 'coupon'){
            Cart::removeCartCondition($name);
            return back()->with('success',_lang('Coupon Removed'));
        }    
    }


    /** Remove Cart By ID **/
    public function remove_cart_item(Request $request, $id){  
        \Cart::remove($id);
        $cartTotal = Cart::getSubTotal();

        if($cartTotal < get_option('free_shipping_minimum_amount')){
            Cart::removeCartCondition(get_option('free_shipping_label'));
        }

        //Remove Tax
        Cart::removeConditionsByType('tax');

        //Remove Coupon
        Cart::removeConditionsByType('coupon');

        $shipping = Cart::getConditionsByType('shipping');

        if($cartTotal > 0){
            //Apply Initial Shipping
            if(count($shipping) == 0){
                if($cartTotal >= get_option('free_shipping_minimum_amount')){ 
                    $shipping = new \Darryldecode\Cart\CartCondition(array(
                        'name'   => get_option('free_shipping_label'),
                        'type'   => 'shipping',
                        'target' => 'total',
                        'value'  => '0',
                        'order' => 1
                    ));
                    Cart::condition($shipping);
                }else{
                    $shipping = new \Darryldecode\Cart\CartCondition(array(
                        'name' => get_option('flat_rate_active') == 'Yes' ? get_option('flat_rate_label') : get_option('local_pickup_label'),
                        'type'   => 'shipping',
                        'target' => 'total',
                        'value'  => get_option('flat_rate_active') == 'Yes' ? '+'.get_option('flat_rate_cost') : '+'.get_option('local_pickup_cost'),
                        'order' => 1
                    ));
                    Cart::condition($shipping); 
                }
            }
        }else{
            Cart::removeConditionsByType('shipping');
        }

        if( ! $request->ajax()){
           return back()->with('success',_lang('Cart Updated'));
        }else{
            $shopping_cart = view("theme.$this->theme.components.cart-body")->render();
            $mini_cart = view("theme.$this->theme.components.mini-cart")->render();
            $total_items = Cart::getTotalQuantity();
			return response()->json(['result' => true, 'shopping_cart' => $shopping_cart, 'mini_cart' => $mini_cart, 'total_items' => $total_items]);
			//return response()->json(['result' => true, 'shopping_cart' => $shopping_cart, 'mini_cart' => $mini_cart]);
        }
        
    }


    /** Select Shipping Methods **/
    public function shipping_method(Request $request, $method){  

        if($method == 'free_shipping'){ 
            Cart::removeConditionsByType('shipping');
            $shipping = new \Darryldecode\Cart\CartCondition(array(
                'name'   => get_option('free_shipping_label'),
                'type'   => 'shipping',
                'target' => 'total',
                'value'  => '0',
                'order' => 1
            ));
            Cart::condition($shipping);
        }else if($method == 'flat_rate'){
            Cart::removeConditionsByType('shipping');
            $shipping = new \Darryldecode\Cart\CartCondition(array(
                'name' => get_option('flat_rate_label'),
                'type'   => 'shipping',
                'target' => 'total',
                'value'  => '+'.get_option('flat_rate_cost'),
                'order' => 1
            ));
            Cart::condition($shipping); 
        }else if($method == 'local_pickup'){
            Cart::removeConditionsByType('shipping');
            $shipping = new \Darryldecode\Cart\CartCondition(array(
                'name' => get_option('local_pickup_label'),
                'type'   => 'shipping',
                'target' => 'total',
                'value'  => '+'.get_option('local_pickup_cost'),
                'order' => 1
            ));
            Cart::condition($shipping); 
        }  

        if( ! $request->ajax()){
           return back();
        }else{
           return view("theme.$this->theme.components.cart-body");
        }
            
    }

}
