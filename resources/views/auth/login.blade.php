@extends('admin')

@section('title')
    <title>{{ config('blog.title') }} | Sign In</title>
@stop

@section('styles')
    <link href="{{ elixir('css/auth.css') }}" rel="stylesheet">
@endsection

@section('login')
    <hgroup>
      <h1>Canvas | Sign In</h1>
      <h3>Minimal Blogging Application for Developers</h3>
    </hgroup>

    @include('auth.partials.login-form')

    <footer>
      <a href="http://toddaustin.noip.me" target="_blank"><img src="https://www.polymer-project.org/images/logos/p-logo.svg"></a>
      <p>Designed and Developed by <a href="http://toddaustin.noip.me" target="_blank">Todd Austin</a></p>
    </footer>
@endsection