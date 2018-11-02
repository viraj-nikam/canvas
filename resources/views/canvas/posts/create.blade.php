@extends('canvas::canvas.index')

@section('title', sprintf('%s - %s', config('app.name', 'Laravel'), 'New Post'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('canvas::canvas.components.notifications.success')
                @include('canvas::canvas.components.notifications.error')

                <div class="card">
                    <div class="card-header">New Post</div>

                    <div class="card-body p-0">
                        @include('canvas::canvas.components.forms.post.create')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection