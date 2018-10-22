@extends('canvas::layouts.blog')

@section('title', config('app.name', 'Laravel'))

@section('content')
    @foreach($data['posts'] as $post)
        <h1><a href="{{ route('blog.post.show', $post->slug) }}">{{ $post->title }}</a></h1>
        @if($post->tags->count() > 0)
            @foreach($post->tags as $tag)
                <p><a href="{{ route('blog.tag.show', $tag->slug) }}">#{{ $tag->name }}</a></p>
            @endforeach
        @endif
    @endforeach
@endsection