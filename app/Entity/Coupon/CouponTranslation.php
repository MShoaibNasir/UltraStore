<?php

namespace App\Entity\Coupon;

use Illuminate\Database\Eloquent\Model;

class CouponTranslation extends Model
{
	
	protected $fillable = ['name'];
	
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupon_translations';
	
	protected static function booted()
    {
        static::creating(function ($translation) {
            $translation->locale = get_language();
        });
    }
}