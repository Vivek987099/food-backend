<?php

namespace App\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id','food_item_id','quantity','price'
    ];

    public function cart(){
        return $this->belongsTo(Cart::class);
    }

    public function foodItem(){
        return $this->belongsTo(FoodItem::class);
    }
}
