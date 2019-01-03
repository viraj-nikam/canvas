@extends('canvas::canvas.index')

@section('actions')
    <a href="{{ route('canvas.post.create') }}" class="btn btn-sm btn-outline-primary my-auto mx-3">
        New post
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mt-2">Stats</h1>

                @if($data['posts']['all']->isNotEmpty())
                    <p class="mt-3 mb-4">Click a post below to view more specific insights.</p>

                    <div class="card-deck mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title text-muted small text-uppercase font-weight-bold">Total Views</h5>
                                <p class="card-text display-4">{{ number_format($data['views']['count']) }}</p>
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

                    @isset($data['views']['trend'])
                        <line-chart :views="{{ $data['views']['trend'] }}"></line-chart>
                    @endisset

                    <div class="mt-4">
                        @foreach($data['posts']['published'] as $post)
                            <div class="d-flex border-top py-3 align-items-center">
                                <div class="mr-auto">
                                    <p class="mb-1 mt-2">
                                        <a href="{{ route('canvas.stats.show', $post->id) }}"
                                           class="font-weight-bold lead">{{ $post->title }}</a>
                                    </p>
                                    <p class="text-muted mb-2">
                                            {{ $post->readingTime }} ― <a
                                                href="{{ route('blog.post.show', $post->slug) }}">View
                                                post</a> ― <a
                                                href="{{ route('canvas.stats.show', $post->id) }}">Details</a>
                                        </p>
                                </div>
                                <div class="ml-auto d-none d-lg-block">
                                    <span class="text-muted mr-3">{{ $post->views->count() }} View(s)</span>
                                    Created {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-center">
                            {{ $data['posts']['all']->links() }}
                        </div>
                    </div>
                @else
                    <p class="mt-4">There are no published posts for which you can view stats.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
