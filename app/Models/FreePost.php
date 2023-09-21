<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreePost extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'image_path'];

        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function freePostLike()
    {
        return $this->hasMany(FreePostLike::class);
    }
}