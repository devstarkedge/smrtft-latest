<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    //
    protected $table ='workouts';
    protected $fillable =['user_id','subcategory_id','workout_name','position','workout_desc','workout_image','workout_equipments','workout_url','video_url','workout_time','workout_status'];
}
