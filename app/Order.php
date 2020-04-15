<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id','date','address_id','time','discount','total_price','order_status','payment_method','payment_status'];
}
