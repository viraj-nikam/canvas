@extends('canvas::canvas.index')

@section('status', $data['post']->published ? 'Published' : 'Draft')

@section('actions')
    <a href="#" class="btn btn-sm btn-outline-primary my-auto" data-toggle="modal" data-target="#modal-edit">Update</a>

    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link px-3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
           aria-expanded="false" v-pre>
            <i class="fas fa-sliders-h fa-fw"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-details">Details</a>
            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-image">Featured Image</a>
            <a href="#" class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete">Delete</a>
        </div>
    </li>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('canvas::canvas.components.notifications.success')
                @include('canvas::canvas.components.notifications.error')
                @include('canvas::canvas.components.forms.post.edit')
                @include('canvas::canvas.components.modals.post.delete')
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if ($errors->has('slug'))
        <script type="text/javascript">
            $(document).ready(function () {
                $('#modal-details').modal('show');
            });
        </script>
    @endif
@endpush
