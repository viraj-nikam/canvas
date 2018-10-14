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

    <p>You haven't published any posts yet.</p>
@endsection
