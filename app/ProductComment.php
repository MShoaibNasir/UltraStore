<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_comments';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'product_id', 'parent_id', 'body'];
   
    /**
     * The belongs to Relationship
     *
     * @var array
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The belongs to Relationship
     *
     * @var array
     */
    public function product()
    {
        return $this->belongsTo(Entity\Product\Product::class);
    }
   
    /**
     * The has Many Relationship
     *
     * @var array
     */
    public function replies()
    {
        return $this->hasMany(ProductComment::class, 'parent_id');
    }
	
	 public function getCreatedAtAttribute($value)
    {
        $date_format = get_date_format();
        $time_format = get_time_format();
        return \Carbon\Carbon::parse($value)->format("$date_format $time_format");
    }

}