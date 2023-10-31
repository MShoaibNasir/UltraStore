<?php

namespace App\Utilities;

use \App\Entity\Tax\Tax;
use \App\CustomerAddress;
use Cart;

class CheckoutTax{

    public static function apply_tax($shipping_address_id, $billing_address_id){
        
        $shipping_address = CustomerAddress::find($shipping_address_id);
        $billing_address = CustomerAddress::find($billing_address_id);
        
    	$taxes = array();

        if(Cart::getSubTotal() > 0){
        	foreach(Cart::getContent() as $cart){
                $tax_class = $cart->associatedModel->taxClass;

                if($tax_class->id){
                	if(! isset($tax[$tax_class->id])){
    					$taxes[$tax_class->id] = 0;
                	}

                	$taxes[$tax_class->id] = $taxes[$tax_class->id] + $cart->getPriceSumWithConditions();
                }
            }

            foreach($taxes as $tax_id => $amount){
            	$tax = Tax::find($tax_id);
            	foreach($tax->tax_rates as $tax_rate){
            	    $user_country = $tax->based_on == 'shipping_address' ? $shipping_address->country : $billing_address->country;
                    $user_state = $tax->based_on == 'shipping_address' ? $shipping_address->state : $billing_address->state;
                    
                    //Ignore Tax
                    if($user_country != $tax_rate->country){
                         continue;
                    }
                    
                    //Ignore Tax
                    if($tax_rate->state != '*' && $tax_rate->state != $user_state){
                        continue;
                    }
                  
            		$tax_value = ($tax_rate->rate / 100) * $amount;
            		//Init Tax
            		$tax_condition = new \Darryldecode\Cart\CartCondition(array(
    				    'name' => $tax_rate->translation->name,
    				    'type' => 'tax',
    				    'target' => 'total',
    				    'value' => $tax_value,
                        'attributes' => array(
                            'tax_rate_id' => $tax_rate->id,
                        )
    				));

    				Cart::condition($tax_condition);
            	}
            }
        }

    }

}