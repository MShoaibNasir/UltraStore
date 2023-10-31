<?php

namespace App\Entity\Brand;

use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{
	
	protected $fillable = ['name'];
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'brands_translation';
	
	protected static function booted()
    {
        static::creating(function ($translation) {
            $translation->locale = get_language();
        });
    }
}