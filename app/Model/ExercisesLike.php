<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExercisesLike extends Model
{
    
     protected $table = 'exercises_like';
     protected $fillable = ['workout_id','user_id','exercise_id','status'];
}