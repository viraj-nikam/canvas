@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Edit Post</title>
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
                        <li class="active">Edit Post</li>
                    </ol>
                </div>
                @include('backend.post.partials.form')
            </div>
        </section>
    </section>
    @include('backend.post.partials.modals.delete')
@stop

@section('unique-js')
    @include('backend.post.partials.editor')
    @include('backend.shared.components.datetime-picker')
    {!! JsValidator::formRequest('App\Http\Requests\PostUpdateRequest', '#postUpdate'); !!}
    @if(Session::get('_update-post'))
        @include('backend.partials.notify', ['section' => '_update-post'])
        {{ \Session::forget('_update-post') }}
    @endif
@stop
