@extends('canvas::layouts.app')

@section('title', $data['post']->title)

@section('body')
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8">
                <h1 class="display-4 font-weight-bold mb-2 content-title serif">{{ $data['post']->title }}</h1>
                <p class="text-uppercase text-muted my-4">Published on {{ \Carbon\Carbon::parse($data['post']->published_at)->format('M d, Y') }}</p>
                <p class="content-body serif">{{ $data['post']->body }}</p>

                @if($data['post']->tags->count() > 0)
                    <p class="mt-4">
                        @foreach($data['post']->tags as $tag)
                            <a href="{{ route('blog.tag.index', $tag->slug) }}"
                               class="badge badge-light p-2">{{ $tag->name }}</a>
                        @endforeach
                    </p>
                @endif

                <div class="border-top mt-5">
                    <p class="mt-5 text-center text-uppercase text-muted">Powered by <a href="{{ url('https://cnvs.io') }}" class="text-muted" target="_blank"><u>Canvas</u></a></p>
                </div>
            </div>
        </div>
    </div>
@endsection