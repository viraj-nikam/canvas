@extends('canvas::canvas.index')

@section('title', sprintf('%s - %s', config('app.name', 'Laravel'), 'Posts'))

@section('content')
    <div class="dashhead">
        <div class="dashhead-titles">
            <h6 class="dashhead-subtitle">Resources</h6>
            <h2 class="dashhead-title">Posts</h2>
        </div>

        <div class="btn-toolbar dashhead-toolbar">
            <div class="btn-toolbar-item">
                <a href="{{ route('canvas.posts.create') }}" class="btn btn-outline-primary">New Post</a>
            </div>
        </div>
    </div>
    <hr class="mt-3">

    @if($data['posts'])
        <div class="table-responsive">
            <table class="table table-borderless table-striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['posts'] as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>
                            @if($post->published)
                                <span class="badge badge-primary">Published</span>
                            @else
                                <span class="badge badge-success">Draft</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($post->updated_at)->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('canvas.posts.edit', $post->id) }}" class="btn btn-link py-0"><i class="fas fa-fw fa-edit"></i></a>
                            <a href="#" class="btn btn-link py-0" data-toggle="modal" data-target="#modal-delete-{{ $post->id }}"><i class="fas fa-fw fa-trash"></i></a>
                        </td>
                    </tr>

                    @include('canvas::canvas.components.modals.post.delete')
                @endforeach
                </tbody>
            </table>
        </div>

        {{ $data['posts']->links() }}
    @else
        <p>You haven't published any posts yet.</p>
    @endif
@endsection
