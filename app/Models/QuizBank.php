<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizBank extends Model
{
    public function quiz_id(){
        return $this->hasOne('App\Models\QuizSettings', 'id', 'quiz');
    }
}
