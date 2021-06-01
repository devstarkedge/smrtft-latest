<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppLogin extends Model
{
    
     protected $table = 'app_login';
     protected $fillable = ['user_id', 'driver_id','owner_id','session_id','device_token','device_type'];
}
