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

                @if($data['posts']['all']->isNotEmpty())
                    <p class="my-4">Discover some valuable insights for you and your content.</p>

                    <div class="d-flex justify-content-between">
                        <div class="text-left">
                            <h1 class="display-4 mb-0">{{ $data['posts']['all']->count() }}</h1>
                            <p class="text-muted font-weight-bold text-uppercase">Total Post(s)</p>
                        </div>

                        <div class="text-left">
                        <h1 class="display-4 mb-0">{{ $data['posts']['published']->count() }}</h1>
                            <p class="text-muted font-weight-bold text-uppercase">Published</p>
                        </div>

                        <div class="text-left">
                        <h1 class="display-4 mb-0">{{ $data['posts']['drafts']->count() }}</h1>
                            <p class="text-muted font-weight-bold text-uppercase">Draft(s)</p>
                        </div>

                        <div class="text-left">
                        <h1 class="display-4 mb-0">{{ $data['posts']['published']->sum('views') }}</h1>
                            <p class="text-muted font-weight-bold text-uppercase">Page View(s)</p>
                        </div>
                    </div>
                @else
                    <p class="mt-4">There are no published posts for which you can view stats.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
