<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 添加這行

class CommentController extends Controller
{
    /**
     * 儲存新留言
     */
    public function store(Request $request, Post $post)
    {
        // 驗證表單輸入
        $validated = $request->validate([
            'content' => 'required|string|min:2|max:1000',
        ], [
            'content.required' => '留言內容不能為空',
            'content.min' => '留言內容至少需要2個字元',
            'content.max' => '留言內容不能超過1000個字元',
        ]);

        $comment = new Comment([
            'content' => $validated['content'],
            'user_id' => auth()->id() ?: 1, // 如果未登入，使用ID為1的用戶
            'post_id' => $post->id,
        ]);

        $comment->save();

        return redirect()->route('posts.show', $post->id)
            ->with('success', '留言發表成功！');
    }
}
