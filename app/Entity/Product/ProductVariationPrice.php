<?php

namespace App\Entity\Product;

use Illuminate\Database\Eloquent\Model;

class ProductVariationPrice extends Model
{
	
	public $timestamps = false;
	
	protected $fillable = ['option', 'price', 'special_price', 'is_available'];
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_variation_prices';
	
}