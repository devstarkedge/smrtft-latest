<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table ='contact-us';
    protected $fillable =['first_name','last_name','email','subject','message'];
}
