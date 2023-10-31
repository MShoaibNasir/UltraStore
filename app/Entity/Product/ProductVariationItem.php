<?php

namespace App\Entity\Product;

use Illuminate\Database\Eloquent\Model;

class ProductVariationItem extends Model
{
	
	public $timestamps = false;
	
	protected $fillable = ['name'];
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_variation_items';

    public function variation()
    {
        return $this->belongsTo('App\Entity\Product\ProductVariation', 'variation_id');
    }
	
}