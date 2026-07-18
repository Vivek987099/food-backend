<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name','image'
    ];
    
    protected function name(): Attribute
    {
        return Attribute::make(
            set: function($value){
                return ucwords($value);
            },
        );
    }

    public function foodItems(){
        return $this->hasMany(FoodItem::class);
    }
}
