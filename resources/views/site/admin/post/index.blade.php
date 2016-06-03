@extends('layouts.admin')

@section('title')
    <title>{{ config('blog.title') }} | Posts</title>
@stop

@section('content')
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
                        <h2>Manage Posts&nbsp;&nbsp;<a href="/admin/post/create" data-toggle="tooltip" data-placement="right" title="" data-original-title="Create a New Post"><i class="zmdi zmdi-plus-circle"></i></a>
                            <small>This page provides a comprehensive overview of all current blog posts. Click the edit or preview links next to each post to modify specific details, publish a post or view any changes from the browser.</small>
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

@section('unique-js')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#data-table-posts").bootgrid({
                css: {
                    icon: 'zmdi icon',
                    iconColumns: 'zmdi-view-module',
                    iconDown: 'zmdi-sort-amount-desc',
                    iconRefresh: 'zmdi-refresh',
                    iconUp: 'zmdi-sort-amount-asc'
                },
                formatters: {
                    "commands": function(column, row) {
                        return "<a href='/admin/post/{{ $post->id }}/edit'><button type=\"button\" class=\"btn btn-icon command-edit waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-edit\"></span></button></a> " +
                                " <a href='/blog/{{ $post->slug }}'><button type=\"button\" class=\"btn btn-icon command-delete waves-effect waves-circle\" data-row-id=\"" + row.id + "\"><span class=\"zmdi zmdi-search\"></span></button></a>";
                    }
                }
            });
        });
    </script>
@stop
