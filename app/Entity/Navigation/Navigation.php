<?php

namespace App\Entity\Navigation;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'navigations';

    public function navigationItems(){
    	return $this->hasMany('App\Entity\Navigation\NavigationItem')->orderBy("position","asc");
    }
}