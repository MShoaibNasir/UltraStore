<?php

namespace App\Entity\Page;

use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
	
	protected $fillable = ['title', 'body'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'page_translations';
	
	protected static function booted()
    {
        static::creating(function ($translation) {
            $translation->locale = get_language();
        });
    }
}