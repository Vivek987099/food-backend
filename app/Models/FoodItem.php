<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $fillable = [
        'name','price','description','is_available','category_id','image','slug','is_available'
    ];

    protected $hidden = [
        'category_id'
    ];

    protected function name():Attribute
    {
        return Attribute::make(
            set: function($value){
                return ucwords($value);
            },
        );
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function cartItems(){
        return $this->hasMany(CartItem::class);
    }

    public function orderItem(){
        return $this->hasMany(OrderItem::class);
    }
}
