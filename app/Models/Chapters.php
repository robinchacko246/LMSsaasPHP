<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapters extends Model
{
    public function header_data()
    {
        return $this->hasMany('App\Models\Header', 'id', 'header_id');
    }

    public function chapters_status()
    {
        return $this->hasOne('App\Models\ChapterStatus', 'chapter_id', 'id');
    }

    public function chapter_min()
    {
        $data = DB::table('chapters')->select('id','duration' ,'course_id')->first();        
        return $data;
    }

}
