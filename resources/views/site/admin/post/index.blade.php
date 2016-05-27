@extends('layouts.admin')

@section('title')
    <title>{{ config('blog.title') }} | Posts</title>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="page-header">
                <ul class="breadcrumb">
                    <li><a href="/admin">Home</a></li>
                    <li class="active">Posts</li>
                </ul>
                <a href="/admin/post/create" class="btn btn-success btn-sm"><i class="material-icons">add_circle</i>&nbsp;&nbsp;New Post</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            @include('shared.errors')
            @include('shared.success')
            <table id="posts-table" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Published</th>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->published_at->format('j-M-y g:ia') }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->subtitle }}</td>
                            <td>
                                <a href="/admin/post/{{ $post->id }}/edit" class="btn btn-xs btn-primary"><i class="material-icons">mode_edit</i>&nbsp;&nbsp;Edit</a>
                                &nbsp;
                                <a href="/blog/{{ $post->slug }}" target="_blank" class="btn btn-xs btn-success"><i class="material-icons">visibility</i>&nbsp;&nbsp;Preview</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop