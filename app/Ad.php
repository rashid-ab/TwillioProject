<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = ['ad_type','title_in_english','title_in_arabic','text_in_english','text_in_arabic','image','status'];
}
