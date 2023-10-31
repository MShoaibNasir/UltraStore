<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'order_products';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo('App\Entity\Product\Product','product_id')->withDefault();
    }

    public function order()
    {
        return $this->belongsTo('App\Order','order_id')->withDefault();
    }

}