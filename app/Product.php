<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable=['product_code','description_in_english','description_in_arabic','priority','title_in_english','title_in_arabic','image','status','category_id','price','discounted_price'];
}
