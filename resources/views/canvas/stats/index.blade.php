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

                @if($data['posts']->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0 mt-4">
                            <tbody>

                            <tr class="border-top">
                                <td>
                                    <p class="mb-0 py-2 font-weight-bold lead">Content</p>
                                </td>
                                <td class="text-right align-middle">
                                    <p class="mb-0">
                                        <span class="text-muted mr-3">{{ $data['posts']->count() }} Published Post(s)</span>
                                    </p>
                                </td>
                            </tr>

                            <tr class="border-top">
                                <td>
                                    <p class="mb-0 py-2 font-weight-bold lead">Visibility</p>
                                </td>
                                <td class="text-right align-middle">
                                    <p class="mb-0">
                                        <span class="text-muted mr-3">{{ $data['posts']->sum('views') }} Total View(s)</span>
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="mt-4">There are no published posts for which you can view stats.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
