<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';


	public function translation(){
		return $this->hasOne('App\SettingTranslation','setting_id')
					->where('locale', get_language())
                    ->withDefault(['value' => $this->value]);
	}
}