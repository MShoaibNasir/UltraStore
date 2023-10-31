<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media';

    private $file_path = 'media/no-image.png';

    public function user(){
    	return $this->belongsTo('App\User','user_id')->withdefault();
    }

    public function getFilePathAttribute($value)
    {
        if($value == null){
        	return $this->file_path;
        }
        return $value;
    }
}