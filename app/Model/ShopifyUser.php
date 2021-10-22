<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ShopifyUser extends Model
{
    //
    protected $table ='shopify_user';
    protected $fillable =['email'];
}
