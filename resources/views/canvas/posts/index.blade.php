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
                <h1>Posts</h1>

                @include('canvas::canvas.components.notifications.success')
                @include('canvas::canvas.components.notifications.error')

                @if(count($data['posts']))
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0 mt-4">
                            <tbody>
                            @foreach($data['posts'] as $post)
                                <tr class="border-top">
                                    <td>
                                        <p class="mb-0 py-2">
                                            <a href="{{ route('canvas.post.edit', $post->id) }}"
                                               class="font-weight-bold lead">{{ $post->title }}</a>
                                            @if($post->summary)
                                                <br>
                                                {{ $post->summary }}
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
                                    </td>
                                    <td class="text-right align-middle">
                                        <a href="{{ route('canvas.post.edit', $post->id) }}">
                                                <span class="fa-stack fa-2x align-middle">
                                                    <i class="fas fa-circle fa-stack-2x text-black-50"></i>
                                                    <i class="far fa-fw fa-stack-1x fa-image fa-inverse"></i>
                                                </span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $data['posts']->links() }}
                @else
                    <p class="mt-4">No posts were found, start by <a href="{{ route('canvas.post.create') }}">adding a
                            new post</a>.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
