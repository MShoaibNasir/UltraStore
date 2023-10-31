<?php

namespace App\Entity\Tax;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tax_rates';
	
    public function default_lang(){
        return $this->hasMany('App\Entity\Tax\TaxRateTranslation','tax_rate_id');
    }

	public function translation(){
		return $this->hasOne('App\Entity\Tax\TaxRateTranslation','tax_rate_id')->where('locale', get_language())->withDefault([
            'name' => isset($this->default_lang[0]) ? $this->default_lang[0]->name : '',
        ]);
	}
	
}