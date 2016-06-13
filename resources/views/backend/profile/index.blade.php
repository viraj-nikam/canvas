@extends('backend.layout')

@section('title')
    <title>{{ config('blog.title') }} | Profile</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb">
                            <li><a href="/admin">Home</a></li>
                            <li class="active">Profile</li>
                        </ol>
                        <ul class="actions">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Refresh Profile</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>

                        @include('shared.errors')
                        @include('shared.success')

                        <h2>{{ Auth::user()->display_name }}&nbsp;
                            <a href="/admin/profile/{{ Auth::user()->id }}/edit" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Edit profile"><i class="zmdi zmdi-edit"></i></a>
                            <small>This page provides a detailed look at your profile. Click the edit link above to modify and update your information to keep it current.</small>
                        </h2>

                        {{ Auth::user()->first_name }}<br>
                        {{ Auth::user()->last_name }}<br>
                        {{ Auth::user()->display_name }}<br>
                        {{ Auth::user()->url }}<br>
                        {{ Auth::user()->bio }}
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop
