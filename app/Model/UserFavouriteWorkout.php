<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserFavouriteWorkout extends Model
{
    //
    protected $table ='user_favourite_workouts';
    protected $fillable =['user_id','workout_id'];
}
