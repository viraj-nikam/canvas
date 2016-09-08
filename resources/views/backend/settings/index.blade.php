@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Settings</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="block-header">
                    <h2>Settings
                        <small>General configuration options for your blog.</small>
                    </h2>
                    <ul class="actions">
                        <li class="dropdown">
                            <a href="" data-toggle="dropdown">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="">Refresh Settings</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

                {{--Content Here--}}

            </div>
        </section>
    </section>
@stop

@section('unique-js')

@stop
