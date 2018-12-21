@extends('canvas::layouts.app')

@section('title', 'Canvas')

@push('meta')
    <link rel="icon" type="image/png" href="{{ mix('favicon.png', 'vendor/canvas') }}">
@endpush

@section('body')
    @include('canvas::canvas.components.nav.navbar')
    <main class="py-4">
        @yield('content')
    </main>
@endsection