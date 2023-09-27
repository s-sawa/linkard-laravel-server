<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherLike extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'other_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function other()
    {
        return $this->belongsTo(Other::class);
    }
}
