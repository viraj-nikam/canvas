@extends('canvas::layouts.blog')

@section('title', config('app.name', 'Laravel'))

@section('content')
    <h1>{{ $data['post']->title }}</h1>
    @if($data['post']->tags->count() > 0)
        @foreach($data['post']->tags as $tag)
            <p><a href="{{ route('blog.tag.show', $tag->slug) }}">#{{ $tag->name }}</a></p>
        @endforeach
    @endif
    <p>Summary: {{ $data['post']->summary }}</p>
    <p>Body: {{ $data['post']->body }}</p>
@endsection