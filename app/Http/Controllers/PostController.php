use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

// 修改 store 方法
public function store(StorePostRequest $request)
{
    $validated = $request->validated();

    $post = new Post([
        'title' => $validated['title'],
        'content' => $validated['content'],
        'user_id' => auth()->id() ?: 1,
    ]);

    $post->save();

    return redirect()->route('posts.index')
        ->with('success', '文章建立成功！');
}

// 修改 update 方法
public function update(UpdatePostRequest $request, Post $post)
{
    $validated = $request->validated();

    $post->update([
        'title' => $validated['title'],
        'content' => $validated['content'],
    ]);

    return redirect()->route('posts.show', $post->id)
        ->with('success', '文章更新成功！');
}
