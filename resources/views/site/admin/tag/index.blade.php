@extends('admin')

@section('title')
    <title>{{ config('blog.title') }} | Tags</title>
@stop

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-12">
                <h1 class="page-header">Tags
                    <a href="/admin/tag/create" class="btn btn-success btn-sm btn-outline btn-sm"><i class="fa fa-fw fa-plus"></i> New Tag</a>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @include('shared.errors')

                @include('shared.success')
                <div class="table-responsive">
                    <table id="tags-table" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Tag</th>
                            <th>Title</th>
                            <th class="hidden-sm">Subtitle</th>
                            <th class="hidden-md">Page Image</th>
                            <th class="hidden-md">Meta Description</th>
                            <th class="hidden-md">Layout</th>
                            <th class="hidden-sm">Direction</th>
                            <th data-sortable="false">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tags as $tag)
                            <tr>
                                <td>{{ $tag->tag }}</td>
                                <td>{{ $tag->title }}</td>
                                <td class="hidden-sm">{{ $tag->subtitle }}</td>
                                <td class="hidden-md">{{ $tag->page_image }}</td>
                                <td class="hidden-md">{{ $tag->meta_description }}</td>
                                <td class="hidden-md">{{ $tag->layout }}</td>
                                <td class="hidden-sm">
                                    @if ($tag->reverse_direction)
                                        Reverse
                                    @else
                                        Normal
                                    @endif
                                </td>
                                <td>
                                    <a href="/admin/tag/{{ $tag->id }}/edit" class="btn btn-xs btn-primary btn-outline"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(function () {
            $("#tags-table").DataTable({
                "order": [[0, "desc"]]
            });
        });
    </script>
@stop