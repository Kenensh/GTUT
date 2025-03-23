@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h1>{{ $post->title }}</h1>
        <p class="text-muted">
            由 {{ $post->user->name }} 發表於 {{ $post->created_at->format('Y-m-d H:i') }}
        </p>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p class="card-text">{{ $post->content }}</p>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <div>
                @can('update', $post)
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">編輯文章</a>
                @endcan

                @can('delete', $post)
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('確定要刪除這篇文章嗎？');">刪除文章</button>
                    </form>
                @endcan
            </div>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">返回列表</a>
        </div>
    </div>

    <h3>留言 ({{ $post->comments->count() }})</h3>

    @if($post->comments->count() > 0)
        @foreach($post->comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text">{{ $comment->content }}</p>
                    <p class="card-text text-muted">
                        由 {{ $comment->user->name }} 發表於 {{ $comment->created_at->format('Y-m-d H:i') }}
                    </p>

                    @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('確定要刪除這則留言嗎？');">刪除留言</button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            暫無留言。
        </div>
    @endif

    @auth
        <div class="card mt-4">
            <div class="card-header">發表留言</div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('comments.store', $post->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control" name="content" rows="3" required>{{ old('content') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">發表留言</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info mt-4">
            請<a href="{{ route('login') }}">登入</a>後發表留言。
        </div>
    @endauth
@endsection
