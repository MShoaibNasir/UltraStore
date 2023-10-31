<?php

namespace App\Entity\Navigation;

use Illuminate\Database\Eloquent\Model;

class NavigationItemTranslation extends Model
{
	
	protected $fillable = ['name'];
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'navigation_item_translations';
	
	protected static function booted()
    {
        static::creating(function ($translation) {
            $translation->locale = get_language();
        });
    }
}