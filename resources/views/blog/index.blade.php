@extends('canvas::layouts.app')

@section('title', sprintf('%s - %s', config('app.name', 'Laravel'), 'Blog'))

@section('body')
    @if(count($data['posts']) > 0)
        <div class="container mt-5">
            <div class="row justify-content-md-center">
                <div class="col col-lg-8">
                    <h2 class="mb-5">@isset($data['tag']) {{ $data['tag'] }} @else Blog @endisset</h2>
                    @foreach($data['posts'] as $post)
                        <div class="card shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="card-title"><a href="{{ route('blog.post.show', $post->slug) }}">{{ $post->title }}</a></h5>
                                <p class="card-text">{{ $post->summary }}</p>
                                @if($post->tags->count() > 0)
                                    @foreach($post->tags as $tag)
                                        <a href="{{ route('blog.tag.show', $tag->slug) }}" class="badge badge-pill badge-primary">{{ $tag->name }}</a>
                                    @endforeach
                                @endif
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Published on {{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row mx-auto justify-content-center">
                {{ $data['posts']->links() }}
            </div>
        </div>
    @else
        <div style="height: 100vh">
            <div class="d-flex align-items-center justify-content-center h-100 position-relative">
                <div class="text-center">
                    <h1 class="display-4 welcome">Welcome to <span>C</span>anvas.</h1>
                    <p class="lead">A Laravel publishing platform.</p>
                    <a href="{{ route('canvas.index') }}" class="btn btn-primary">Dive in</a>
                </div>
            </div>
        </div>
    @endif
@endsection