@extends('canvas::index')

@section('actions')
    <a href="{{ route('canvas.topic.create') }}" class="btn btn-sm btn-outline-primary my-auto mx-3">
        New topic
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mb-4 mt-2">Topics</h1>

                @if(count($data['topics']))
                    @foreach($data['topics'] as $topic)
                        <div class="d-flex border-top py-3 align-items-center">
                            <div class="mr-auto">
                                <p class="mb-0 py-1">
                                    <a href="{{ route('canvas.topic.edit', $topic->id) }}"
                                       class="font-weight-bold lead">{{ $topic->name }}</a>
                                </p>
                            </div>
                            <div class="ml-auto">
                                <span class="text-muted mr-3">{{ $topic->posts_count }} Post(s)</span>
                                Created {{ \Carbon\Carbon::parse($topic->created_at)->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-center">
                        {{ $data['topics']->links() }}
                    </div>
                @else
                    <p class="mt-4">No topics were found, start by <a href="{{ route('canvas.topic.create') }}">adding a new
                            topic</a>.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
