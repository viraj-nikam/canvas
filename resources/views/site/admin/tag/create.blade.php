@extends('admin')

@section('title')
    <title>{{ config('blog.title') }} | New Tag</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="page-header">
                <ul class="breadcrumb">
                    <li><a href="/admin">Home</a></li>
                    <li><a href="/admin/tag">Tags</a></li>
                    <li class="active">New Tag</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="well bs-component">
                <form class="form-horizontal" role="form" method="POST" action="/admin/tag">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    @include('shared.errors')
                    @include('site.admin.tag.partials.form')
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="submit" class="btn btn-primary"><i class="material-icons">save</i>&nbsp;&nbsp;Save</button>
                            &nbsp;
                            <a href="/admin/tag" class="btn btn-default">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop