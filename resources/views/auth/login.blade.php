@extends('backend.layout')

@section('title')
    <title>{{ config('blog.title') }} | Sign In</title>
@stop

@section('styles')
    <link href="/css/auth.css" rel="stylesheet">
@endsection

@section('login')

    @include('auth.partials.login-form')

@endsection