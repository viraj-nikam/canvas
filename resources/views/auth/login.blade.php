@extends('admin')

@section('title')
    <title>{{ config('blog.title') }} | Login</title>
@stop

@section('styles')
    <link href="{{ elixir('css/auth.css') }}" rel="stylesheet">
@endsection

@section('login')
    <div class="center_div">
        @include('auth.partials.login-form')
    </div>
@endsection