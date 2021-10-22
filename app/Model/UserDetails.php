<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    
     protected $table = 'user_details';
     protected $fillable = ['user_id', 'user_desc','address'];
}