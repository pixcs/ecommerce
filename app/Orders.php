<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'product',
        'customer',
        'purchase_date',
        'status',
        'price'
    ];
}
