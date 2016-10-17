@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Home</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                @include('backend.home.sections.welcome')
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        @include('backend.home.sections.at-a-glance')
                    </div>
                    <div class="col-sm-6 col-md-6">
                        @include('backend.home.sections.quick-draft')
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-md-6">
                        @include('backend.home.sections.recent-posts')
                    </div>
                    <div class="col-sm-6 col-md-6">
                        @include('backend.home.sections.canvas-news')
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @if(Session::get('_login'))
        @include('backend.partials.notify', ['section' => '_login'])
        {{ \Session::forget('_login') }}
    @endif
    @include('backend.shared.components.slugify')
    {!! JsValidator::formRequest('App\Http\Requests\PostCreateRequest', '#postCreate') !!}
@stop
