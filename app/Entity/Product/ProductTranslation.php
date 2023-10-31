<?php

namespace App\Entity\Product;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
	
	protected $fillable = ['name','description','short_description'];
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_translations';
	
	protected static function booted()
    {
        static::creating(function ($translation) {
            $translation->locale = get_language();
        });
    }
}