<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'hobby'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hobbyLike()
    {
        return $this->hasMany(HobbyLike::class);
    }
    public function likers()
    {
        return $this->belongsToMany(User::class, 'hobby_likes'); // hobby_likesは中間テーブルの名前です。適切な名前に変更してください。
    }
}
