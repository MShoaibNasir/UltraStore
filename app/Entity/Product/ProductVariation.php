<?php

namespace App\Entity\Product;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
	
	public $timestamps = false;
	
	protected $fillable = ['name'];
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_variations';
	
	public function items()
    {
        return $this->hasMany('App\Entity\Product\ProductVariationItem', 'variation_id');
    }
	
}