@extends('admin')

@section('title')
    <title>{{ config('blog.title') }} | New Post</title>
@stop

@section('styles')
    <link href="/assets/pickadate/themes/default.css" rel="stylesheet">
    <link href="/assets/pickadate/themes/default.date.css" rel="stylesheet">
    <link href="/assets/pickadate/themes/default.time.css" rel="stylesheet">
    <link href="/assets/selectize/css/selectize.css" rel="stylesheet">
    <link href="/assets/selectize/css/selectize.bootstrap3.css" rel="stylesheet">
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="page-header">
                  <h2 class="title">New Post</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="well bs-component">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('admin.post.store') }}">
                        @include('shared.errors')
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @include('site.admin.post.partials.form')
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                              <button type="submit" class="btn btn-primary"><i class="material-icons">save</i>&nbsp;Save</button>&nbsp;
                              <a href="/admin/post" class="btn btn-default">Cancel</a>
                            </div>
                          </div>
                    </form>
                </div>
            </div>
        </div>
@stop

@section('scripts')
    <script src="/assets/pickadate/picker.js"></script>
    <script src="/assets/pickadate/picker.date.js"></script>
    <script src="/assets/pickadate/picker.time.js"></script>
    <script src="/assets/selectize/selectize.min.js"></script>
    <script>
        $(function () {
            $("#publish_date").pickadate({
                format: "mmm-d-yyyy"
            });
            $("#publish_time").pickatime({
                format: "h:i A"
            });
            $("#tags").selectize({
                create: true
            });
        });
    </script>
@stop