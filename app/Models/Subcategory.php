<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    public function category_id(){
        return $this->hasOne('App\Models\Category', 'id', 'category');
    }
}
