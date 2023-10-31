<?php

namespace App\Services;

use App\Order;
use App\Entity\Coupon\Coupon;
use App\CustomerAddress;
use Cart;
use Auth;

class OrderService
{
    public function create($request)
    {
        return tap($this->store($request), function ($order) {
            $this->storeOrderProducts($order);
            $this->attachTaxes($order);
            $this->incrementCouponUsage($order);
        });
    }


    private function store($request)
    {
        $shipping_method = '';
        $shipping_cost = 0;
        $coupon_id  = null;
        $discount  = 0;
        $auth = false;

        $cartConditions = Cart::getConditions();
        foreach($cartConditions as $condition){
            if($condition->getType() == 'shipping'){
                $shipping_method = $condition->getName();
                $shipping_cost = str_replace(array("+","-"),"",$condition->getValue());
            }else if($condition->getType() == 'coupon'){
                $coupon_id  = $condition->getAttributes()['coupon_id'];
                $discount = str_replace(array("+","-"),"",$condition->getValue());
            }
        }

        if(Auth::check()){
            $auth = true;

            $shipping_address = CustomerAddress::where('id', $request->shipping_address)
                                               ->where('customer_id', Auth::id())
                                               ->first();

            $billing_address = CustomerAddress::where('id', $request->billing_address)
                                              ->where('customer_id', Auth::id())
                                              ->first();                                   
        }

        return Order::create([
            'customer_id' => auth()->id(),
            'customer_name' => $auth == false ? $request->name : Auth::user()->name,
            'customer_email' => $auth == false ? $request->email : Auth::user()->email,
            'customer_phone' => $auth == false ? $request->phone : Auth::user()->phone,

            'billing_name' => $auth == false ? $request->name : $shipping_address->name,
            'billing_city' => $auth == false ? $request->city : $shipping_address->city,
            'billing_state' => $auth == false ? $request->state : $shipping_address->state,
            'billing_post_code' => $auth == false ? $request->post_code : $shipping_address->post_code,
            'billing_country' => $auth == false ? $request->country : $shipping_address->country,
            'billing_address' => $auth == false ? $request->address : $shipping_address->address,

            'shipping_name' => $auth == false ? $request->name : $billing_address->name,
            'shipping_city' => $auth == false ? $request->city : $billing_address->city,
            'shipping_state' => $auth == false ? $request->state : $billing_address->state,
            'shipping_post_code' => $auth == false ? $request->post_code : $billing_address->post_code,
            'shipping_country' => $auth == false ? $request->country : $billing_address->country,
            'shipping_address' => $auth == false ? $request->address : $billing_address->address,
            
            'sub_total' => Cart::getSubTotal(),
            'shipping_method' => $shipping_method,
            'shipping_cost' => $shipping_cost,
            'coupon_id' => $coupon_id,
            'discount' => $discount,
            'total' => Cart::getTotal(),
            'payment_method' => null,
            'currency' => session('currency') =='' ? currency() : session('currency'),
            'currency_rate' => \Cache::get('display_currency_rate'),
            'locale' => get_language(),
            'status' => Order::PENDING_PAYMENT,
            'note' => $request->order_note,
        ]);
    }

    private function storeOrderProducts(Order $order)
    {
        Cart::getContent()->each(function ($cartItem) use ($order) {
            $order->storeProducts($cartItem);
        });
    }


    private function incrementCouponUsage(Order $order)
    {
        if($order->coupon_id != null){
            $coupon = Coupon::find($order->coupon_id);
            $coupon->increment('used');
        }
    }

    private function attachTaxes(Order $order)
    {
        $taxes = Cart::getConditionsByType('tax');
        $taxes->each(function ($cartTax) use ($order) {
            $order->attachTax($cartTax);
        });
    }

}
