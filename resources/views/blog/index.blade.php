@extends('canvas::layouts.blog')

@section('title', config('app.name', 'Laravel'))

@section('body')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8">
                @foreach($data['posts'] as $post)
                    <h2><a href="{{ route('blog.post.show', $post->slug) }}">{{ $post->title }}</a></h2>
                    <p>{{ $post->summary }}</p>
                    @if($post->tags->count() > 0)
                        @foreach($post->tags as $tag)
                            <p><a href="{{ route('blog.tag.show', $tag->slug) }}" class="badge badge-pill badge-primary">{{ $tag->name }}</a></p>
                        @endforeach
                    @endif
                    <hr>
                @endforeach
            </div>
        </div>
        <div class="row mx-auto justify-content-center">
            {{ $data['posts']->links() }}
        </div>
    </div>
@endsection