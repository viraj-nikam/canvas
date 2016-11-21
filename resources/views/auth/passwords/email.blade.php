@extends('backend.layout')

@section('title')
    <title>{{ Settings::blogTitle() }} | Forgot Password</title>
@stop

@section('login')
    <div class="container container-fluid login-container">
        @include('shared.errors')
        @include('auth.passwords.partials.email-form')
    </div>
@endsection

@section('unique-js')
    {!! JsValidator::formRequest('App\Http\Requests\ForgotPasswordRequest', '#forgot-password') !!}
    @include('backend.shared.components.show-password', ['inputs' => 'input[name="password"]'])
@stop
