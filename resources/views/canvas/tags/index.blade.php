@extends('canvas::canvas.index')

@section('actions')
    <a href="{{ route('canvas.tag.create') }}" class="btn btn-sm btn-outline-primary mr-2 my-auto mx-3">
        New Tag
    </a>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1>Tags</h1>

                @include('canvas::canvas.components.notifications.success')
                @include('canvas::canvas.components.notifications.error')

                @if(count($data['tags']))
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0 mt-4">
                                <tbody>
                                @foreach($data['tags'] as $tag)
                                    <tr class="border-top">
                                        <td>
                                            <p class="mb-0 py-2">
                                                <a href="{{ route('canvas.tag.edit', $tag->id) }}"
                                                   class="font-weight-bold lead">{{ $tag->name }}</a>
                                                <br>
                                        </td>
                                        <td class="text-right align-middle">
                                            <p>
                                                <span class="text-muted mr-3">{{ $tag->posts_count }} Post(s)</span>
                                                Created {{ \Carbon\Carbon::parse($tag->created_at)->diffForHumans() }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $data['tags']->links() }}
                    </div>
                @else
                    <p class="mt-4">No tags were found, start by <a href="{{ route('canvas.tag.create') }}">adding a new tag</a>.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
