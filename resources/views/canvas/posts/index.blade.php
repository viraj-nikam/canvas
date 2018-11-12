@extends('canvas::canvas.index')

@section('title', sprintf('%s - %s', 'Canvas', 'Posts'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('canvas::canvas.components.notifications.success')
                @include('canvas::canvas.components.notifications.error')

                <div class="card">
                    <div class="card-header">Posts</div>

                    @if(count($data['posts']))
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Post</th>
                                            <th>Published</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data['posts'] as $post)
                                        <tr>
                                            <td>
                                                <a href="{{ route('canvas.post.edit', $post->id) }}" class="font-weight-bold">{{ $post->title }}</a>
                                                <br><small class="text-muted">Updated {{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }} @if(count($post->tags)) — Tags: {{ implode(', ', $post->tags) }} @endif</small>
                                            </td>
                                            <td class="align-middle">
                                                @if($post->published)
                                                    <i class="far fa-check-circle text-success fa-fw"></i>
                                                @else
                                                    <i class="far fa-times-circle text-danger fa-fw"></i>
                                                @endif
                                            </td>
                                            <td class="align-middle w-25">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{ $data['posts']->links() }}
                        </div>
                    @else
                        <div class="card-body">
                            <p class="card-text">No posts were found, start by <a
                                        href="{{ route('canvas.post.create') }}">adding a new post</a>.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
