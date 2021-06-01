<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable =['user_id','plan_id','transaction_number','plan_expiry'];
    
     public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
