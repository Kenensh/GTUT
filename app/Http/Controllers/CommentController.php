<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * 建構函數，設定中間件
     */
    public function __construct()
    {
        // 僅登入用戶可以發表留言
        $this->middleware('auth');
    }

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
            'user_id' => Auth::id(), // 使用當前登入用戶ID
            'post_id' => $post->id,
        ]);

        $comment->save();

        return redirect()->route('posts.show', $post->id)
            ->with('success', '留言發表成功！');
    }

    /**
     * 刪除留言
     */
    public function destroy(Comment $comment)
    {
        // 檢查權限，只有留言作者可以刪除
        $this->authorize('delete', $comment);

        $postId = $comment->post_id;
        $comment->delete();

        return redirect()->route('posts.show', $postId)
            ->with('success', '留言刪除成功！');
    }
}
