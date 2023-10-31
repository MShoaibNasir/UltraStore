<?php

namespace App\Entity\Tag;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
	
	protected $fillable = ['name'];
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags_translation';
	
	protected static function booted()
    {
        static::creating(function ($translation) {
            $translation->locale = get_language();
        });
    }
}