@extends('canvas::canvas.index')

@section('actions')
    <a href="{{ route('canvas.index') }}" class="btn btn-sm btn-outline-primary mr-2 my-auto mx-3">
        All Stats
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mt-1">{{ $data['post']->title }}</h1>
                <p class="text-muted">Published on {{ \Carbon\Carbon::parse($data['post']->published_at)->format('F d, Y') }}</p>
            </div>
        </div>
    </div>
@endsection
