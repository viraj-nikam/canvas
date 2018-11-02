@extends('canvas::canvas.index')

@section('title', sprintf('%s - %s', config('app.name', 'Laravel'), 'Update Post'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('canvas::canvas.components.notifications.success')
                @include('canvas::canvas.components.notifications.error')

                <div class="card">
                    <div class="card-header">Update Post</div>

                    <div class="card-body p-0">
                        @include('canvas::canvas.components.forms.post.update')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
