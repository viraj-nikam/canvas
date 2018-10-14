@extends('canvas::canvas.index')

@section('title', sprintf('%s - %s', config('app.name', 'Laravel'), 'New Post'))

@section('content')
    <div class="dashhead">
        <div class="dashhead-titles">
            <h6 class="dashhead-subtitle">Resources</h6>
            <h2 class="dashhead-title">New Post</h2>
        </div>
    </div>
    <hr class="mt-3">

    <editor></editor>
@endsection
