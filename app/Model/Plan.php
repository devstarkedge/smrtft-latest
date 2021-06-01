<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable=['plan_name','amount','discount_amount','plan_period','time_period'];
    
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
