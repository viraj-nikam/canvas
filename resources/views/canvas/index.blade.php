@extends('canvas::layouts.canvas')

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-md-3 sidebar">
                @include('canvas::canvas.components.nav.sidebar')
            </div>
            <div class="col-md-9 content">
                @include('canvas::canvas.components.notifications.success')
                @include('canvas::canvas.components.notifications.error')
                @yield('content')
            </div>
        </div>
    </div>
@endsection