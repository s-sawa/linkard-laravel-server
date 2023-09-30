<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other2 extends Model
{
    use HasFactory;

    protected $table = 'others2';

    protected $fillable = ['user_id', 'name', 'newOtherName2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function other2Like()
    {
        return $this->hasMany(Other2Like::class);
    }
    
    public function likers()
    {
        return $this->belongsToMany(User::class, 'other2_likes');
    }
}
