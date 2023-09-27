<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThemeColor extends Model
{
    use HasFactory;
    public function users() 
    {
       return $this->hasMany(User::class, 'theme_color_id');
    }

}
