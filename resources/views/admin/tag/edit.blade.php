@extends('admin.layout')

@section('title')
    <title>Todd Austin | Edit Tag</title>
@stop

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-12">
                <h1 class="page-header">Edit Tag</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tag Edit Form</h3>
                    </div>
                    <div class="panel-body">
                        @include('admin.partials.errors')
                        @include('admin.partials.success')
                        <form class="form-horizontal" role="form" method="POST" action="/admin/tag/{{ $id }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <div class="form-group">
                                <label for="tag" class="col-md-3 control-label">Tag</label>
                                <div class="col-md-3">
                                    <p class="form-control-static">{{ $tag }}</p>
                                </div>
                            </div>
                            @include('admin.tag._form')
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <center>
                                        <button type="submit" class="btn btn-primary btn-outline">
                                            <i class="fa fa-fw fa-save"></i> Save Changes
                                        </button>
                                        <button type="button" class="btn btn-danger btn-outline" data-toggle="modal" data-target="#modal-delete">
                                            <i class="fa fa-fw fa-times-circle"></i> Delete
                                        </button>
                                    </center>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Confirm Delete --}}
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
                            <i class="fa fa-fw fa-times-circle"></i> Delete Tag
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop