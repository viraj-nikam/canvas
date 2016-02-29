@extends('home.master')

@section('content')
    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <img src="{{ asset('images/logo.png') }}" class="navbar-brand">
          <a class="navbar-brand" href="#">Canvas</a>
        </div>
        <ul class="nav navbar-nav pull-right">
            <li><a href="/" class="nav-link">Home</a></li>
            <li><a href="/blog" class="nav-link">Blog</a></li>
            <li><a href="#" class="nav-link">GitHub</a></li>
          </ul>
      </div>
    </nav>
@stop