<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    public function getCreatedAtAttribute($value)
    {
        $date_format = get_date_format();
        //$time_format = get_time_format();
        return \Carbon\Carbon::parse($value)->format("$date_format");
    }

    public function order()
    {
        return $this->belongsTo('App\Order','order_id')->withDefault();
    }

}