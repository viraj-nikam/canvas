@extends('frontend.blog')

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
                    <div class="media">
                        <div class="media-left">
                            <img src="{{ asset('uploads/' . $post->page_image) }}" style="width: 100px">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading"><a href="{{ $post->url($tag) }}">{{ $post->title }}</a></h4>
                            <p>{{ $post->published_at->format('F j, Y') }}
                                @if ($post->tags->count())
                                    in
                                    {!! join(', ', $post->tagLinks()) !!}
                                @endif
                            </p>
                        </div>
                    </div>

                      <!--   <div class="post-preview">
                        @if ($post->page_image)
                            <img src="{{ asset('uploads/' . $post->page_image) }}" style="width: 100px; float: left; margin-top: 25px">
                        @endif
                        <h2 class="post-title">
                            <a href="{{ $post->url($tag) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="post-meta">
                            {{ $post->published_at->format('F j, Y') }}
                            @if ($post->tags->count())
                                in
                                {!! join(', ', $post->tagLinks()) !!}
                            @endif
                        </p> -->
                    <!-- </div> -->


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