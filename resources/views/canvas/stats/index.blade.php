@extends('canvas::canvas.index')

@section('actions')
    <a href="{{ route('canvas.post.create') }}" class="btn btn-sm btn-outline-primary mr-2 my-auto mx-3">
        New Post
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mt-1">Stats</h1>

                @if($data['posts']['all']->isNotEmpty())
                    <p class="mt-3 mb-4">Click a post to find more specific insight and metrics.</p>

                    <div class="card-deck mb-5">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted small text-uppercase font-weight-bold">Page Views</h5>
                                <p class="card-text display-4">{{ number_format($data['posts']['published']->sum('views')) }}</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted small text-uppercase font-weight-bold">Total Posts</h5>
                                <p class="card-text display-4">{{ $data['posts']['all']->count() }}</p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted small text-uppercase font-weight-bold">Publishing</h5>
                                <ul>
                                    <li>{{ $data['posts']['published']->count() }} Published Post(s)</li>
                                    <li>{{ $data['posts']['drafts']->count() }} Draft(s)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @foreach($data['posts']['published'] as $post)
                        <div class="d-flex border-top py-2 align-items-center">
                            <div class="mr-auto">
                                <p class="mb-0 py-2">
                                    <a href="{{ route('canvas.stats.show', $post->id) }}"
                                       class="font-weight-bold lead">{{ $post->title }}</a>
                                    <br>
                                    <small class="text-muted">
                                        {{ $post->readingTime }} ― <a href="{{ route('blog.post.show', $post->slug) }}">View
                                            Post</a> ― <a href="{{ route('canvas.stats.show', $post->id) }}">Details</a>
                                    </small>
                                </p>
                            </div>
                            <div class="ml-auto">
                                <span class="text-muted mr-3">{{ $post->views }} View(s)</span>
                                Created {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach

                    {{ $data['posts']['all']->links() }}
                @else
                    <p class="mt-4">There are no published posts for which you can view stats.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
