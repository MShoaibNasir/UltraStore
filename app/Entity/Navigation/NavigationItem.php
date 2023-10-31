<?php

namespace App\Entity\Navigation;

use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'navigation_items';

    public function default_lang(){
		return $this->hasMany('App\Entity\Navigation\NavigationItemTranslation','navigation_item_id');
	}
	
	public function translation(){
		return $this->hasOne('App\Entity\Navigation\NavigationItemTranslation','navigation_item_id')
                    ->where('locale', get_language())
                    ->withDefault([
                        'name' => isset($this->default_lang[0]) ? $this->default_lang[0]->name : '',
            		]);
	}

    public function child_items(){
        return $this->hasMany('App\Entity\Navigation\NavigationItem','parent_id');
    }

    public function page(){
        return $this->belongsTo('App\Entity\Page\Page','page_id')->withDefault();
    }

    public function category(){
        return $this->belongsTo('App\Entity\Category\Category','category_id')->withDefault();
    }
}