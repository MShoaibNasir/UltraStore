<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
        'name', 'email', 'phone', 'password', 'user_type', 'status', 'profile_picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public function getCreatedAtAttribute($value)
    {
		$date_format = get_date_format();
		$time_format = get_time_format();
        return \Carbon\Carbon::parse($value)->format("$date_format $time_format");
    }
	
	public function role(){
		return $this->belongsTo('App\Role','role_id')->withDefault();
	}
	
    public function wishlist()
    {
        return $this->belongsToMany('App\Entity\Product\Product', 'wish_lists')->withTimestamps();
    }

    public function wishlistHas($productId)
    {
        return self::wishlist()->where('product_id', $productId)->exists();
    }

    public function reviews()
    {
        return $this->belongsToMany('App\Entity\Product\Product', 'product_reviews')->withTimestamps();
    }

    public function reviewHas($productId)
    {
        return self::reviews()->where('product_id', $productId)->exists();
    }
}
