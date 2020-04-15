<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable= ['Vlg_id','Vlg_cd','Vlg_Name','region_id'];
}
