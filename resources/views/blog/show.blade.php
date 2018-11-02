@extends('canvas::layouts.app')

@section('title', $data['post']->title)

@section('body')
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8">
                <h2>{{ $data['post']->title }}</h2>
                <p class="small text-muted">Published on {{ \Carbon\Carbon::parse($data['post']->published_at)->format('M d, Y') }} by {{ $data['user']->name }}</p>
                @if($data['post']->tags->count() > 0)
                    @foreach($data['post']->tags as $tag)
                        <a href="{{ route('blog.tag.index', $tag->slug) }}"
                           class="badge badge-pill badge-primary">{{ $tag->name }}</a>
                    @endforeach
                @endif
                <hr>
                <p>{{ $data['post']->body }}</p>
            </div>
        </div>
        <div class="row mx-auto justify-content-center mt-5">
            <a href="{{ route('blog.index') }}" class="btn btn-link"><i class="fas fa-angle-double-left"></i> Go Back</a>
        </div>
    </div>
@endsection