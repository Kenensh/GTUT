<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * 可批量賦值的屬性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
    ];

    /**
     * 取得發表這篇文章的使用者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 取得這篇文章的所有留言
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
