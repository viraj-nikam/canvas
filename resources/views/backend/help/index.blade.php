@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Help</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="block-header" id="pageTop">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('admin') }}">Home</a></li>
                        <li class="active">Help</li>
                    </ol>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h2>Help Topics
                            <small>Help is available for all of the following topics:</small>
                        </h2>
                    </div>
                    <div class="card-body card-padding">
                        @include('backend.help.partials.overview')
                        <hr>
                        @include('backend.help.partials.topics')
                        <hr>
                        @include('backend.help.partials.items')
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @include('backend.shared.components.smooth-scroll')
@endsection
