<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other2Like extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'other2_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function other2()
    {
        return $this->belongsTo(Other::class);
    }
}
