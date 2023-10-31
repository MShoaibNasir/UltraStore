<?php

namespace App\Entity\Category;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
	
	protected $fillable = ['name','description'];
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category_translation';
	
	protected static function booted()
    {
        static::creating(function ($translation) {
            $translation->locale = get_language();
        });
    }
}