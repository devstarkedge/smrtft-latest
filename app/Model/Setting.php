<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable =['banner_heading','banner_heading_items','banner_description','banner_image','banner_search_text','banner_video_text'];
}
