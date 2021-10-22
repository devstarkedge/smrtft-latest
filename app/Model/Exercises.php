<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercises extends Model
{
    
     protected $table = 'exercises';
     protected $fillable = ['workout_id','exercise_name','exercise_desc','exercise_video','exercise_duration'];
}