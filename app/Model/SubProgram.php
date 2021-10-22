<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubProgram extends Model
{
    //
    protected $table ='subprogram';
    protected $fillable =['program_id','subprogram_name','subprogram_desc','subprogram_workouts','week','subprogram_image','nutrition_image','nutrition_desc','program_time'];
}
