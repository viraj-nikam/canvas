@extends('frontend.layout')

@section('title')
    <title>{{ $tag->title or config('blog.title') }}</title>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                @if (!empty($tag->title))
                    <p class="tag-link">Explore <a href="#">{{ $tag->title or '' }}</a></p>
                    <p class="tag-subtitle">- {{ $tag->subtitle }} -</p>
                @endif
                {{-- The Posts --}}
                @foreach ($posts as $post)
                    <div class="post-preview">
                        <h2 class="post-title">
                            <a href="{{ $post->url($tag) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="post-meta">
                            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->published_at)->diffForHumans() }}
                            @if ($post->tags->count())
                                in
                                {!! join(', ', $post->tagLinks()) !!}
                            @endif
                        </p>
                    </div>
                    <hr>
                @endforeach
                {{-- The Pager --}}
                <ul class="pager">
                    {{-- Reverse direction --}}
                    @if ($reverse_direction)
                        @if ($posts->currentPage() > 1)
                            <li class="previous">
                                <a href="{!! $posts->url($posts->currentPage() - 1) !!}">
                                    <i class="fa fa-angle-left fa-lg"></i>
                                    Previous {{ $tag->tag }}
                                </a>
                            </li>
                        @endif
                        @if ($posts->hasMorePages())
                            <li class="next">
                                <a href="{!! $posts->nextPageUrl() !!}">
                                    Next {{ $tag->tag }}
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        @endif
                    @else
                        @if ($posts->currentPage() > 1)
                            <li class="previous">
                                <a href="{!! $posts->url($posts->currentPage() - 1) !!}">
                                    <i class="fa fa-angle-left fa-lg"></i>
                                    Newer {{ $tag ? $tag->tag : '' }}
                                </a>
                            </li>
                        @endif
                        @if ($posts->hasMorePages())
                            <li class="next">
                                <a href="{!! $posts->nextPageUrl() !!}">
                                    Older {{ $tag ? $tag->tag : '' }}
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
@stop