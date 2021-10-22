<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    
     protected $table = 'program';
     protected $fillable = ['user_id', 'category_id','program_name','program_level','program_title','program_desc','program_image','nutrition_id','program_time','number_of_weeks','program_status','program_intro'];
}