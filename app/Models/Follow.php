<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'group_id'
    ];

    // フォローするユーザーのリレーション
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    // フォローされるユーザーのリレーション
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    // グループのリレーション
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

}
