@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Media</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h2>Media Library
                            <small>This page provides a comprehensive overview of your media library.</small>
                        </h2>
                    </div>

                    <media-manager></media-manager>
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')

    <script>
        new Vue({
            el: 'body',
            events:{
                'media-manager-notification' : function(message, type, time)
                {
                    $.growl({
                        message: message
                    },{
                        type: type,
                        allow_dismiss: false,
                        label: 'Cancel',
                        className: 'btn-xs btn-inverse',
                        placement: {
                            from: 'top',
                            align: 'right'
                        },
                        delay: time,
                        animate: {
                            enter: 'animated fadeInRight',
                            exit: 'animated fadeOutRight'
                        },
                        offset: {
                            x: 20,
                            y: 85
                        }
                    });
                }
            }
        });
    </script>
@stop
