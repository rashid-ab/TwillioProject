<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    protected $fillable=['user_id','order_id','product_id','quantity','price','total_price','order_status'];
}
