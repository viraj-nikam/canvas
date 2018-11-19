@extends('canvas::layouts.app')

@section('title', $data['post']->title)

@section('body')
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8">
                <h1 class="serif font-weight-bold mb-2">{{ $data['post']->title }}</h1>
                <p class="small serif text-muted mb-4">Published on {{ \Carbon\Carbon::parse($data['post']->published_at)->format('M d, Y') }} by {{ $data['post']->user->name }}</p>
                <p class="serif">{{ $data['post']->body }}</p>

                @if($data['post']->tags->count() > 0)
                    <p class="mt-4">
                        @foreach($data['post']->tags as $tag)
                            <a href="{{ route('blog.tag.index', $tag->slug) }}"
                               class="badge badge-light p-2">{{ $tag->name }}</a>
                        @endforeach
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection