<?php

namespace App\Entity\Brand;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMedia;
use App\Media;

class Brand extends Model
{
	use HasMedia;
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'brands';
	
	public function default_lang(){
		return $this->hasMany('App\Entity\Brand\BrandTranslation','brand_id');
	}
	
	public function translation(){
		return $this->hasOne('App\Entity\Brand\BrandTranslation','brand_id')->where('locale', get_language())->withDefault([
			'name' => isset($this->default_lang[0]) ? $this->default_lang[0]->name : '',
		]);
	}

    public function products()
    {
        return $this->hasMany('App\Entity\Product\Product', 'brand_id');
    }
	
	public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $this->attributes['slug'] = mb_strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value)));;
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