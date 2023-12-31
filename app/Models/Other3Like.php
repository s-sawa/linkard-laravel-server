<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other3Like extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'other3_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function other3()
    {
        return $this->belongsTo(Other::class);
    }
}
