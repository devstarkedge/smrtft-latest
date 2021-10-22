<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProgramWeekDescription extends Model
{
    //
     protected $table = 'program_week_description';
     protected $fillable = ['program_id', 'week','week_description'];
}
