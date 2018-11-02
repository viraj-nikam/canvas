@extends('canvas::layouts.blog')

@section('title', config('app.name', 'Laravel'))

@section('body')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col col-lg-8">
                <h2 class="mb-5">@isset($data['tag']) {{ $data['tag'] }} @else Blog @endisset</h2>
                @if(count($data['posts']) > 0)
                    @foreach($data['posts'] as $post)
                        <p class="lead"><a href="{{ route('blog.post.show', $post->slug) }}">{{ $post->title }}</a></p>
                        <p class="small text-muted">Published on {{ \Carbon\Carbon::parse($post->published_at)->format('M d, Y') }}</p>
                        <p>{{ $post->summary }}</p>
                        <hr>
                    @endforeach
                @else
                    <p class="lead">Nothing much to see here yet, but you can change that.</p>
                @endif
            </div>
        </div>
        <div class="row mx-auto justify-content-center">
            {{ $data['posts']->links() }}
        </div>
    </div>
@endsection