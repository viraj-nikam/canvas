@extends('canvas::layouts.app')

@section('title', 'Canvas')

@push('meta')
    <link rel="icon" href="{{ asset('vendor/canvas/images/logo.png') }}">
@endpush

@section('body')
    @include('canvas::canvas.components.nav.navbar')
    <main class="py-4">
        @yield('content')
    </main>
@endsection