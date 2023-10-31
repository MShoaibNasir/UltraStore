<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

	const CANCELED = 'canceled';
    const COMPLETED = 'completed';
    const ON_HOLD = 'on_hold';
    const PENDING = 'pending';
    const PENDING_PAYMENT = 'pending_payment';
    const PROCESSING = 'processing';
    const REFUNDED = 'refunded';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';


    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany('App\OrderProduct');
    }

    public function coupon()
    {
        return $this->belongsTo('App\Entity\Coupon\Coupon')->withDefault();
    }

    public function taxes(){
    	return $this->belongsToMany('App\Entity\Tax\TaxRate', 'order_taxes')
                    ->as('order_tax')
                    ->withPivot('amount');
    }

    public function transaction()
    {
        return $this->hasOne('App\Transaction','order_id')->withDefault();
    }

    public function storeProducts($cartItem)
    {
        $orderProduct = $this->products()->create([
            'product_id' => $cartItem->associatedModel->id,
            'product_attributes' => serialize($cartItem->attributes->toArray()),
            'unit_price' => $cartItem->price,
            'qty' 		 => $cartItem->quantity,
            'line_total' => $cartItem->getPriceSumWithConditions(),
        ]);

    }

    public function attachTax($cartTax)
    {
        $this->taxes()->attach($cartTax->getAttributes()['tax_rate_id'], ['amount' => $cartTax->getValue()]);
    }

    public function getCreatedAtAttribute($value)
    {
        $date_format = get_date_format();
        //$time_format = get_time_format();
        return \Carbon\Carbon::parse($value)->format("$date_format");
    }

    public function getStatus()
    {
        if($this->status == $this::CANCELED){
            return '<span class="badge badge-danger">'.ucwords(str_replace("_"," ",$this->status)).'</span>';
        }else if($this->status == $this::COMPLETED){
            return '<span class="badge badge-success">'.ucwords(str_replace("_"," ",$this->status)).'</span>';
        }else if($this->status == $this::ON_HOLD){
            return '<span class="badge badge-warning">'.ucwords(str_replace("_"," ",$this->status)).'</span>';
        }else if($this->status == $this::PENDING){
            return '<span class="badge badge-danger">'.ucwords(str_replace("_"," ",$this->status)).'</span>';
        }else if($this->status == $this::PENDING_PAYMENT){
             return '<span class="badge badge-danger">'.ucwords(str_replace("_"," ",$this->status)).'</span>';
        }else if($this->status == $this::PROCESSING){
             return '<span class="badge badge-info">'.ucwords(str_replace("_"," ",$this->status)).'</span>';
        }else if($this->status == $this::REFUNDED){
             return '<span class="badge badge-danger">'.ucwords(str_replace("_"," ",$this->status)).'</span>';
        }
        
    }

    public function getPaymentStatus($html = true)
    {
        if(! $this->transaction()->exists()){
            return $html == true ? '<span class="badge badge-danger">'._lang('Pending').'</span>' : 0;
        }else{
            return $html == true ? '<span class="badge badge-success">'._lang('Completed').'</span>' : 1;
        }
        
    }

}