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
        'birthday',
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

    public function hasLikedHobby($hobbyId)
    {
        return $this->hobbyLikes->contains('hobby_id', $hobbyId);
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
    public function hasLikedOther($otherId)
    {
        return $this->otherLikes->contains('other_id', $otherId);
    }

    // その他2
    public function others2(): HasMany
    {
        return $this->hasMany(Other2::class);
    }
    public function other2Likes(): HasMany
    {
        return $this->hasMany(Other2Like::class);
    }
    public function hasLikedOther2($other2Id)
    {
        return $this->other2Likes->contains('other2_id', $other2Id);
    }

    // その他3
    public function others3(): HasMany
    {
        return $this->hasMany(Other3::class);
    }
    public function other3Likes(): HasMany
    {
        return $this->hasMany(Other3Like::class);
    }

    public function hasLikedOther3($other3Id)
    {
        return $this->other3Likes->contains('other3_id', $other3Id);
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

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'from_user_id');
    }

    // ユーザーがフォローしている人たち
    public function followingUsers()
    {
        return $this->belongsToMany(
            User::class,     // 目的のモデル
            'follows',       // 中間テーブル名
            'from_user_id',  // 現在のモデルに関連する外部キー名
            'to_user_id'     // 結果のモデルに関連する外部キー名
        );
    }

    // ユーザーをフォローしている人たち
    public function followedByUsers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'to_user_id',
            'from_user_id'
        );
    }
    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    public function themeColors() 
    {
        return $this->belongsTo(ThemeColor::class, 'theme_color_id');
    }

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'birthday',
        'email',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
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
