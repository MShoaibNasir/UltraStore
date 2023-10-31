<?php

namespace App\Entity\Category;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMedia;
use App\Media;

class Category extends Model
{
	use HasMedia;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category';

    public function default_lang(){
		return $this->hasMany('App\Entity\Category\CategoryTranslation','category_id');
	}
	
	public function translation(){
		return $this->hasOne('App\Entity\Category\CategoryTranslation','category_id')->where('locale', get_language())->withDefault([
            'name' => isset($this->default_lang[0]) ? $this->default_lang[0]->name : '',
			'description' => isset($this->default_lang[0]) ? $this->default_lang[0]->description : '',
		]);
	}

    public function parent_category(){
        return $this->belongsTo('App\Entity\Category\Category','parent_id')->withDefault();
    }

    public function child_category(){
        return $this->hasMany('App\Entity\Category\Category','parent_id');
    }
	
	public function products()
    {
        return $this->belongsToMany('App\Entity\Product\Product', 'product_categories');
    }
	
	public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = mb_strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value)));
    }
	
	/**
     * Get the brand's logo.
     *
     * @return \Modules\Media\Entities\File
     */
    public function getLogoAttribute()
    {
        return $this->files->where('pivot.name', 'logo')->first() ?: new Media;
    }

    /**
     * Get the brand's banner.
     *
     * @return \Modules\Media\Entities\File
     */
    public function getBannerAttribute()
    {
        return $this->files->where('pivot.name', 'banner')->first() ?: new Media;
    }

}