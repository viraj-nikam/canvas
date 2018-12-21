@extends('canvas::layouts.app')

@section('title', $data['post']->title)

@push('meta')
    <meta name="description" content="{{ $data['meta']['meta_description'] }}">
    <meta name="og:title" content="{{ $data['meta']['og_description'] }}">
    <meta name="og:description" content="{{ $data['meta']['og_description'] }}">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $data['meta']['twitter_description'] }}">
    <meta name="twitter:description" content="{{ $data['meta']['twitter_description'] }}">
    @isset($data['post']->featured_image)
        <meta name="og:image" content="{{ url($data['post']->featured_image) }}">
        <meta name="twitter:image" content="{{ url($data['post']->featured_image) }}">
    @endisset
@endpush

@section('body')
    <div class="container mt-4">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8">
                <h1 class="display-4 font-weight-bold mb-2 content-title serif pt-5">
                    {{ $data['post']->title }}
                    @auth()
                        <a id="navbarDropdown" href="#" style="font-size: 20px" role="button" data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-cog text-muted"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a href="{{ route('canvas.post.edit', $data['post']->id) }}"
                               class="dropdown-item sans-serif">Edit post</a>
                            <a href="{{ route('canvas.stats.show', $data['post']->id) }}"
                               class="dropdown-item sans-serif">View stats</a>
                        </div>
                    @endauth
                </h1>
                <p class="text-uppercase text-muted my-4">
                    Published on {{ \Carbon\Carbon::parse($data['post']->published_at)->format('M d, Y') }}
                    @if($data['post']->tags->count() > 0) in
                    @foreach($data['post']->tags as $tag)
                        <a href="{{ route('blog.tag.index', $tag->slug) }}"
                           class="text-muted"><u>{{ $tag->name }}</u></a>
                    @endforeach
                    @endif
                </p>

                @isset($data['post']->featured_image)
                    <img src="{{ $data['post']->featured_image }}" alt="{{ $data['post']->featured_image_caption }}"
                         title="{{ $data['post']->featured_image_caption }}" class="w-100">
                    <p class="mt-3 text-muted text-center">{{ $data['post']->featured_image_caption }}</p>
                @endisset

                <div class="content-body serif">{!! $data['post']->body !!}</div>
                <div class="border-top my-5">
                    <p class="mt-5 text-center text-uppercase text-muted">Powered by <a
                                href="{{ url('https://cnvs.io') }}" class="text-muted" target="_blank"><u>Canvas</u></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection