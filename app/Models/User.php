<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthdate',
        'comment',
        'theme_color_id',
        'group_id',
        'profile_image_path',
    ];

    // 趣味
    public function hobbies(): HasMany
    {
        return $this->hasMany(Hobby::class);
    }
    public function hobbyLikes(): HasMany
    {
        return $this->hasMany(HobbyLike::class);
    }
    
    // その他
    public function others(): HasMany
    {
        return $this->hasMany(Other::class);
    }
    public function otherLikes(): HasMany
    {
        return $this->hasMany(OtherLike::class);
    }

    // フリー投稿
    public function freePosts(): HasMany
    {
        return $this->hasMany(FreePost::class);
    }
    public function freePostsLikes(): HasMany
    {
        return $this->hasMany(FreePostLike::class);
    }
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
