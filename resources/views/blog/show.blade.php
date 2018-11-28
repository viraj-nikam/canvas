@extends('canvas::layouts.app')

@section('title', $data['post']->title)

@section('body')
    <div class="container mt-5">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8">
                <h1 class="display-4 font-weight-bold mb-2 content-title serif pt-5">{{ $data['post']->title }}</h1>
                <p class="text-uppercase text-muted my-4">
                    Published on {{ \Carbon\Carbon::parse($data['post']->published_at)->format('M d, Y') }}
                    @if($data['post']->tags->count() > 0) in
                        @foreach($data['post']->tags as $tag)
                            <a href="{{ route('blog.tag.index', $tag->slug) }}" class="text-muted"><u>{{ $tag->name }}</u></a>
                        @endforeach
                    @endif
                </p>
                <div class="content-body serif">{!! $data['post']->body !!}</div>
                <div class="border-top my-5">
                    <p class="mt-5 text-center text-uppercase text-muted">Powered by <a href="{{ url('https://cnvs.io') }}" class="text-muted" target="_blank"><u>Canvas</u></a></p>
                </div>
            </div>
        </div>
    </div>
@endsection