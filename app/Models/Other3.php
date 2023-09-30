<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other3 extends Model
{
    use HasFactory;

    protected $table = 'others3';

    protected $fillable = ['user_id', 'name', 'newOtherName3'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function other3Like()
    {
        return $this->hasMany(Other3Like::class);
    }
    public function likers()
    {
        return $this->belongsToMany(User::class, 'other3_likes');
    }
}
