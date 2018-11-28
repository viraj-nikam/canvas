@extends('canvas::canvas.index')

@section('actions')
    <a href="{{ route('canvas.post.create') }}" class="btn btn-sm btn-outline-primary mr-2 my-auto mx-3">
        New Post
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1>Stats</h1>

                <p class="mt-4">There are no published posts for which you can view stats.</p>
            </div>
        </div>
    </div>
@endsection
