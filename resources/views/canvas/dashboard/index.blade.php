@extends('canvas::canvas.index')

@section('title', sprintf('%s - %s', config('app.name', 'Laravel'), 'Dashboard'))

@section('content')
    <div class="dashhead">
        <div class="dashhead-titles">
            <h6 class="dashhead-subtitle">Dashboard</h6>
            <h2 class="dashhead-title">Overview</h2>
        </div>
    </div>
    <hr class="mt-3">

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <p>Welcome to Canvas! Get familiar with Canvas and explore it's features in the documentation:</p>
@endsection
