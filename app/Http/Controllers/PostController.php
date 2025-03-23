<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * 建構函數，設定中間件
     */
    public function __construct()
    {
        // 僅登入用戶可以進行除了 index 和 show 之外的操作
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * 顯示所有文章
     */
    public function index(Request $request)
    {
        $query = Post::with('user');

        // 搜尋功能
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $posts = $query->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    /**
     * 顯示新增文章表單
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * 儲存新文章
     */
    public function store(Request $request)
    {
        // 驗證表單輸入
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
        ], [
            'title.required' => '文章標題不能為空',
            'title.min' => '文章標題至少需要3個字元',
            'title.max' => '文章標題不能超過255個字元',
            'content.required' => '文章內容不能為空',
            'content.min' => '文章內容至少需要10個字元',
        ]);

        $post = new Post([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'user_id' => Auth::id(), // 使用當前登入用戶ID
        ]);

        $post->save();

        return redirect()->route('posts.index')
            ->with('success', '文章建立成功！');
    }

    /**
     * 顯示單篇文章及其留言
     */
    public function show(Post $post)
    {
        $post->load(['comments.user', 'user']);
        return view('posts.show', compact('post'));
    }

    /**
     * 顯示編輯文章表單
     */
    public function edit(Post $post)
    {
        // 檢查權限，只有文章作者可以編輯
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    /**
     * 更新文章
     */
    public function update(Request $request, Post $post)
    {
        // 檢查權限，只有文章作者可以更新
        $this->authorize('update', $post);

        // 驗證表單輸入
        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
        ], [
            'title.required' => '文章標題不能為空',
            'title.min' => '文章標題至少需要3個字元',
            'title.max' => '文章標題不能超過255個字元',
            'content.required' => '文章內容不能為空',
            'content.min' => '文章內容至少需要10個字元',
        ]);

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('posts.show', $post->id)
            ->with('success', '文章更新成功！');
    }

    /**
     * 刪除文章
     */
    public function destroy(Post $post)
    {
        // 檢查權限，只有文章作者可以刪除
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', '文章刪除成功！');
    }
}
