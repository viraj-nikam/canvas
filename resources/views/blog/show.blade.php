@extends('canvas::layouts.blog')

@section('title', $data['post']->title)

@section('body')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8">
                <h2>{{ $data['post']->title }}</h2>
                <p class="small text-muted">Published on {{ \Carbon\Carbon::parse($data['post']->published_at)->format('M d, Y') }} by {{ $data['user']->name }}</p>
                @if($data['post']->tags->count() > 0)
                    @foreach($data['post']->tags as $tag)
                        <p><a href="{{ route('blog.tag.index', $tag->slug) }}"
                              class="badge badge-pill badge-primary">{{ $tag->name }}</a></p>
                    @endforeach
                @endif
                <hr>
                <p>{{ $data['post']->body }}</p>
            </div>
        </div>
    </div>
@endsection