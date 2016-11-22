@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Sign In</title>
@stop

@section('login')
    <div class="login-container">
        @include('shared.errors')
        @include('auth.partials.form')
    </div>
@endsection

@section('unique-js')
    {!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#login') !!}
    @include('backend.shared.components.show-password', ['inputs' => 'input[name="password"]'])
@stop
