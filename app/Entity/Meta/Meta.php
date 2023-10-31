<?php

namespace App\Entity\Meta;

use Illuminate\Database\Eloquent\Model;


class Meta extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'meta_data';


    protected $fillable = ['entity_id', 'entity_type'];
    

    public function default_lang(){
		return $this->hasMany('App\Entity\Meta\MetaTranslation','meta_data_id');
	}
	
	public function translation(){
		return $this->hasOne('App\Entity\Meta\MetaTranslation','meta_data_id')
                    ->where('locale', get_language())
                    ->withDefault([
                        'meta_title' => isset($this->default_lang[0]) ? $this->default_lang[0]->meta_title : '',
                        'meta_keywords' => isset($this->default_lang[0]) ? $this->default_lang[0]->meta_keywords : '',
            			'meta_description' => isset($this->default_lang[0]) ? $this->default_lang[0]->meta_description : '',
            		]);
	}

}