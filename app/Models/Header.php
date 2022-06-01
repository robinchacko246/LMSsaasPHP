<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    public function chapters_data(){
        return $this->hasMany('App\Models\Chapters', 'header_id', 'id');
    }


}
