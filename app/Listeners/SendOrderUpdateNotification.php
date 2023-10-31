<?php

namespace App\Listeners;

use App\Events\OrderUpdated;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneralMail;
use App\EmailTemplate;
use App\Utilities\Overrider;

class SendOrderUpdateNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        Overrider::load("Settings");
    }

    /**
     * Handle the event.
     *
     * @param  OrderUpdated  $event
     * @return void
     */
    public function handle(OrderUpdated $event)
    {
        $order = $event->order;

        //Replace paremeter
        $replace = array(
            '{name}'              => $order->customer_name,
            '{order_id}'          => $order->id,
            '{order_status}'      => $order->getStatus(),
            '{payment_method}'    => str_replace('_', ' ', $order->payment_method),
            '{payment_status}'    => $order->getPaymentStatus(),
        );
        
        
        //Send Welcome email
        if($order->status == 'canceled'){
            $template = EmailTemplate::where('name','order_canceled')->first();
        }else if($order->status == 'completed'){
            $template = EmailTemplate::where('name','order_completed')->first();
        }else if($order->status == 'on_hold'){
            $template = EmailTemplate::where('name','order_on_hold')->first();
        }else if($order->status == 'processing'){
            $template = EmailTemplate::where('name','order_processing')->first();
        }else if($order->status == 'refunded'){
            $template = EmailTemplate::where('name','order_refunded')->first();
        }

        $template->body = process_string($replace, $template->body);
        
        try{
            Mail::to($order->customer_email)->send(new GeneralMail($template));
        }catch (\Exception $e) {
             //Nothing
        }
    }
}
