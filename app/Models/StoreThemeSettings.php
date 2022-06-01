<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreThemeSettings extends Model
{
    protected $table = 'store_theme_setting';
    protected $fillable = [
        'name',
        'value',
        'store_id',
        'created_by',
    ];
}
