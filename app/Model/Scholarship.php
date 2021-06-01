<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{

    protected $fillable = ['partner_id', 'scholarship_name', 'scholarship_amount', 'instruction','scholarship_doc_one','scholarship_doc_two','scholarship_doc_three','scholarship_expiry_date', 'is_active','awards'];

    public function user() {
        return $this->belongsTo(\App\User::class, 'partner_id');
    }

    public function user_scholarships() {
        return $this->hasMany(UserScholarship::class,'scholarship_id','id');
    }

}
