<?php

namespace App\Entity\Product;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMedia;
use App\Traits\HasMetaData;
use App\Media;

class Product extends Model
{
	use HasMedia, HasMetaData;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'qty',
        'in_stock',
        'is_active',
    ];

    protected $appends = ['image'];

    public function default_lang(){
		return $this->hasMany('App\Entity\Product\ProductTranslation','product_id');
	}
	
	public function translation(){
		return $this->hasOne('App\Entity\Product\ProductTranslation','product_id')
				    ->where('locale', get_language())
					->withDefault([
			            'name' => isset($this->default_lang[0]) ? $this->default_lang[0]->name : '',
						'description' => isset($this->default_lang[0]) ? $this->default_lang[0]->description : '',
						'short_description' => isset($this->default_lang[0]) ? $this->default_lang[0]->short_description : '',
					]);
	}


    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $this->generateSlug($value);
    }

    private function generateSlug($value)
    {
        $slug = mb_strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value)));
        $count = Product::where('slug','LIKE',$slug.'%')->count();
        $suffix = $count ? $count+1 : "";
        $slug .=$suffix;
        return $slug;
    }

	public function brand()
    {
        return $this->belongsTo('App\Entity\Brand\Brand','brand_id')->withDefault();
    }

    public function categories()
    {
        return $this->belongsToMany('App\Entity\Category\Category', 'product_categories');
    }

    public function taxClass()
    {
        return $this->belongsTo('App\Entity\Tax\Tax','tax_class_id')->withDefault();
    }

    public function tags()
    {
        return $this->belongsToMany('App\Entity\Tag\Tag', 'product_tags');
    }
	
	public function product_options()
    {
        return $this->hasMany('App\Entity\Product\ProductVariation', 'product_id');
    }

    public function variation_prices()
    {
        return $this->hasMany('App\Entity\Product\ProductVariationPrice', 'product_id');
    }
	
	public function comments()
    {
        return $this->hasMany('App\ProductComment')->whereNull('parent_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\ProductReviews')->where('is_approved', 1);
    }

    public function getImageAttribute()
    {
        return $this->files->where('pivot.name', 'product_image')->first() ?: new Media;
    }

    public function outOfStock()
    {
        $this->update(['in_stock' => false]);
    }

    public function revertOutOfStock()
    {
        $this->update(['in_stock' => true]);
    }

    /**
     * Get the brand's banner.
     *
     * @return \Modules\Media\Entities\File
     */
    public function getGalleryImagesAttribute()
    {
        return $this->files->where('pivot.name', 'gallery_images');
    }

    public function getCreatedAtAttribute($value)
    {
		$date_format = get_date_format();
		$time_format = get_time_format();
        return \Carbon\Carbon::parse($value)->format("$date_format $time_format");
    }

}