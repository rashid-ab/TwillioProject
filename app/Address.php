<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
   protected $fillable=['user_id','region','state','city','vila','appartment','building_no','flat_no','house_no'];
}
