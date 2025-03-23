<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;  // 需要確保這個包已安裝

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 如果您沒有安裝 Laravel Sanctum，可以先註解掉這行
    // use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
    ];

    /**
     * 取得使用者所有文章
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * 取得使用者所有留言
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
