<?php

namespace App\Entity\Coupon;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupons';
	
	public function default_lang(){
		return $this->hasMany('App\Entity\Coupon\CouponTranslation','coupon_id');
	}
	
	public function translation(){
		return $this->hasOne('App\Entity\Coupon\CouponTranslation','coupon_id')
                    ->where('locale', get_language())
                    ->withDefault([
            			'name' => isset($this->default_lang[0]) ? $this->default_lang[0]->name : '',
            		]);
	}

    public function products()
    {
        return $this->belongsToMany('App\Entity\Product\Product', 'coupon_products')
                    ->withPivot('exclude')
                    ->wherePivot('exclude', false);
    }

    public function excludeProducts()
    {
        return $this->belongsToMany('App\Entity\Product\Product', 'coupon_products')
                    ->withPivot('exclude')
                    ->wherePivot('exclude', true);
    }


    public function categories()
    {
        return $this->belongsToMany('App\Entity\Category\Category', 'coupon_categories')
                    ->withPivot('exclude')
                    ->wherePivot('exclude', false);
    }

    public function excludeCategories()
    {
        return $this->belongsToMany('App\Entity\Category\Category', 'coupon_categories')
                    ->withPivot('exclude')
                    ->wherePivot('exclude', true);
    }
	
}