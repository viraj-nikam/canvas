@extends('canvas::canvas.index')

@section('title', sprintf('%s - %s', 'Canvas', 'Update Post'))

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('canvas::canvas.components.notifications.success')
                @include('canvas::canvas.components.notifications.error')

                <div class="card">
                    <div class="d-flex card-header justify-content-between">
                        Update Post
                        <div>
                            <a href="#" class="btn btn-link py-0 text-muted" data-toggle="modal" data-target="#modal-details"><i class="fas fa-sliders-h fa-fw"></i></a>
                            <a href="#" class="btn btn-link py-0 text-muted" data-toggle="modal" data-target="#modal-delete"><i class="fas fa-trash fa-fw"></i></a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @include('canvas::canvas.components.forms.post.edit')
                        @include('canvas::canvas.components.modals.post.delete')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
