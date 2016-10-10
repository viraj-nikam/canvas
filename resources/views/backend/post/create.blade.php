@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | New Post</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="block-header" id="pageTop">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('admin') }}">Home</a></li>
                        <li><a href="{{ url('admin/post') }}">Posts</a></li>
                        <li class="active">New Post</li>
                    </ol>
                </div>
                @include('backend.post.partials.form')
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @include('backend.post.partials.editor')
    @include('backend.shared.notifications.protip')
    @include('backend.shared.components.datetime-picker')
    @include('backend.shared.components.slugify')
    {!! JsValidator::formRequest('App\Http\Requests\PostCreateRequest', '#postCreate') !!}
@stop
