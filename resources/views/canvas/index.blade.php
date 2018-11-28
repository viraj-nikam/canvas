@extends('canvas::layouts.app')

@section('title', 'Canvas')

@section('body')
    @include('canvas::canvas.components.nav.navbar')
    <main class="py-4">
        @yield('content')
    </main>
@endsection