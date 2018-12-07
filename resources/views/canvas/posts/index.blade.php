@extends('canvas::canvas.index')

@section('actions')
    <a href="{{ route('canvas.post.create') }}" class="btn btn-sm btn-outline-primary mr-2 my-auto mx-3">
        New post
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mb-4 mt-1">Posts</h1>

                @if(count($data['posts']))
                    @foreach($data['posts'] as $post)
                        <div class="d-flex border-top py-2 align-items-center">
                            <div class="mr-auto">
                                <p class="mb-0 py-2">
                                    <a href="{{ route('canvas.post.edit', $post->id) }}"
                                       class="font-weight-bold lead">{{ $post->title }}</a>
                                    @if($post->summary)
                                        <br>
                                        {{ str_limit($post->summary, 100) }}
                                    @endif
                                    <br>
                                    <small class="text-muted">
                                        @if($post->published)
                                            Published {{ \Carbon\Carbon::parse($post->published_at)->diffForHumans() }}
                                        @else
                                            <span class="text-danger">Draft</span>
                                        @endif
                                        ―
                                        Updated {{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}
                                        @if(count($post->tags))
                                            ― Tags: {{ implode(', ', $post->tags) }}
                                        @endif
                                    </small>
                                </p>
                            </div>
                            <div class="ml-auto d-none d-lg-block">
                                <a href="{{ route('canvas.post.edit', $post->id) }}">
                                    @isset($post->featured_image)
                                        <div class="mr-2" style="background-size: cover;background-image: url({{ $post->featured_image }});width: 57px; height: 57px; -webkit-border-radius: 50%;-moz-border-radius: 50%;border-radius: 50%;"></div>
                                    @else
                                        <span class="fa-stack fa-2x align-middle">
                                            <i class="fas fa-circle fa-stack-2x text-black-50"></i>
                                            <i class="fas fa-fw fa-stack-1x fa-camera fa-inverse"></i>
                                        </span>
                                    @endisset
                                </a>
                            </div>
                        </div>
                    @endforeach

                    {{ $data['posts']->links() }}
                @else
                    <p class="mt-4">No posts were found, start by <a href="{{ route('canvas.post.create') }}">adding a
                            new post</a>.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
