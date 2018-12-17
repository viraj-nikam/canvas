@extends('canvas::canvas.index')

@section('actions')
    <a href="{{ route('canvas.index') }}" class="btn btn-sm btn-outline-primary mr-2 my-auto mx-3">
        See all stats
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="mt-1">{{ $data['post']->title }}</h1>
                <p class="text-muted mb-4">Published
                    on {{ \Carbon\Carbon::parse($data['post']->published_at)->format('F d, Y') }}</p>

                <view-stats :views="{{ $data['views'] }}"></view-stats>
            </div>

            <div class="col-md-5 mt-4">
                <h5 class="card-title text-muted small text-uppercase font-weight-bold">Views by Traffic Source</h5>
                @foreach($data['traffic'] as $host => $views)
                    <div class="d-flex border-top py-2 align-items-center">
                        <div class="mr-auto">
                            <p class="mb-0 py-2">
                                {{ $host }}
                            </p>
                        </div>
                        <div class="ml-auto">
                            <span class="text-muted">{{ $views }} View(s)</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-5 mt-4">
                <h5 class="card-title text-muted small text-uppercase font-weight-bold">Popular Reading Times</h5>
                @foreach($data['popular_reading_times'] as $time => $percentage)
                    <div class="d-flex py-2 border-top align-items-center">
                        <div class="mr-auto">
                            <p class="mb-0 py-2">
                                {{ $time }}
                            </p>
                        </div>
                        <div class="ml-auto">
                            <span class="text-muted">{{ sprintf('%s%s', $percentage, '%') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
