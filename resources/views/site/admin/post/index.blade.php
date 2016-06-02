@extends('layouts.admin')

@section('title')
    <title>{{ config('blog.title') }} | Posts</title>
@stop

@section('content')
    <!-- <div class="row">
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
    </div> -->



    <section id="main">

        @include('site.admin.partials.sidebar-navigation')

        <section id="content">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <ol class="breadcrumb">
                            <li><a href="/admin">Home</a></li>
                            <li class="active">Posts</li>
                        </ol>
                        <ul class="actions">
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Refresh Posts</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <h2>Manage Posts
                            <small>This page provides a drag-and-drop interface for assigning a block to a region, and for controlling the order of blocks within regions. Since not all themes implement the same regions, or display regions in the same way, blocks are positioned on a per-theme basis. Remember that your changes will not be saved until you click the Save blocks button at the bottom of the page. Click the configure link next to each block to configure its specific title and visibility settings.</small>
                        </h2>
                    </div>

                    <div class="table-responsive">
                        <table id="data-table-posts" class="table table-condensed table-vmiddle">
                            <thead>
                                <tr>
                                    <th data-column-id="id" data-type="date" data-order="desc">Published</th>
                                    <th data-column-id="sender">Title</th>
                                    <th data-column-id="received">Subtitle</th>
                                    <th data-column-id="commands" data-formatter="commands" data-sortable="false">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $post->published_at)->format('M d, Y') }}</td>
                                            <td>{{ $post->title }}</td>
                                            <td>{{ $post->subtitle }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop