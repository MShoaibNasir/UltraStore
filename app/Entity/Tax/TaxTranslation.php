<?php

namespace App\Entity\Tax;

use Illuminate\Database\Eloquent\Model;

class TaxTranslation extends Model
{
	
	protected $fillable = ['name'];
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax_classes_translation';
	
	protected static function booted()
    {
        static::creating(function ($translation) {
            $translation->locale = get_language();
        });
    }
}