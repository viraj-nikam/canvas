@extends('layouts.admin')

@section('title')
    <title>{{ config('blog.title') }} | Edit Post</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="page-header">
              <ul class="breadcrumb">
                    <li><a href="/admin">Home</a></li>
                    <li><a href="/admin/post">Posts</a></li>
                    <li class="active">Edit Post</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Post Edit Form</h3>
                </div>
                <div class="panel-body">
                    @include('shared.errors')

                    @include('shared.success')
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.post.update', $id) }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        @include('site.admin.post.partials.form')
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary btn-outline" name="action" value="continue">
                                    <i class="material-icons">save</i>&nbsp;Save - Continue
                                </button>&nbsp;
                                <button type="submit" class="btn btn-success btn-outline" name="action" value="finished">
                                    <i class="material-icons">save</i>&nbsp;Save - Finished
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
    </div>
    {{-- Confirm Delete --}}
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">Delete this post?</h4>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this post?</p>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="{{ route('admin.post.destroy', $id) }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" class="btn btn-default btn-outline" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-outline">
                            <i class="material-icons">delete_forever</i>&nbsp;Delete Post
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop