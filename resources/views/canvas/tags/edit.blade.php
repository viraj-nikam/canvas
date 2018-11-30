@extends('canvas::canvas.index')

@section('actions')
    <a href="#" class="btn btn-sm btn-outline-primary my-auto mr-2"
       onclick="event.preventDefault();document.getElementById('form-edit').submit();"
       aria-label="Save">Update</a>

    <li class="nav-item dropdown">
        <a id="navbarDropdown" class="nav-link px-3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            <i class="fas fa-sliders-h fa-fw fa-rotate-270"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a href="#" class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete">Delete</a>
        </div>
    </li>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('canvas::canvas.components.forms.tag.edit')
                @include('canvas::canvas.components.modals.tag.delete')
            </div>
        </div>
    </div>
@endsection