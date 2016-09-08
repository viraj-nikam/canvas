@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Settings</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">

                @include('backend.settings.partials.settings')

            </div>
        </section>
    </section>
@stop

@section('unique-js')

@stop
