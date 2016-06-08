@extends('backend.layout')

@section('title')
    <title>{{ config('blog.title') }} | New Post</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="page-header">
                <ul class="breadcrumb">
                    <li><a href="/admin">Home</a></li>
                    <li><a href="/admin/post">Posts</a></li>
                    <li class="active">New Post</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="well bs-component">
                <form id="postCreate" class="form-horizontal" role="form" method="POST" action="{{ route('admin.post.store') }}">
                    @include('shared.errors')
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @include('backend.post.partials.form')
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                          <button type="submit" class="btn btn-primary"><i class="zmdi zmdi-floppy"></i>&nbsp;&nbsp;Save</button>&nbsp;
                          <a href="/admin/post" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop