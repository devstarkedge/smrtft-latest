<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table ='category';
    protected $fillable =['category_name','category_desc','category_image'];
}
