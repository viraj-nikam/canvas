@extends('home.master')

@section('content')
  <!-- Static navbar -->
  <!-- <nav class="navbar navbar-default navbar-static-top">
    <div class="container">
      <div class="nav-brand">
        <img src="{{ asset('images/logo.png') }}" class="navbar-brand">
        <a class="navbar-brand" href="#">Canvas</a>
      </div>
      <div class="nav-links">
        <a href="/" class="nav-link">Home</a>
        <a href="/blog" class="nav-link">Blog</a>
        <a href="#" class="nav-link">GitHub</a>
      </div>
    </div>
  </nav> -->

  <div class="container-fluid">
      <header class="row-fluid">
        <div class="span6 left">
          <h1><a href="/">Wardrobe</a></h1>
        </div>
        <div class="span6 right">
          <ul class="nav">
            <li><a href="/">Home</a></li>
            <li><a href="/blog">Blog</a></li>
            <li><a href="#">GitHub</a></li>
          </ul>
        </div>
      </header>
    </div>

  <hr>

  <div class="container">
    <div class="col-md-6 col-sm-6">
      <h2>Some Heading</h2>
      <h4>This is my subheading</h4>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
      consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
      cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
      proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
      <button>Click Me</button>
    </div>
    <div class="col-md-6 col-sm-6">
      <img src="http://wardrobecms.com/media/wardrobe-screen.png" class="img-responsive">
    </div>
  </div>
@stop