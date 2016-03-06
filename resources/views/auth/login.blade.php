@extends('admin.layout')

@section('title')
    <title>{{ config('blog.title') }} | Login</title>
@stop

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
@endsection

@section('login')
    <div class="center_div">
        <form class="form-signin" role="form" method="POST" action="{{ url('/auth/login') }}">
            <br/>
            <img src="{{ asset('images/logo.png') }}" class="login-img" width="115px">
            <br/>
            <p align="center"><span class="lead login-header">Please Sign In</span></p>
            {!! csrf_field() !!}
            <div class="{{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="text" class="form-control simplebox" name="email" value="{{ old('email') }}" placeholder="Email">
            </div>
            <div class="{{ $errors->has('email') ? 'has-error' : '' }}">
                <input type="password" class="form-control simplebox" name="password" placeholder="Password">
            </div>
            <input type="submit" class="btn btn-primary btn-outline btn-block" value="Sign in"/>
        </form>
    </div>
@endsection