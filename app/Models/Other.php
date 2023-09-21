<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'newOtherName'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function otherLike()
    {
        return $this->hasMany(OtherLike::class);
    }
}
