@extends('canvas::layouts.admin')

@push('scripts')
    <script src="{{ mix('js/app.js', 'vendor/canvas') }}"></script>
    <script defer src="{{ url('https://use.fontawesome.com/releases/v5.3.1/js/all.js') }}" integrity="sha384-kW+oWsYx3YpxvjtZjFXqazFpA7UP/MbiY4jvs+RWZo2+N94PFZ36T6TFkc9O3qoB" crossorigin="anonymous"></script>
@endpush

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css', 'vendor/canvas') }}">
    <link href="{{ url('https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i') }}}" rel="stylesheet">
@endpush

@section('body')
    @include('canvas::canvas.components.notifications.success')
    @include('canvas::canvas.components.notifications.error')

    <div class="container">
        <div class="row">
            <div class="col-md-3 sidebar">
                @include('canvas::canvas.components.nav.sidebar')
            </div>
            <div class="col-md-9 content">
                @yield('content')
            </div>
        </div>
    </div>
@endsection