<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * 可批量賦值的屬性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
    ];

    /**
     * 取得發表這則留言的使用者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 取得這則留言所屬的文章
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
