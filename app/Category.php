<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['title_in_english','title_in_arabic','image','priority','status'];
}
