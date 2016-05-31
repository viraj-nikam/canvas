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
                    <div class="block-header">
                        <h2>Data Table</h2>

                        <ul class="actions">
                            <li>
                                <a href="">
                                    <i class="zmdi zmdi-trending-up"></i>
                                </a>
                            </li>
                            <li>
                                <a href="">
                                    <i class="zmdi zmdi-check-all"></i>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="" data-toggle="dropdown">
                                    <i class="zmdi zmdi-more-vert"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <a href="">Refresh</a>
                                    </li>
                                    <li>
                                        <a href="">Manage Widgets</a>
                                    </li>
                                    <li>
                                        <a href="">Widgets Settings</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2>Basic Example
                                <small>It's just that simple. Turn your simple table into a sophisticated data table and
                                    offer your users a nice experience and great features without any effort.
                                </small>
                            </h2>
                        </div>

                        <div class="table-responsive">
                            <!-- <table id="data-table-basic" class="table table-striped">

                            </table> -->
                            <table id="data-table-basic" class="table table-striped">
                                <thead>
                                <tr>
                                    <th data-column-id="published" data-type="date" data-order="desc">Published</th>
                                    <th data-column-id="title">Title</th>
                                    <th data-column-id="subtitle">Subtitle</th>
                                    <th data-column-id="actions">Actions</th>
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
                </div>
            </section>
    </section>
@stop