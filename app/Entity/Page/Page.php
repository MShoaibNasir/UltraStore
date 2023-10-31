<?php

namespace App\Entity\Page;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasMetaData;
use App\Traits\HasMedia;
use App\Media;

class Page extends Model
{
    use HasMedia, HasMetaData;
	
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pages';
	
	public function default_lang(){
		return $this->hasMany('App\Entity\Page\PageTranslation','page_id');
	}
	
	public function translation(){
		return $this->hasOne('App\Entity\Page\PageTranslation','page_id')
                    ->where('locale', get_language())
                    ->withDefault([
                        'title' => isset($this->default_lang[0]) ? $this->default_lang[0]->title : '',
            			'body' => isset($this->default_lang[0]) ? $this->default_lang[0]->body : '',
            		]);
	}

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $this->generateSlug($value);
    }

    private function generateSlug($value)
    {	
        $slug = mb_strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $value)));
        $count = Page::where('slug','LIKE',$slug.'%')->count();
        $suffix = $count ? $count+1 : "";
        $slug .=$suffix;
        return $slug;
    }

    public function getCreatedAtAttribute($value)
    {
        $date_format = get_date_format();
        $time_format = get_time_format();
        return \Carbon\Carbon::parse($value)->format("$date_format $time_format");
    }

    /**
     * Get the page image.
     *
     * @return \Modules\Media\Entities\File
     */
    public function getImageAttribute()
    {
        return $this->files->where('pivot.name', 'page_image')->first() ?: new Media;
    }
	
}