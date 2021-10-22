<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRecordHistory extends Model
{
    //
    protected $table ='user_records_history';
    protected $fillable =['program_id','workout_id','customer_id','week','is_seen','is_complete','seen_date'];
}