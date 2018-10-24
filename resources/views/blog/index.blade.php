@extends('canvas::layouts.blog')

@section('title', config('app.name', 'Laravel'))

@section('body')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8">
                @if(count($data['posts']) > 0)
                    @foreach($data['posts'] as $post)
                        <p class="lead"><a href="{{ route('blog.post.show', $post->slug) }}">{{ $post->title }}</a></p>
                        <p>{{ $post->summary }}</p>
                        @if($post->tags->count() > 0)
                            @foreach($post->tags as $tag)
                                <p><a href="{{ route('blog.tag.show', $tag->slug) }}" class="badge badge-pill badge-primary">{{ $tag->name }}</a></p>
                            @endforeach
                        @endif
                        <hr>
                    @endforeach
                @else
                    <div class="text-center">
                        <p class="lead mt-5 mb-4">Nothing much to see here yet, but you can change that.</p>
                        <a href="{{ route('canvas.post.create') }}" class="btn btn-outline-primary mx-auto">New Post</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="row mx-auto justify-content-center">
            {{ $data['posts']->links() }}
        </div>
    </div>
@endsection