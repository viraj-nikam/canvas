@extends('home.master')

@section('content')
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="nav-brand">
                <img src="{{ asset('images/logo.png') }}" class="navbar-brand">
                <a class="navbar-brand" href="#">{{ config('blog.title') }}</a>
            </div>
            <div class="nav-links">
                <a href="/" class="nav-link">Home</a>
                <a href="/blog" class="nav-link">Blog</a>
                <a href="#" class="nav-link">GitHub</a>
            </div>
        </div>
    </nav>
@stop