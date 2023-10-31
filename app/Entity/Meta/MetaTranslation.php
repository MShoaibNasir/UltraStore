<?php

namespace App\Entity\Meta;

use Illuminate\Database\Eloquent\Model;

class MetaTranslation extends Model
{
	
	protected $fillable = ['meta_title','meta_keywords', 'meta_description'];
	
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meta_data_translations';
	
	protected static function booted()
    {
        static::creating(function ($translation) {
            $translation->locale = get_language();
        });
    }
}