@extends('backend.layout')

@section('title')
    <title>{{ config('blog.title') }} | Posts</title>
@stop

@section('content')
    <section id="main">
        @include('backend.partials.sidebar-navigation')
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

                        @include('shared.errors')
                        @include('shared.success')

                        <h2>Manage Posts&nbsp;
                            <a href="/admin/post/create" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Create a New Post"><i class="zmdi zmdi-plus-circle"></i></a>
                            <small>This page provides a comprehensive overview of all current blog posts. Click the edit or preview links next to each post to modify specific details, publish a post or view any changes from the browser.</small>
                        </h2>
                    </div>

                    @if(empty($posts))

                        <p class="small">No posts yet.</p>

                    @else

                        <div class="table-responsive">
                            <table id="data-table-posts" class="table table-condensed table-vmiddle">
                                <thead>
                                    <tr>
                                        <th data-column-id="published" data-type="date" data-order="desc">Published</th>
                                        <th data-column-id="title">Title</th>
                                        <th data-column-id="subtitle">Subtitle</th>
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
                    @endif
                </div>
            </div>
        </section>
    </section>
@stop

@section('unique-js')
    @if(Session::get('_login'))
        @include('backend.post.partials.login-notification')
        {{ \Session::forget('_login') }}
    @endif

    @include('backend.post.partials.datatable')
@stop
