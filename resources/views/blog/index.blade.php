@extends('canvas::layouts.app')

@section('title', sprintf('%s - %s', config('app.name', 'Laravel'), 'Blog'))

@section('body')
    @if(count($data['posts']) > 0)
        <div class="container mt-5">
            <div class="row justify-content-md-center">
                <div class="col col-lg-8">
                    <h2 class="mb-5 serif">@isset($data['tag']) {{ sprintf('Posts in:%s', $data['tag']) }} @endisset</h2>
                    @foreach($data['posts'] as $post)
                        <p class="small text-muted text-uppercase pt-5">Published on {{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</p>
                        <h2 class="serif my-3 content-title font-weight-bold"><a href="{{ route('blog.post.show', $post->slug) }}">{{ $post->title }}</a></h2>
                        <p class="content-body serif">{{ str_limit($post->body, 200) }}</p>

                        <div class="d-flex justify-content-between mb-5">
                            <p class="text-uppercase text-muted">{{ $post->readingTime }}</p>
                            <a href="{{ route('blog.post.show', $post->slug) }}" class="text-muted text-uppercase">Read full post</a>
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