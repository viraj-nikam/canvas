@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Users</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="block-header">
                    <h2>Users</h2>
                    <ul class="actions">
                        <li class="dropdown">
                            <a href="" data-toggle="dropdown">
                                <i class="zmdi zmdi-more-vert"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li>
                                    <a href="{{ url('admin/users') }}"><i class="zmdi zmdi-refresh-alt pd-r-5"></i> Refresh Users</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                {{--Content and Partials go here--}}
            </div>
        </section>
    </section>
@stop

@section('unique-js')

@stop
