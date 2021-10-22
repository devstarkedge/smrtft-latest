<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Nutrition extends Model
{
    //
    protected $table ='nutrition';
    protected $fillable =['nutrition_title','nutrition_image','nutrition_desc','nutrition_status','nutrition_video'];
}
