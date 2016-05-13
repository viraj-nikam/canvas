@extends('admin.layout')

@section('title')
    <title>{{ config('blog.title') }} | Add Tag</title>
@stop

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-12">
                <h1 class="page-header">Add Tag</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">New Tag Form</h3>
                    </div>
                    <div class="panel-body">
                        @include('admin.partials.errors')
                        <form class="form-horizontal" role="form" method="POST" action="/admin/tag">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="tag" class="col-md-3 control-label">Tag</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control simplebox" name="tag" id="tag" value="{{ $tag }}" autofocus>
                                </div>
                            </div>
                            @include('admin.tag._form')
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <center>
                                        <button type="submit" class="btn btn-primary btn-outline">
                                            <i class="fa fa-fw fa-save"></i> Save New Tag
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
@stop