<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','name','phone','address','subtotal','total','payment_method','status','razorpay_order_id','razorpay_payment_id','razorpay_signature','payment_status'
    ];

    public function order_items(){
        return $this->hasMany(OrderItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
