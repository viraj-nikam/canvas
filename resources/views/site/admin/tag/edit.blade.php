@extends('admin')

@section('title')
    <title>{{ config('blog.title') }} | Edit Tag</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="page-header">
                <ul class="breadcrumb">
                    <li><a href="/admin">Home</a></li>
                    <li><a href="/admin/tag">Tags</a></li>
                    <li class="active">Edit Tag</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="well bs-component">
                <form class="form-horizontal" role="form" method="POST" action="/admin/tag/{{ $id }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{ $id }}">
                    @include('shared.errors')
                    @include('shared.success')
                    @include('site.admin.tag.partials.form')
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary btn-outline">
                                <i class="material-icons">save</i>&nbsp;Save Changes
                            </button>&nbsp;
                            <button type="button" class="btn btn-danger btn-outline" data-toggle="modal" data-target="#modal-delete">
                                <i class="material-icons">delete_forever</i>&nbsp;Delete
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Delete this tag?</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this tag?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="/admin/tag/{{ $id }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-outline">
                            <i class="material-icons">delete_forever</i>&nbsp;Delete Tag
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop