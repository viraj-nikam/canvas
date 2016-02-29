@extends('admin.layout')

@section('title')
    <title>Todd Austin | Posts</title>
@stop

@section('content')
    <div class="container">
        <div class="row page-title-row">
            <div class="col-md-12">
                <h1 class="page-header">Posts
                    <a href="/admin/post/create" class="btn btn-default btn-md btn-outline btn-sm"><i class="fa fa-fw fa-plus"></i> New Post</a>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                @include('admin.partials.errors')
                @include('admin.partials.success')
                <div class="table-responsive">
                    <table id="posts-table" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Published</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th data-sortable="false">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td data-order="{{ $post->published_at->timestamp }}">{{ $post->published_at->format('j-M-y g:ia') }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->subtitle }}</td>
                                <td>
                                    <a href="/admin/post/{{ $post->id }}/edit" class="btn btn-xs btn-default btn-outline"><i class="fa fa-fw fa-edit"></i> Edit</a>
                                    <a href="/blog/{{ $post->slug }}" target="_blank" class="btn btn-xs btn-default btn-outline"><i class="fa fa-fw fa-eye"></i> Preview</a>
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
            $("#posts-table").DataTable({
                "order": [[0, "desc"]]
            });
        });
    </script>
@stop