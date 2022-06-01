<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizSettings extends Model
{
    public function category_id(){
        return $this->hasOne('App\Models\Category', 'id', 'category');
    }

    public function subcategory_id(){
        return $this->hasOne('App\Models\Subcategory', 'id', 'category');
    }
}
