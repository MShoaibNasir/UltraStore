<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use App\Order;

class OrderUpdated
{
    use SerializesModels;

    public $order;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
