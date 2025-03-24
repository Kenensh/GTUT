<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * 確定使用者是否可以更新文章
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    /**
     * 確定使用者是否可以刪除文章
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }
}
