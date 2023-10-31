<?php

namespace App\Entity\Tax;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax_classes';
    
	public function default_lang(){
		return $this->hasMany('App\Entity\Tax\TaxTranslation','tax_class_id');
	}

	public function translation(){
		return $this->hasOne('App\Entity\Tax\TaxTranslation','tax_class_id')->where('locale', get_language())->withDefault([
			'name' => isset($this->default_lang[0]) ? $this->default_lang[0]->name : '',
		]);
	}
	
	public function tax_rates(){
		return $this->hasMany('App\Entity\Tax\TaxRate','tax_class_id');
	}
	
	public function get_based_on(){
		return ucwords(str_replace("_", " ", $this->based_on));
	}

}