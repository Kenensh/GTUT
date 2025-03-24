@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <h1>所有文章</h1>
        </div>
        <div class="col-md-4">
            <form action="{{ route('posts.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="搜尋文章標題、內容或作者" value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">搜尋</button>
            </form>
        </div>
    </div>

    @if($posts->count() > 0)
        @foreach($posts as $post)
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">
                        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                    </h2>
                    <p class="card-text text-muted">
                        由 {{ $post->user->name }} 發表於 {{ $post->created_at->format('Y-m-d H:i') }}
                    </p>
                    <p class="card-text">{{ Str::limit($post->content, 200) }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">閱讀更多</a>
                </div>
            </div>
        @endforeach

        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    @else
        <div class="alert alert-info">
            目前沒有任何文章。
        </div>
    @endif
@endsection
