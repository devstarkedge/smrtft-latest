<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserScholarship extends Model
{

    protected $table = 'user_scholarship';
    protected $fillable = ['scholarship_id', 'user_id', 'is_status','professional_life','citizen_permanent','experience_five_year','user_submit_doc'];

    public function scholarship() {
        return $this->belongsTo(Scholarship::class);
    }

    public function user() {
        return $this->belongsTo(\App\User::class);
    }

}
