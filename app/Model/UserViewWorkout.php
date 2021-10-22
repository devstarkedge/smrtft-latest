<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserViewWorkout extends Model
{
    //
    protected $table ='user_view_workout';
    protected $fillable =['workout_id','user_id'];
}
