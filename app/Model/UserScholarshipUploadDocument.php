<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserScholarshipUploadDocument extends Model
{

    protected $table = 'user_scholarship_upload_document';
    protected $fillable = ['user_scholarship_id','upload_doc'];

   
}