@extends('backend.layout')

@section('title')
    <title>{{ config('blog.title') }} | Sign In</title>
@stop

@section('login')
    <section id="main">
        <section id="content">
            <div class="card">
                <div class="card-header">
                    <center><img src="{{ asset('images/canvas-logo.gif') }}" style="width: 120px"></center>
                </div>
                <div class="card-body card-padding">

                    @include('auth.partials.login-form')

                </div>
            </div>
        </section>
    </section>
@endsection

@section('unique-js')
    {!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#login'); !!}
@stop