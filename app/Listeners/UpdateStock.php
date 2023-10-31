<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Order;

class UpdateStock
{

    /**
     * Handle the event.
     *
     * @param  OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        $order = $event->order;
        $this->reduceStock($order);
    }

    public function reduceStock(Order $order)
    {
        $this->manageStock($order, function ($orderItem) {
            $orderItem->product->decrement('qty', $orderItem->qty);

            if ($orderItem->product->fresh()->qty === 0) {
                $orderItem->product->outOfStock();
            }
        });
    }

    private function manageStock(Order $order, $callback)
    {
        $order->products->filter(function ($orderItem) {
            return $orderItem->product->manage_stock;
        })->each($callback);
    }
}
