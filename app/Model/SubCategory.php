<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    //
    protected $table ='subcategory';
    protected $fillable =['category_id','subcategory_name','subcategory_desc','subcategory_image'];
}
