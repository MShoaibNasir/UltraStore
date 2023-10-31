<?php

namespace App\Entity\Tag;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';
	
	public function default_lang(){
		return $this->hasMany('App\Entity\Tag\TagTranslation','tag_id');
	}
	
	public function translation(){
		return $this->hasOne('App\Entity\Tag\TagTranslation','tag_id')->where('locale', get_language())->withDefault([
			'name' => isset($this->default_lang[0]) ? $this->default_lang[0]->name : '',
		]);
	}

	public function products()
    {
        return $this->belongsToMany('App\Entity\Product\Product', 'product_tags');
    }
	
	public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = mb_strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value)));
    }
}