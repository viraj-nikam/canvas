@extends('canvas::layouts.blog')

@section('title', $data['post']->title)

@section('body')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8">
                <h1>{{ $data['post']->title }}</h1>
                <p class="small text-muted">Published {{ \Carbon\Carbon::parse($data['post']->published_at)->format('M d, Y') }}</p>
                @if($data['post']->tags->count() > 0)
                    @foreach($data['post']->tags as $tag)
                        <p><a href="{{ route('blog.tag.show', $tag->slug) }}" class="badge badge-pill badge-primary">{{ $tag->name }}</a></p>
                    @endforeach
                @endif
                <p>{{ $data['post']->body }}</p>
            </div>
        </div>
    </div>
@endsection